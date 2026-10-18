// Storage account for partner logos, the Android APK download and exports.
param location string
param namePrefix string
param tags object = {}
@description('Allow anonymous (blob-level) read on the "public" container. Needed only when APK/logo links must be opened without the app. Default off.')
param allowPublicBlobRead bool = false
@description('Principal id of the identity that reads/writes blobs at runtime.')
param blobContributorPrincipalId string

// Storage names: 3-24 lowercase alphanumeric, globally unique.
var accountName = take(toLower(replace('${namePrefix}st', '-', '')), 24)

resource account 'Microsoft.Storage/storageAccounts@2023-05-01' = {
  #disable-next-line BCP334 // namePrefix is never shorter than 3 characters (project-env)
  name: accountName
  location: location
  tags: tags
  kind: 'StorageV2'
  sku: {
    name: 'Standard_LRS'
  }
  properties: {
    accessTier: 'Hot'
    minimumTlsVersion: 'TLS1_2'
    supportsHttpsTrafficOnly: true
    allowBlobPublicAccess: allowPublicBlobRead
    allowSharedKeyAccess: true
    networkAcls: {
      defaultAction: 'Allow'
      bypass: 'AzureServices'
    }
  }
}

resource blobService 'Microsoft.Storage/storageAccounts/blobServices@2023-05-01' = {
  parent: account
  name: 'default'
  properties: {
    deleteRetentionPolicy: {
      enabled: true
      days: 14
    }
    containerDeleteRetentionPolicy: {
      enabled: true
      days: 14
    }
  }
}

resource publicContainer 'Microsoft.Storage/storageAccounts/blobServices/containers@2023-05-01' = {
  parent: blobService
  name: 'public'
  properties: {
    publicAccess: allowPublicBlobRead ? 'Blob' : 'None'
  }
}

resource exportsContainer 'Microsoft.Storage/storageAccounts/blobServices/containers@2023-05-01' = {
  parent: blobService
  name: 'exports'
  properties: {
    publicAccess: 'None'
  }
}

// Storage Blob Data Contributor
var blobContributorRoleId = subscriptionResourceId('Microsoft.Authorization/roleDefinitions', 'ba92f5b4-2d11-453d-a403-e96b0029c9fe')

resource roleAssignment 'Microsoft.Authorization/roleAssignments@2022-04-01' = {
  name: guid(account.id, blobContributorPrincipalId, blobContributorRoleId)
  scope: account
  properties: {
    roleDefinitionId: blobContributorRoleId
    principalId: blobContributorPrincipalId
    principalType: 'ServicePrincipal'
  }
}

output name string = account.name
output id string = account.id
output blobEndpoint string = account.properties.primaryEndpoints.blob
