using '../main.bicep'

param environmentName = 'staging'
param project = 'mwb'
param appUrl = 'https://staging.measuringwellbeing.org'
param customDomain = ''

// Secrets come from the environment at deploy time:
//   export MYSQL_ADMIN_PASSWORD=... ; export APP_KEY=$(php artisan key:generate --show)
param mysqlAdministratorPassword = readEnvironmentVariable('MYSQL_ADMIN_PASSWORD', '')
param appKey = readEnvironmentVariable('APP_KEY', '')
param cicdPrincipalId = readEnvironmentVariable('CICD_PRINCIPAL_ID', '')
// Image to run. Empty on the first deployment (platform without the apps);
// afterwards the current image, e.g. export IMAGE=mwbstagingacr.azurecr.io/measuring-wellbeing:<tag>
param image = readEnvironmentVariable('IMAGE', '')

param mysqlSkuName = 'Standard_B1ms'
param mysqlSkuTier = 'Burstable'
param mysqlStorageSizeGB = 32
param mysqlBackupRetentionDays = 7

param webMinReplicas = 0
param webMaxReplicas = 2
param webCpu = '0.5'
param webMemory = '1Gi'

param mailHost = ''
param sdqScoringPolicy = 'documented'
param sdqApkUrl = ''
