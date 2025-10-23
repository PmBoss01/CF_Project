@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the application.')
param appName string = 'web-frontend 2'

@description('The ID of the App Service Plan to use.')
param appServicePlanId string

@description('The container image to deploy.')
param containerImage string = 'placeholder.azurecr.io/image:latest'

resource appService 'Microsoft.Web/sites@2022-03-01' = {
  name: appName
  location: location
  properties: {
    serverFarmId: appServicePlanId
    siteConfig: {
      linuxFxVersion: 'DOCKER|' + containerImage
      appSettings: []
    }
  }
}

output appServiceHostName string = appService.properties.defaultHostName