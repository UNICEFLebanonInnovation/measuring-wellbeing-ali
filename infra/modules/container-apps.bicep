// Container Apps environment + the web, worker and scheduler apps and the
// migrate job, all from the same image (CONTAINER_ROLE selects behaviour).
param location string
param namePrefix string
param tags object = {}
param environmentName string
@description('Full image reference, e.g. myacr.azurecr.io/measuring-wellbeing:abc123. The pipeline updates it after each build.')
param image string
param registryLoginServer string
param identityId string
param identityClientId string
param workspaceCustomerId string
@secure()
param workspaceSharedKey string
param appInsightsConnectionString string

param appKeySecretUri string
param dbCredentialRef string
param mailCredentialRef string

param dbHost string
param dbDatabase string
param dbUsername string

param appUrl string
@description('Public hostname to bind (e.g. measuringwellbeing.org). Empty = use the generated *.azurecontainerapps.io name. Bind the custom domain after DNS validation (see infra/README.md).')
param customDomain string = ''

param webMinReplicas int = 1
param webMaxReplicas int = 5
param webCpu string = '0.5'
param webMemory string = '1Gi'

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

var secrets = [
  {
    name: 'app-key'
    keyVaultUrl: appKeySecretUri
    identity: identityId
  }
  {
    name: 'db-password'
    keyVaultUrl: dbCredentialRef
    identity: identityId
  }
  {
    name: 'mail-password'
    keyVaultUrl: mailCredentialRef
    identity: identityId
  }
]

var commonEnv = [
  { name: 'APP_NAME', value: 'Measuring Well-Being' }
  { name: 'APP_ENV', value: environmentName == 'prod' ? 'production' : 'staging' }
  { name: 'APP_DEBUG', value: 'false' }
  { name: 'APP_URL', value: appUrl }
  { name: 'APP_KEY', secretRef: 'app-key' }
  { name: 'APP_TIMEZONE', value: 'Asia/Beirut' }
  { name: 'APP_LOCALE', value: 'en' }
  { name: 'LOG_CHANNEL', value: 'stderr' }
  { name: 'LOG_LEVEL', value: environmentName == 'prod' ? 'warning' : 'info' }
  { name: 'DB_CONNECTION', value: 'mysql' }
  { name: 'DB_HOST', value: dbHost }
  { name: 'DB_PORT', value: '3306' }
  { name: 'DB_DATABASE', value: dbDatabase }
  { name: 'DB_USERNAME', value: dbUsername }
  { name: 'DB_PASSWORD', secretRef: 'db-password' }
  // MySQL Flexible Server enforces TLS. The Debian system CA bundle in the
  // image contains the DigiCert roots Azure uses.
  { name: 'MYSQL_ATTR_SSL_CA', value: '/etc/ssl/certs/ca-certificates.crt' }
  { name: 'SESSION_DRIVER', value: 'database' }
  { name: 'SESSION_SECURE_COOKIE', value: 'true' }
  { name: 'CACHE_STORE', value: 'database' }
  { name: 'QUEUE_CONNECTION', value: 'database' }
  { name: 'FILESYSTEM_DISK', value: 'local' }
  { name: 'MAIL_MAILER', value: empty(mailHost) ? 'log' : 'smtp' }
  { name: 'MAIL_HOST', value: mailHost }
  { name: 'MAIL_PORT', value: mailPort }
  { name: 'MAIL_USERNAME', value: mailUsername }
  { name: 'MAIL_PASSWORD', secretRef: 'mail-password' }
  { name: 'MAIL_ENCRYPTION', value: mailEncryption }
  { name: 'MAIL_FROM_ADDRESS', value: mailFromAddress }
  { name: 'MAIL_FROM_NAME', value: 'Measuring Well-Being' }
  { name: 'APPLICATIONINSIGHTS_CONNECTION_STRING', value: appInsightsConnectionString }
  { name: 'SDQ_SCORING_POLICY', value: sdqScoringPolicy }
  { name: 'SDQ_MAX_NA_ANSWERS', value: sdqMaxNaAnswers }
  { name: 'SDQ_CODE_FORMAT', value: sdqCodeFormat }
  { name: 'SDQ_QUOTA_PER_YEAR', value: sdqQuotaPerYear }
  { name: 'SDQ_APK_URL', value: sdqApkUrl }
  { name: 'AZURE_CLIENT_ID', value: identityClientId }
]

resource environment 'Microsoft.App/managedEnvironments@2024-03-01' = {
  name: '${namePrefix}-cae'
  location: location
  tags: tags
  properties: {
    appLogsConfiguration: {
      destination: 'log-analytics'
      logAnalyticsConfiguration: {
        customerId: workspaceCustomerId
        sharedKey: workspaceSharedKey
      }
    }
    zoneRedundant: false
  }
}

