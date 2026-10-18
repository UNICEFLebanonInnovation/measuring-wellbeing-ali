# Operations guide

Day-2 operations for the platform on Azure. Resource names follow `mwb-<env>-<role>` (see `infra/README.md`). Replace `ENV` with `staging` or `prod`.

```bash
ENV=prod; RG=rg-mwb-$ENV; PREFIX=mwb-$ENV
```

## Logs and diagnostics

Live tail of a container app:

```bash
az containerapp logs show -g $RG -n $PREFIX-web --follow --tail 100
az containerapp logs show -g $RG -n $PREFIX-worker --follow
```

Log Analytics (portal > `mwb-ENV-log` > Logs). Useful KQL:

```kusto
// Application errors in the last hour
ContainerAppConsoleLogs_CL
| where TimeGenerated > ago(1h)
| where ContainerAppName_s startswith "mwb-"
| where Log_s has_any ("ERROR", "CRITICAL", "exception")
| project TimeGenerated, ContainerAppName_s, RevisionName_s, Log_s
| order by TimeGenerated desc

// Requests and 5xx by revision (Caddy JSON access log)
ContainerAppConsoleLogs_CL
| where ContainerAppName_s == "mwb-prod-web"
| extend j = parse_json(Log_s)
| where isnotempty(j.status)
| summarize requests = count(), errors = countif(toint(j.status) >= 500) by RevisionName_s, bin(TimeGenerated, 5m)

// System events (scaling, probe failures, pulls)
ContainerAppSystemLogs_CL
| where TimeGenerated > ago(6h)
| project TimeGenerated, ContainerAppName_s, Reason_s, Log_s
```

Migration job history:

```bash
az containerapp job execution list -g $RG -n $PREFIX-migrate -o table
az containerapp job logs show -g $RG -n $PREFIX-migrate --execution <name> --container migrate
```

## Running artisan commands

```bash
# interactive shell in the running web replica
az containerapp exec -g $RG -n $PREFIX-web --command bash
php artisan about
php artisan queue:failed
php artisan tinker
```

The container runs as `www-data`; files under `/app` are read-only except `storage/`.

### Creating an administrator

```bash
az containerapp exec -g $RG -n $PREFIX-web --command bash
SDQ_ADMIN_EMAIL=someone@unicef.org SDQ_ADMIN_PASSWORD='<temporary strong password>' \
  php artisan db:seed --class=AdminUserSeeder --force
```

Ask the person to change the password immediately through "Forgot password". Alternatively add them from Administrators in the UI, which emails a set-up link.

### Resending a set-up link or unlocking an account

Administrators > the user > "Resend set-up email", or toggle Active. From the shell: `php artisan tinker` then `App\Support\Accounts::sendSetupLink(App\Models\User::where('email', '...')->first())`.

## Deployments

- `main` auto-deploys to staging; production is the Deploy workflow with `environment=prod` and reviewer approval. From a workstation with Docker and the Azure CLI: `scripts/build-and-push.sh <env> --deploy`.
- Each deploy runs the migrate job first; if it fails the apps are not updated.
- Roll back by re-running Deploy on the previous commit, or instantly by activating the previous revision:

```bash
az containerapp revision list -g $RG -n $PREFIX-web -o table
az containerapp ingress traffic set -g $RG -n $PREFIX-web --revision-weight <previous revision>=100
```

(Revisions are in Single mode; the above switches the active revision. Database migrations are additive, so an older image runs on the newer schema.)

## Scaling

```bash
az containerapp update -g $RG -n $PREFIX-web --min-replicas 2 --max-replicas 8
az mysql flexible-server update -g $RG -n $PREFIX-mysql --sku-name Standard_D4ds_v4 --tier GeneralPurpose
```

Change the parameter file as well so the next Bicep deployment does not revert it.

## Backups and restore

MySQL Flexible Server takes automated backups (retention set in Bicep: 7 days staging, 35 days geo-redundant prod). Point-in-time restore creates a **new** server:

```bash
az mysql flexible-server restore -g $RG -n $PREFIX-mysql-restored \
  --source-server $PREFIX-mysql --restore-time "2026-10-18T06:00:00Z"
```

Then either point the apps at it (`DB_HOST` in Bicep/`az containerapp update --set-env-vars`) or dump/restore the needed tables into the original server. Manual logical backup before risky operations:

```bash
mysqldump -h $PREFIX-mysql.mysql.database.azure.com -u sdqadmin -p --ssl-mode=REQUIRED \
  --single-transaction --default-character-set=utf8mb4 sdq | gzip > sdq_$(date +%F).sql.gz
az storage blob upload --account-name mwb${ENV}st -c exports -f sdq_*.sql.gz --auth-mode login
```

## Secrets rotation

| Secret | Where | How |
|---|---|---|
| `APP_KEY` | Key Vault `app-key` | Rotating invalidates sessions and encrypted values; only on compromise. Set the new value, restart all apps. |
| DB password | MySQL server + Key Vault `db-password` | `az mysql flexible-server update --admin-password` then `az keyvault secret set`, then restart apps (section in `infra/README.md`). |
| SMTP password | Key Vault `mail-password` | `az keyvault secret set`, restart worker and web. |
| GitHub OIDC | Entra app registration | No secret; federated credential. Remove and recreate if the repository is renamed. |
| Legacy `users.api_token` | database | Clearing the column signs out every old APK; do it when retiring the legacy API. |

Container Apps resolve Key Vault references at revision start; after setting a secret, restart or create a new revision.

## Common failures

| Symptom | Likely cause | Fix |
|---|---|---|
| Web replica keeps restarting, `/up` fails | `APP_KEY` placeholder still `REPLACE-ME`, or DB unreachable | Check `az containerapp logs show`; set secrets; check MySQL firewall "Allow Azure services" rule |
| `SQLSTATE[HY000] [2002]` or TLS errors | `MYSQL_ATTR_SSL_CA` missing or MySQL firewall | Both are set by Bicep; verify env with `az containerapp show --query properties.template.containers[0].env` |
| Migrate job fails on `Duplicate column` | Dump already carried a column with a different name case | Inspect the job log; migrations are guarded by `hasColumn`, so this indicates a dump/schema mismatch to fix by hand |
| Mails not sent | `MAIL_HOST` empty (log driver) or worker stopped | Set mail parameters and secret; check `php artisan queue:failed` in the worker |
| Partner logo missing after a deploy | Local filesystem is ephemeral | Known limitation until the Blob Storage filesystem adapter is added |
| Image pull error | Identity lost AcrPull, or wrong ACR name in variables | Re-run the Bicep deployment; check `ACR_NAME_*` repository variables |
| 419 on form submit | Session cookie not secure or `APP_URL` mismatch | `APP_URL` must be the public https URL; `SESSION_SECURE_COOKIE=true` |

## Costs

Watch the resource group cost analysis monthly; MySQL is the main item. Staging web scales to zero when idle. Set a budget alert on each resource group (follow-up in `infra/README.md`).
