@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the App Service Plan.')
param appServicePlanName string = 'asp-frontend'

resource appServicePlan 'Microsoft.Web/serverfarms@2022-03-01' = {
  name: appServicePlanName
  location: location
  sku: {
    name: 'B1'
    tier: 'Basic'
  }
}

output appServicePlanId string = appServicePlan.id