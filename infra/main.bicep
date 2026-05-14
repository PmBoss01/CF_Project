@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the application.')
param appName string = 'app-mx1-vv1'

@description('The name of the App Service Plan.')
param appServicePlanName string = 'asp-app-mx1-vv1'

@description('The SKU name for the App Service Plan.')
param skuName string = 'B1'

@description('The SKU tier for the App Service Plan.')
param skuTier string = 'Basic'

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
  kind: 'app,linux,container'
  properties: {
    serverFarmId: appServicePlan.id
    siteConfig: {
      linuxFxVersion: 'DOCKER|appmx1vv1registry48.azurecr.io/appmx1vv1:latest'
      appSettings: []
    }
  }
}

output appServicePlanId string = appServicePlan.id
output appServiceHostName string = appService.properties.defaultHostName