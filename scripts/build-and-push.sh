#!/usr/bin/env bash
#
# Build the production image, push it to the environment's Azure Container
# Registry and, with --deploy, run the migrate job and roll the image out to
# the web, worker and scheduler container apps.
#
#   scripts/build-and-push.sh staging            # build + push
#   scripts/build-and-push.sh staging --deploy   # build + push + migrate + update apps
#   scripts/build-and-push.sh prod --deploy --tag v2.0.0
#
# Requirements: Docker, Azure CLI signed in (az login) with push rights on the
# registry (AcrPush) and Contributor on the resource group for --deploy.
# Resource names follow infra/README.md and can be overridden with
# RG, ACR and PREFIX environment variables.
set -euo pipefail

usage() { sed -n '2,16p' "$0" | sed 's/^# \{0,1\}//'; exit 1; }

ENV_NAME="${1:-}"; shift || true
[[ "$ENV_NAME" == "staging" || "$ENV_NAME" == "prod" ]] || usage

DEPLOY=false
BUILD=true
TAG="$(git rev-parse --short=12 HEAD 2>/dev/null || date +%Y%m%d%H%M%S)"
while [[ $# -gt 0 ]]; do
  case "$1" in
    --deploy) DEPLOY=true ;;
    --no-build) BUILD=false ;;
    --tag) TAG="$2"; shift ;;
    -h|--help) usage ;;
    *) echo "Unknown option: $1" >&2; usage ;;
  esac
  shift
done

RG="${RG:-rg-mwb-$ENV_NAME}"
PREFIX="${PREFIX:-mwb-$ENV_NAME}"
ACR="${ACR:-mwb${ENV_NAME}acr}"
REPO="measuring-wellbeing"
IMAGE="$ACR.azurecr.io/$REPO:$TAG"
LATEST="$ACR.azurecr.io/$REPO:$ENV_NAME-latest"
ROOT="$(cd "$(dirname "$0")/.." && pwd)"

echo "Environment : $ENV_NAME"
echo "Registry    : $ACR.azurecr.io"
echo "Image       : $IMAGE"

az account show --query '{subscription:name, user:user.name}' -o table

echo "==> Signing in to the registry"
az acr login --name "$ACR"

if $BUILD; then
  echo "==> Building the image (linux/amd64)"
  # Container Apps run amd64; --platform matters on Apple Silicon and other arm64 machines.
  docker build --platform linux/amd64 -t "$IMAGE" -t "$LATEST" "$ROOT"
fi

echo "==> Pushing"
docker push "$IMAGE"
docker push "$LATEST"

if ! $DEPLOY; then
  cat <<MSG

Image pushed. To roll it out:
  scripts/build-and-push.sh $ENV_NAME --deploy --no-build --tag $TAG
or, for the first deployment, deploy the infrastructure with it:
  export IMAGE=$IMAGE
  az deployment group create -g $RG -f infra/main.bicep -p infra/params/$ENV_NAME.bicepparam
MSG
  exit 0
fi

echo "==> Running database migrations ($PREFIX-migrate)"
az extension add --name containerapp --upgrade --only-show-errors >/dev/null
az containerapp job update -g "$RG" -n "$PREFIX-migrate" --image "$IMAGE" --only-show-errors >/dev/null
EXEC="$(az containerapp job start -g "$RG" -n "$PREFIX-migrate" --query name -o tsv)"
echo "    execution $EXEC"
for _ in $(seq 1 120); do
  STATUS="$(az containerapp job execution show -g "$RG" -n "$PREFIX-migrate" --job-execution-name "$EXEC" --query properties.status -o tsv)"
  case "$STATUS" in
    Succeeded) echo "    migrations succeeded"; break ;;
    Failed|Stopped|Degraded)
      echo "Migration job $STATUS. Logs:" >&2
      az containerapp job logs show -g "$RG" -n "$PREFIX-migrate" --execution "$EXEC" --container migrate 2>/dev/null || true
      exit 1 ;;
    *) sleep 10 ;;
  esac
done
[[ "$STATUS" == "Succeeded" ]] || { echo "Timed out waiting for the migration job" >&2; exit 1; }

echo "==> Updating container apps"
for app in web worker scheduler; do
  echo "    $PREFIX-$app"
  az containerapp update -g "$RG" -n "$PREFIX-$app" --image "$IMAGE" \
    --revision-suffix "t$(date +%s)" --only-show-errors >/dev/null
done

FQDN="$(az containerapp show -g "$RG" -n "$PREFIX-web" --query properties.configuration.ingress.fqdn -o tsv)"
echo "==> Waiting for https://$FQDN/up"
for _ in $(seq 1 30); do
  if curl -fsS "https://$FQDN/up" >/dev/null; then
    echo "Deployed: https://$FQDN"
    exit 0
  fi
  sleep 10
done
echo "Health check failed; inspect with: az containerapp logs show -g $RG -n $PREFIX-web --tail 100" >&2
exit 1
