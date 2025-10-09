@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the application.')
param appName string = 'saicol-005-web'

@description('The ID of the existing App Service Plan.')
param appServicePlanId string = '/subscriptions/sub-123/resourceGroups/rg-prod/providers/Microsoft.Web/serverfarms/app-service'

resource appService 'Microsoft.Web/sites@2022-03-01' = {
  name: appName
  location: location
  properties: {
    serverFarmId: appServicePlanId
    siteConfig: {
      appSettings: [
      { name: 'db_Password', value: '12345' }
    ]
    }
  }
}

output appServiceHostName string = appService.properties.defaultHostName