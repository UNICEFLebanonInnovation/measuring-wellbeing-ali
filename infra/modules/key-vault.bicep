// Key Vault in RBAC mode holding the application secrets.
// Secret VALUES are never in Bicep: the placeholders created here are
// overwritten by the first-time setup commands in infra/README.md.
param location string
param namePrefix string
param tags object = {}
@description('Principal id of the user-assigned identity that reads secrets at runtime.')
param readerPrincipalId string
@description('Optional object id of the operator (or CI identity) that may set secrets.')
param kvOfficerObjectId string = ''
@secure()
@description('Initial database password. Leave empty to create only a placeholder to be set manually.')
param initialDbPassword string = ''
@secure()
@description('Initial Laravel APP_KEY (base64:...). Leave empty to create only a placeholder.')
param initialAppKey string = ''

// Vault names: 3-24 alphanumeric and hyphens, globally unique.
var vaultName = take('${namePrefix}-kv', 24)

resource vault 'Microsoft.KeyVault/vaults@2023-07-01' = {
  name: vaultName
  location: location
  tags: tags
  properties: {
    tenantId: subscription().tenantId
    sku: {
      family: 'A'
      name: 'standard'
    }
    enableRbacAuthorization: true
    enableSoftDelete: true
    softDeleteRetentionInDays: 30
    enablePurgeProtection: true
    publicNetworkAccess: 'Enabled'
    networkAcls: {
      defaultAction: 'Allow'
      bypass: 'AzureServices'
    }
  }
}

// Key Vault Secrets User
var secretsUserRoleId = subscriptionResourceId('Microsoft.Authorization/roleDefinitions', '4633458b-17de-408a-b874-0445c86b69e6')
// Key Vault Secrets Officer
var secretsOfficerRoleId = subscriptionResourceId('Microsoft.Authorization/roleDefinitions', 'b86a8fe4-44ce-4948-aee5-eccb2c155cd7')

resource readerAssignment 'Microsoft.Authorization/roleAssignments@2022-04-01' = {
  name: guid(vault.id, readerPrincipalId, secretsUserRoleId)
  scope: vault
  properties: {
    roleDefinitionId: secretsUserRoleId
    principalId: readerPrincipalId
    principalType: 'ServicePrincipal'
  }
}

resource officerAssignment 'Microsoft.Authorization/roleAssignments@2022-04-01' = if (!empty(kvOfficerObjectId)) {
  name: guid(vault.id, kvOfficerObjectId, secretsOfficerRoleId)
  scope: vault
  properties: {
    roleDefinitionId: secretsOfficerRoleId
    principalId: kvOfficerObjectId
  }
}

resource appKeySecret 'Microsoft.KeyVault/vaults/secrets@2023-07-01' = {
  parent: vault
  name: 'app-key'
  properties: {
    value: empty(initialAppKey) ? 'REPLACE-ME' : initialAppKey
    contentType: 'Laravel APP_KEY'
  }
}

resource dbPasswordSecret 'Microsoft.KeyVault/vaults/secrets@2023-07-01' = {
  parent: vault
  name: 'db-password'
  properties: {
    value: empty(initialDbPassword) ? 'REPLACE-ME' : initialDbPassword
    contentType: 'MySQL administrator password'
  }
}

resource mailPasswordSecret 'Microsoft.KeyVault/vaults/secrets@2023-07-01' = {
  parent: vault
  name: 'mail-password'
  properties: {
    value: 'REPLACE-ME'
    contentType: 'SMTP password'
  }
}

output name string = vault.name
output id string = vault.id
output uri string = vault.properties.vaultUri
output appKeySecretUri string = appKeySecret.properties.secretUri
output dbCredentialRef string = dbPasswordSecret.properties.secretUri
output mailCredentialRef string = mailPasswordSecret.properties.secretUri
