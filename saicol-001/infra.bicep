@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the application.')
param appName string = 'saicol-frontend'

@description('The ID of the existing App Service Plan.')
param appServicePlanId string = '/subscriptions/6ef0b1f8-cd7a-48c1-b1c3-ce79eb0de7c7/resourceGroups/DOP_Resource_Group/providers/Microsoft.Web/serverfarms/app-service'

resource appService 'Microsoft.Web/sites@2022-03-01' = {
  name: appName
  location: location
  properties: {
    serverFarmId: appServicePlanId
    siteConfig: {
      appSettings: []
    }
  }
}

output appServiceHostName string = appService.properties.defaultHostName