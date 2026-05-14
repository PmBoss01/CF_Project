@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the application.')
param appName string = 'app-vv1'

@description('The name of the App Service Plan.')
param appServicePlanName string = 'asp-app-vv1'

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
      linuxFxVersion: 'DOCKER|appvv1deveastusacr.azurecr.io/appvv1:latest'
      appCommandLine: 'echo ok > /home/site/wwwroot/robots933456.txt; test -f /home/npm-global/bin/serve || npm install -g serve --prefix /home/npm-global --quiet; /home/npm-global/bin/serve -s . -l tcp://0.0.0.0:8080'
      appSettings: []
    }
  }
}

output appServicePlanId string = appServicePlan.id
output appServiceHostName string = appService.properties.defaultHostName