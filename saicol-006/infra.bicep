@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the application.')
param appName string = 'saicol-frontend'

@description('The ID of the existing App Service Plan.')
param appServicePlanId string = '/subscriptions/b13ed3be-59f0-4103-ad2a-a5b101af07f3/resourceGroups/DOP_ResourceGroup/providers/Microsoft.Web/serverfarms/app-service'

resource appService 'Microsoft.Web/sites@2022-03-01' = {
  name: appName
  location: location
  properties: {
    serverFarmId: appServicePlanId
    siteConfig: {
      appSettings: [
      { name: 'db_password', value: '1234' }
    ]
    }
  }
}

output appServiceHostName string = appService.properties.defaultHostName