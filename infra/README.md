# Azure infrastructure

Everything the platform needs in Azure is declared in Bicep under this folder and deployed per environment (`staging`, `prod`) into its own resource group.

| Resource | Name pattern | Purpose |
|---|---|---|
| Log Analytics + Application Insights | `mwb-<env>-log`, `mwb-<env>-appi` | Container logs, request telemetry |
| User-assigned identity | `mwb-<env>-id` | Pulls images from ACR, reads Key Vault secrets, writes blobs |
| Container Registry | `mwb<env>acr` | Application image |
| Key Vault | `mwb-<env>-kv` | `app-key`, `db-password`, `mail-password` |
| Storage account | `mwb<env>st` | `public` (logos, APK) and `exports` containers |
| MySQL Flexible Server | `mwb-<env>-mysql` | Database `sdq`, utf8mb4, TLS enforced |
| Container Apps environment | `mwb-<env>-cae` | Hosts the apps below |
| Container Apps | `mwb-<env>-web`, `-worker`, `-scheduler` | Same image, `CONTAINER_ROLE` differs |
| Container Apps job | `mwb-<env>-migrate` | Runs migrations and seeders before each deploy |

## One-time setup

```bash
az login
az account set --subscription "<subscription id>"
az extension add --name containerapp --upgrade
az bicep upgrade

ENV=staging                      # or prod
RG=rg-mwb-$ENV
LOCATION=westeurope              # closest region with MySQL Flexible + Container Apps

az group create -n $RG -l $LOCATION
```

Generate the secrets the deployment needs (never commit them):

```bash
export MYSQL_ADMIN_PASSWORD="$(openssl rand -base64 24)"
export APP_KEY="base64:$(openssl rand -base64 32)"
# Optional: object id of the GitHub OIDC service principal (see "CI/CD identity")
export CICD_PRINCIPAL_ID=""
```

Deploy (what-if first):

```bash
az deployment group what-if -g $RG -f infra/main.bicep -p infra/params/$ENV.bicepparam
az deployment group create  -g $RG -f infra/main.bicep -p infra/params/$ENV.bicepparam \
  --name "infra-$(date +%Y%m%d%H%M)"
```

The first deployment runs the public quick-start image because the registry is empty. Build and push the real image (or run the `deploy.yml` workflow) and the apps are updated to it.

Read the outputs:

```bash
az deployment group show -g $RG -n <deployment name> --query properties.outputs -o json
# web FQDN only
az containerapp show -g $RG -n mwb-$ENV-web --query properties.configuration.ingress.fqdn -o tsv
```

### Secrets after the first deployment

If `MYSQL_ADMIN_PASSWORD` / `APP_KEY` were exported before deploying, Key Vault already holds them. Otherwise, or to rotate:

```bash
KV=mwb-$ENV-kv
az keyvault secret set --vault-name $KV -n app-key       --value "$APP_KEY"
az keyvault secret set --vault-name $KV -n db-password   --value "$MYSQL_ADMIN_PASSWORD"
az keyvault secret set --vault-name $KV -n mail-password --value "<smtp password>"
# Container Apps cache Key Vault references; restart to pick up new values
for app in web worker scheduler; do
  az containerapp revision restart -g $RG -n mwb-$ENV-$app \
    --revision "$(az containerapp revision list -g $RG -n mwb-$ENV-$app --query '[0].name' -o tsv)"
done
```

The MySQL administrator password lives in two places (the server and Key Vault). Rotate it with `az mysql flexible-server update --admin-password` **and** `az keyvault secret set`.

### Mail

Set `mailHost`, `mailUsername`, `mailPort`, `mailEncryption` in the parameter file (Microsoft 365 SMTP relay, SendGrid or the GoDaddy relay used today) and put the password in the `mail-password` secret. With `mailHost` empty the app logs mail instead of sending it.

### Custom domain (production)

