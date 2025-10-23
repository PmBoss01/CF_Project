@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the application.')
param appName string = 'test-frontend'

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
      appSettings: [
      { name: 'KEY', value: '123' }
      { name: 'APP_KEY', value: 'YEHH4877465' }
    ]
    }
  }
}

output appServiceHostName string = appService.properties.defaultHostName