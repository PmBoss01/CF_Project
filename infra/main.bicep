@description('The Azure region for the deployment.')
param location string = 'centralus'

@description('The name of the application.')
param appName string = 'app-service-env'

@description('The name of the App Service Plan.')
param appServicePlanName string = 'asp-app-service-env'

@description('The SKU name for the App Service Plan.')
param skuName string = 'S1'

@description('The SKU tier for the App Service Plan.')
param skuTier string = 'Standard'

resource appServicePlan 'Microsoft.Web/serverfarms@2022-03-01' = {
  name: appServicePlanName
  location: location
  sku: {
    name: skuName
    tier: skuTier
  }
  kind: 'linux'
  properties: {
    reserved: true
  }
}

resource appService 'Microsoft.Web/sites@2022-03-01' = {
  name: appName
  location: location
  kind: 'app,linux'
  properties: {
    serverFarmId: appServicePlan.id
    siteConfig: {
      linuxFxVersion: 'PHP|8.2'
      appSettings: [
      { name: 'APP_NAME', value: 'RocketDash' }
      { name: 'APP_ENV', value: 'production' }
      { name: 'DB_HOST', value: 'db.internal.rocketdash.io' }
      { name: 'DB_NAME', value: 'rocketdash_prod' }
      { name: 'DB_USER', value: 'rd_admin' }
      { name: 'DB_PASS', value: 'xT7#mQ2!vZ9$kL4n' }
      { name: 'API_KEY', value: '********' }
      { name: 'SECRET_TOKEN', value: '********' }
      { name: 'SCM_DO_BUILD_DURING_DEPLOYMENT', value: 'true' }
    ]
    }
  }
}

output appServicePlanId string = appServicePlan.id
output appServiceHostName string = appService.properties.defaultHostName