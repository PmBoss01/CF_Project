@description('The Azure region for the deployment.')
param location string = 'centralus'

@description('The name of the application.')
param appName string = 'java-mx1'

@description('The name of the App Service Plan.')
param appServicePlanName string = 'asp-java-mx1'

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
      linuxFxVersion: 'JAVA|17-java17'
      appSettings: [
      { name: 'SCM_DO_BUILD_DURING_DEPLOYMENT', value: 'true' }
    ]
    }
  }
}

output appServicePlanId string = appServicePlan.id
output appServiceHostName string = appService.properties.defaultHostName