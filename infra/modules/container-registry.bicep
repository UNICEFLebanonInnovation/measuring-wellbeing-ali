// Azure Container Registry. Admin user disabled; images are pulled with the
// user-assigned identity (AcrPull) and pushed by the CI identity (AcrPush).
param location string
param namePrefix string
param tags object = {}
param sku string = 'Basic'
@description('Principal id of the user-assigned identity that pulls images.')
param pullPrincipalId string
@description('Optional principal id (GitHub OIDC app registration) granted AcrPush.')
param pushPrincipalId string = ''

// ACR names must be alphanumeric, 5-50 characters.
var registryName = toLower(replace('${namePrefix}acr', '-', ''))

resource registry 'Microsoft.ContainerRegistry/registries@2023-11-01-preview' = {
  name: registryName
  location: location
  tags: tags
  sku: {
    name: sku
  }
  properties: {
    adminUserEnabled: false
    publicNetworkAccess: 'Enabled'
    policies: {
      retentionPolicy: {
        status: sku == 'Basic' ? 'disabled' : 'enabled'
        days: 30
      }
    }
  }
}

// AcrPull built-in role
var acrPullRoleId = subscriptionResourceId('Microsoft.Authorization/roleDefinitions', '7f951dda-4ed3-4680-a7ca-43fe172d538d')
// AcrPush built-in role
var acrPushRoleId = subscriptionResourceId('Microsoft.Authorization/roleDefinitions', '8311e382-0749-4cb8-b61a-304f252e45ec')

resource pullAssignment 'Microsoft.Authorization/roleAssignments@2022-04-01' = {
  name: guid(registry.id, pullPrincipalId, acrPullRoleId)
  scope: registry
  properties: {
    roleDefinitionId: acrPullRoleId
    principalId: pullPrincipalId
    principalType: 'ServicePrincipal'
  }
}

resource pushAssignment 'Microsoft.Authorization/roleAssignments@2022-04-01' = if (!empty(pushPrincipalId)) {
  name: guid(registry.id, pushPrincipalId, acrPushRoleId)
  scope: registry
  properties: {
    roleDefinitionId: acrPushRoleId
    principalId: pushPrincipalId
    principalType: 'ServicePrincipal'
  }
}

output name string = registry.name
output loginServer string = registry.properties.loginServer
output id string = registry.id
