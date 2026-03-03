@description('The Azure region for the deployment.')
param location string = 'centralus'

@description('The name of the application.')
param appName string = 'infra-canary-888'

@description('The name of the App Service Plan.')
param appServicePlanName string = 'asp-infra-canary-888'

@description('The SKU name for the App Service Plan.')
param skuName string = 'S1'

@description('The SKU tier for the App Service Plan.')
param skuTier string = 'Standard'

@description('The container image to deploy.')
param containerImage string = 'placeholder.azurecr.io/image:latest'

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
  properties: {
    serverFarmId: appServicePlan.id
    siteConfig: {
      linuxFxVersion: 'DOCKER|${containerImage}'
      appSettings: []
    }
  }
}

output appServicePlanId string = appServicePlan.id
output appServiceHostName string = appService.properties.defaultHostName