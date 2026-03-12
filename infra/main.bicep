@description('The Azure region for the deployment.')
param location string = 'centralus'

@description('The name of the App Service Plan.')
param appServicePlanName string = 'asp-infra-app'

@description('The SKU name for the App Service Plan.')
param skuName string = 'S1'

@description('The SKU tier for the App Service Plan.')
param skuTier string = 'Standard'

@description('The kind of the App Service Plan (e.g., app, linux).')
param kind string = 'app'

resource appServicePlan 'Microsoft.Web/serverfarms@2022-03-01' = {
  name: appServicePlanName
  location: location
  sku: {
    name: skuName
    tier: skuTier
  }
  kind: kind
}

output appServicePlanId string = appServicePlan.id