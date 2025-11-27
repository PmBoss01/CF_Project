@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the App Service Plan.')
param appServicePlanName string = 'asp-{form_data.get('applicationName', 'defaultplan')}'

resource appServicePlan 'Microsoft.Web/serverfarms@2022-03-01' = {{ 
  name: appServicePlanName 
  location: location 
  sku: {{ 
    name: 'F1' 
    tier: 'Free' 
  }} 
}} 

output appServicePlanId string = appServicePlan.id