resource web 'Microsoft.App/containerApps@2024-03-01' = {
  name: '${namePrefix}-web'
  location: location
  tags: union(tags, { role: 'web' })
  identity: {
    type: 'UserAssigned'
    userAssignedIdentities: {
      '${identityId}': {}
    }
  }
  properties: {
    managedEnvironmentId: environment.id
    configuration: {
      activeRevisionsMode: 'Single'
      ingress: {
        external: true
        targetPort: 8080
        transport: 'http'
        allowInsecure: false
        traffic: [
          {
            latestRevision: true
            weight: 100
          }
        ]
        customDomains: empty(customDomain) ? null : [
          {
            name: customDomain
            bindingType: 'Disabled' // switched to SniEnabled by the cert binding step in infra/README.md
          }
        ]
      }
      registries: [
        {
          server: registryLoginServer
          identity: identityId
        }
      ]
      secrets: secrets
    }
    template: {
      containers: [
        {
          name: 'web'
          image: image
          resources: {
            cpu: json(webCpu)
            memory: webMemory
          }
          env: concat(commonEnv, [
            { name: 'CONTAINER_ROLE', value: 'web' }
            { name: 'RUN_MIGRATIONS_ON_START', value: 'false' }
          ])
          probes: [
            {
              type: 'Startup'
              httpGet: {
                path: '/up'
                port: 8080
              }
              initialDelaySeconds: 5
              periodSeconds: 5
              failureThreshold: 12
            }
            {
              type: 'Liveness'
              httpGet: {
                path: '/up'
                port: 8080
              }
              periodSeconds: 30
              failureThreshold: 3
            }
            {
              type: 'Readiness'
              httpGet: {
                path: '/up'
                port: 8080
              }
              periodSeconds: 10
              failureThreshold: 3
            }
          ]
        }
      ]
      scale: {
        minReplicas: webMinReplicas
        maxReplicas: webMaxReplicas
        rules: [
          {
            name: 'http'
            http: {
              metadata: {
                concurrentRequests: '50'
              }
            }
          }
        ]
      }
    }
  }
}

resource worker 'Microsoft.App/containerApps@2024-03-01' = {
  name: '${namePrefix}-worker'
  location: location
  tags: union(tags, { role: 'worker' })
  identity: {
    type: 'UserAssigned'
    userAssignedIdentities: {
      '${identityId}': {}
    }
  }
  properties: {
    managedEnvironmentId: environment.id
    configuration: {
      activeRevisionsMode: 'Single'
      registries: [
        {
          server: registryLoginServer
          identity: identityId
        }
      ]
      secrets: secrets
    }
    template: {
      containers: [
        {
          name: 'worker'
          image: image
          resources: {
            cpu: json('0.25')
            memory: '0.5Gi'
          }
          env: concat(commonEnv, [
            { name: 'CONTAINER_ROLE', value: 'worker' }
          ])
        }
      ]
      scale: {
        minReplicas: 1
        maxReplicas: 1
      }
    }
  }
}

resource scheduler 'Microsoft.App/containerApps@2024-03-01' = {
  name: '${namePrefix}-scheduler'
  location: location
  tags: union(tags, { role: 'scheduler' })
  identity: {
    type: 'UserAssigned'
    userAssignedIdentities: {
      '${identityId}': {}
    }
  }
  properties: {
    managedEnvironmentId: environment.id
    configuration: {
      activeRevisionsMode: 'Single'
      registries: [
        {
          server: registryLoginServer
          identity: identityId
        }
      ]
      secrets: secrets
    }
    template: {
      containers: [
        {
          name: 'scheduler'
          image: image
          resources: {
            cpu: json('0.25')
            memory: '0.5Gi'
          }
          env: concat(commonEnv, [
            { name: 'CONTAINER_ROLE', value: 'scheduler' }
          ])
        }
      ]
      scale: {
        minReplicas: 1
        maxReplicas: 1
      }
    }
  }
}

resource migrateJob 'Microsoft.App/jobs@2024-03-01' = {
  name: '${namePrefix}-migrate'
  location: location
  tags: union(tags, { role: 'migrate' })
  identity: {
    type: 'UserAssigned'
    userAssignedIdentities: {
      '${identityId}': {}
    }
  }
  properties: {
    environmentId: environment.id
    configuration: {
      triggerType: 'Manual'
      replicaTimeout: 1800
      replicaRetryLimit: 0
      manualTriggerConfig: {
        parallelism: 1
        replicaCompletionCount: 1
      }
      registries: [
        {
          server: registryLoginServer
          identity: identityId
        }
      ]
      secrets: secrets
    }
    template: {
      containers: [
        {
          name: 'migrate'
          image: image
          resources: {
            cpu: json('0.5')
            memory: '1Gi'
          }
          env: concat(commonEnv, [
            { name: 'CONTAINER_ROLE', value: 'migrate' }
          ])
        }
      ]
    }
  }
}

output environmentId string = environment.id
output webName string = web.name
output workerName string = worker.name
output schedulerName string = scheduler.name
output migrateJobName string = migrateJob.name
output webFqdn string = web.properties.configuration.ingress.fqdn
output environmentDefaultDomain string = environment.properties.defaultDomain
output environmentStaticIp string = environment.properties.staticIp
