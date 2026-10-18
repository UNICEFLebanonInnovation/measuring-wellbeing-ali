// Azure Database for MySQL Flexible Server 8.0 with the "sdq" database.
// Public access with a firewall (no VNet) keeps the setup simple; the
// server still requires TLS, which Laravel satisfies via MYSQL_ATTR_SSL_CA.
param location string
param namePrefix string
param tags object = {}
param administratorLogin string = 'sdqadmin'
@secure()
param administratorPassword string
@description('Burstable_Standard_B1ms for staging, GeneralPurpose_Standard_D2ds_v4 for production.')
param skuName string = 'Standard_B1ms'
@allowed(['Burstable', 'GeneralPurpose', 'MemoryOptimized'])
param skuTier string = 'Burstable'
param storageSizeGB int = 32
param backupRetentionDays int = 7
@allowed(['Enabled', 'Disabled'])
param geoRedundantBackup string = 'Disabled'
@allowed(['Enabled', 'Disabled'])
param highAvailability string = 'Disabled'
@description('Extra client IP ranges allowed through the firewall, e.g. [{ name: "office", start: "1.2.3.4", end: "1.2.3.4" }].')
param allowedIpRanges array = []
param databaseName string = 'sdq'

resource server 'Microsoft.DBforMySQL/flexibleServers@2023-12-30' = {
  name: '${namePrefix}-mysql'
  location: location
  tags: tags
  sku: {
    name: skuName
    tier: skuTier
  }
  properties: {
    version: '8.0.21'
    administratorLogin: administratorLogin
    administratorLoginPassword: administratorPassword
    storage: {
      storageSizeGB: storageSizeGB
      autoGrow: 'Enabled'
      iops: 360
    }
    backup: {
      backupRetentionDays: backupRetentionDays
      geoRedundantBackup: geoRedundantBackup
    }
    highAvailability: {
      mode: highAvailability == 'Enabled' ? 'ZoneRedundant' : 'Disabled'
    }
    network: {
      publicNetworkAccess: 'Enabled'
    }
  }
}

resource database 'Microsoft.DBforMySQL/flexibleServers/databases@2023-12-30' = {
  parent: server
  name: databaseName
  properties: {
    charset: 'utf8mb4'
    collation: 'utf8mb4_unicode_ci'
  }
}

// 0.0.0.0 - 0.0.0.0 is the Azure convention for "allow Azure services".
resource allowAzure 'Microsoft.DBforMySQL/flexibleServers/firewallRules@2023-12-30' = {
  parent: server
  name: 'AllowAllAzureServicesAndResourcesWithinAzureIps'
  properties: {
    startIpAddress: '0.0.0.0'
    endIpAddress: '0.0.0.0'
  }
}

resource extraRules 'Microsoft.DBforMySQL/flexibleServers/firewallRules@2023-12-30' = [for rule in allowedIpRanges: {
  parent: server
  name: rule.name
  properties: {
    startIpAddress: rule.start
    endIpAddress: rule.end
  }
}]

// Server parameters the legacy data relies on.
resource sqlMode 'Microsoft.DBforMySQL/flexibleServers/configurations@2023-12-30' = {
  parent: server
  name: 'sql_mode'
  properties: {
    value: 'STRICT_TRANS_TABLES,NO_ENGINE_SUBSTITUTION'
    source: 'user-override'
  }
  dependsOn: [database]
}

resource timeZone 'Microsoft.DBforMySQL/flexibleServers/configurations@2023-12-30' = {
  parent: server
  name: 'time_zone'
  properties: {
    value: '+00:00'
    source: 'user-override'
  }
  dependsOn: [sqlMode]
}

output serverName string = server.name
output fqdn string = server.properties.fullyQualifiedDomainName
output databaseName string = database.name
output administratorLogin string = administratorLogin