1. Create the DNS records at the registrar: `CNAME measuringwellbeing.org -> <web fqdn>` (or an `A` record to the environment static IP from the outputs) and the `TXT asuid.measuringwellbeing.org` record whose value is `az containerapp show ... --query properties.customDomainVerificationId`.
2. Bind the domain with a managed certificate:
   ```bash
   az containerapp hostname add  -g $RG -n mwb-prod-web --hostname measuringwellbeing.org
   az containerapp hostname bind -g $RG -n mwb-prod-web --hostname measuringwellbeing.org \
     --environment mwb-prod-cae --validation-method CNAME
   ```
3. Set `customDomain = 'measuringwellbeing.org'` in `prod.bicepparam` so later Bicep deployments keep the binding.

### CI/CD identity (GitHub OIDC)

```bash
APP_NAME=gh-measuring-wellbeing
az ad app create --display-name $APP_NAME
APP_ID=$(az ad app list --display-name $APP_NAME --query '[0].appId' -o tsv)
az ad sp create --id $APP_ID
SP_OBJECT_ID=$(az ad sp show --id $APP_ID --query id -o tsv)

# Federated credential for the repository (main branch, and the "production" environment)
az ad app federated-credential create --id $APP_ID --parameters '{
  "name": "github-main",
  "issuer": "https://token.actions.githubusercontent.com",
  "subject": "repo:UNICEFLebanonInnovation/measuring-wellbeing-ali:ref:refs/heads/main",
  "audiences": ["api://AzureADTokenExchange"]}'
az ad app federated-credential create --id $APP_ID --parameters '{
  "name": "github-production-env",
  "issuer": "https://token.actions.githubusercontent.com",
  "subject": "repo:UNICEFLebanonInnovation/measuring-wellbeing-ali:environment:production",
  "audiences": ["api://AzureADTokenExchange"]}'

# Contributor on both resource groups (deploys apps and runs jobs)
for ENV in staging prod; do
  az role assignment create --assignee-object-id $SP_OBJECT_ID --assignee-principal-type ServicePrincipal \
    --role Contributor --scope "/subscriptions/$(az account show --query id -o tsv)/resourceGroups/rg-mwb-$ENV"
done
# Re-run the Bicep deployment with CICD_PRINCIPAL_ID=$SP_OBJECT_ID so it gets AcrPush + Key Vault Secrets Officer
```

GitHub repository settings:

- Secrets: `AZURE_CLIENT_ID` (= `$APP_ID`), `AZURE_TENANT_ID`, `AZURE_SUBSCRIPTION_ID`.
- Variables: `AZURE_RG_STAGING=rg-mwb-staging`, `AZURE_RG_PROD=rg-mwb-prod`, `ACR_NAME_STAGING=mwbstagingacr`, `ACR_NAME_PROD=mwbprodacr`, `APP_PREFIX_STAGING=mwb-staging`, `APP_PREFIX_PROD=mwb-prod`.
- Environment `production` with required reviewers (the deploy workflow waits for approval before touching prod).

## Running the migrate job by hand

```bash
az containerapp job start -g $RG -n mwb-$ENV-migrate
az containerapp job execution list -g $RG -n mwb-$ENV-migrate -o table
```

## Cost (indicative, West Europe, October 2026 list prices)

| Environment | Main items | Approx. per month |
|---|---|---|
| staging | MySQL B1ms 32 GB, Container Apps consumption (scale to zero), Log Analytics, ACR Basic | USD 40 to 60 |
| prod | MySQL D2ds_v4 64 GB with 35-day geo-redundant backup, web 1 to 5 replicas at 1 vCPU, worker + scheduler, Log Analytics 90 days | USD 250 to 350 |

MySQL is the dominant cost. The Burstable tier is enough for production too if traffic stays at the 2022 level (a dozen partners); start with `Standard_B2s` and scale up if needed.

## Follow-ups not covered here

- Private networking (VNet-integrated Container Apps environment and private MySQL endpoint). The public-with-firewall setup is adequate for a first cutover; switch when a security review requires it.
- Azure Blob Storage as the Laravel filesystem (partner logos, exports). The app currently uses the local disk of the web container, which is ephemeral; see README status table.
- Alerts (availability test on `/up`, failed job executions, MySQL CPU and storage) and a budget alert on each resource group.
