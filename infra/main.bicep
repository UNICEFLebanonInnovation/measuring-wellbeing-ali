// Measuring Well-Being platform - Azure infrastructure (resource group scope).
//
//   az deployment group create -g rg-mwb-staging -f infra/main.bicep -p infra/params/staging.bicepparam
//
// Composes: monitoring, identity, container registry, key vault, storage,
// MySQL Flexible Server and the Container Apps (web, worker, scheduler, migrate job).
targetScope = 'resourceGroup'

@allowed(['staging', 'prod'])
param environmentName string
param location string = resourceGroup().location
@description('Short project code used in resource names (letters/numbers/hyphen).')
param project string = 'mwb'
param tags object = {
  project: 'measuring-wellbeing'
  owner: 'unicef-lebanon-innovation'
}

@description('Image to run. On first deployment use the public placeholder; the deploy workflow updates the apps with the real image.')
param image string = 'mcr.microsoft.com/k8se/quickstart:latest'

@description('Public URL of the application (APP_URL).')
param appUrl string
param customDomain string = ''

@secure()
param mysqlAdministratorPassword string
param mysqlAdministratorLogin string = 'sdqadmin'
param mysqlSkuName string = 'Standard_B1ms'
@allowed(['Burstable', 'GeneralPurpose', 'MemoryOptimized'])
param mysqlSkuTier string = 'Burstable'
param mysqlStorageSizeGB int = 32
param mysqlBackupRetentionDays int = 7
@allowed(['Enabled', 'Disabled'])
param mysqlGeoRedundantBackup string = 'Disabled'
@allowed(['Enabled', 'Disabled'])
param mysqlHighAvailability string = 'Disabled'
param mysqlAllowedIpRanges array = []

@secure()
@description('Optional initial APP_KEY (base64:...). If empty, set the "app-key" secret manually before the first deploy.')
param appKey string = ''

@description('Object id of the GitHub OIDC service principal (gets AcrPush and Key Vault Secrets Officer). Optional.')
param cicdPrincipalId string = ''

param webMinReplicas int = 1
param webMaxReplicas int = 5
param webCpu string = '0.5'
param webMemory string = '1Gi'
param allowPublicBlobRead bool = false
param logRetentionInDays int = 30

param mailHost string = ''
param mailPort string = '587'
param mailUsername string = ''
param mailFromAddress string = 'noreply@measuringwellbeing.org'
param mailEncryption string = 'tls'

param sdqScoringPolicy string = 'documented'
param sdqMaxNaAnswers string = '3'
param sdqCodeFormat string = '{year}-{partner}-{collector}-{n}'
param sdqQuotaPerYear string = 'true'
param sdqApkUrl string = ''

var namePrefix = '${project}-${environmentName}'

module monitoring 'modules/monitoring.bicep' = {
  name: 'monitoring'
  params: {
    location: location
    namePrefix: namePrefix
    tags: tags
    retentionInDays: logRetentionInDays
  }
}

module identity 'modules/identity.bicep' = {
  name: 'identity'
  params: {
    location: location
    namePrefix: namePrefix
    tags: tags
  }
}

module registry 'modules/container-registry.bicep' = {
  name: 'registry'
  params: {
    location: location
    namePrefix: namePrefix
    tags: tags
    pullPrincipalId: identity.outputs.principalId
    pushPrincipalId: cicdPrincipalId
  }
}

module keyVault 'modules/key-vault.bicep' = {
  name: 'key-vault'
  params: {
    location: location
    namePrefix: namePrefix
    tags: tags
    readerPrincipalId: identity.outputs.principalId
    kvOfficerObjectId: cicdPrincipalId
    initialDbPassword: mysqlAdministratorPassword
    initialAppKey: appKey
  }
}

module storage 'modules/storage.bicep' = {
  name: 'storage'
  params: {
    location: location
    namePrefix: namePrefix
    tags: tags
    allowPublicBlobRead: allowPublicBlobRead
    blobContributorPrincipalId: identity.outputs.principalId
  }
}

module mysql 'modules/mysql.bicep' = {
  name: 'mysql'
  params: {
    location: location
    namePrefix: namePrefix
    tags: tags
    administratorLogin: mysqlAdministratorLogin
    administratorPassword: mysqlAdministratorPassword
    skuName: mysqlSkuName
    skuTier: mysqlSkuTier
    storageSizeGB: mysqlStorageSizeGB
    backupRetentionDays: mysqlBackupRetentionDays
    geoRedundantBackup: mysqlGeoRedundantBackup
    highAvailability: mysqlHighAvailability
    allowedIpRanges: mysqlAllowedIpRanges
  }
}

module apps 'modules/container-apps.bicep' = {
  name: 'container-apps'
  params: {
    location: location
    namePrefix: namePrefix
    tags: tags
    environmentName: environmentName
    image: image
    registryLoginServer: registry.outputs.loginServer
    identityId: identity.outputs.id
    identityClientId: identity.outputs.clientId
    workspaceCustomerId: monitoring.outputs.workspaceCustomerId
    workspaceSharedKey: monitoring.outputs.workspaceSharedKey
    appInsightsConnectionString: monitoring.outputs.appInsightsConnectionString
    appKeySecretUri: keyVault.outputs.appKeySecretUri
    dbCredentialRef: keyVault.outputs.dbCredentialRef
    mailCredentialRef: keyVault.outputs.mailCredentialRef
    dbHost: mysql.outputs.fqdn
    dbDatabase: mysql.outputs.databaseName
    dbUsername: mysql.outputs.administratorLogin
    appUrl: appUrl
    customDomain: customDomain
    webMinReplicas: webMinReplicas
    webMaxReplicas: webMaxReplicas
    webCpu: webCpu
    webMemory: webMemory
    mailHost: mailHost
    mailPort: mailPort
    mailUsername: mailUsername
    mailFromAddress: mailFromAddress
    mailEncryption: mailEncryption
    sdqScoringPolicy: sdqScoringPolicy
    sdqMaxNaAnswers: sdqMaxNaAnswers
    sdqCodeFormat: sdqCodeFormat
    sdqQuotaPerYear: sdqQuotaPerYear
    sdqApkUrl: sdqApkUrl
  }
}

output registryLoginServer string = registry.outputs.loginServer
output registryName string = registry.outputs.name
output keyVaultName string = keyVault.outputs.name
output storageAccountName string = storage.outputs.name
output mysqlFqdn string = mysql.outputs.fqdn
output webAppName string = apps.outputs.webName
output workerAppName string = apps.outputs.workerName
output schedulerAppName string = apps.outputs.schedulerName
output migrateJobName string = apps.outputs.migrateJobName
output webFqdn string = apps.outputs.webFqdn
output environmentStaticIp string = apps.outputs.environmentStaticIp
output identityPrincipalId string = identity.outputs.principalId
