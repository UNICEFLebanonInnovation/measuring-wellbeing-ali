using '../main.bicep'

param environmentName = 'prod'
param project = 'mwb'
param appUrl = 'https://measuringwellbeing.org'
// Set once DNS is ready (see infra/README.md, "Custom domain").
param customDomain = ''

param mysqlAdministratorPassword = readEnvironmentVariable('MYSQL_ADMIN_PASSWORD', '')
param appKey = readEnvironmentVariable('APP_KEY', '')
param cicdPrincipalId = readEnvironmentVariable('CICD_PRINCIPAL_ID', '')

param mysqlSkuName = 'Standard_D2ds_v4'
param mysqlSkuTier = 'GeneralPurpose'
param mysqlStorageSizeGB = 64
param mysqlBackupRetentionDays = 35
param mysqlGeoRedundantBackup = 'Enabled'
param mysqlHighAvailability = 'Disabled'

param webMinReplicas = 1
param webMaxReplicas = 5
param webCpu = '1'
param webMemory = '2Gi'

param logRetentionInDays = 90

param mailHost = ''
param mailFromAddress = 'noreply@measuringwellbeing.org'
param sdqScoringPolicy = 'documented'
param sdqApkUrl = 'https://measuringwellbeing.org/apk/sdq-10.apk'
