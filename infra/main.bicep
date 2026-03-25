@description('The Azure region for the deployment.')
param location string = 'centralus'

@description('The name of the application.')
param appName string = 'staticweb-vv1'

@description('The name of the App Service Plan.')
param appServicePlanName string = 'asp-staticweb-vv1'

@description('The SKU name for the App Service Plan.')
param skuName string = 'S1'

@description('The SKU tier for the App Service Plan.')
param skuTier string = 'Standard'

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
  kind: 'app,linux'
  properties: {
    serverFarmId: appServicePlan.id
    siteConfig: {
      linuxFxVersion: 'NODE|20-lts'
      appCommandLine: 'echo ok > /home/site/wwwroot/robots933456.txt; test -f /home/npm-global/bin/serve || npm install -g serve --prefix /home/npm-global --quiet; /home/npm-global/bin/serve -s . -l tcp://0.0.0.0:8080'
      appSettings: [
      { name: 'WEBSITES_PORT', value: '8080' }
    ]
    }
  }
}

output appServicePlanId string = appServicePlan.id
output appServiceHostName string = appService.properties.defaultHostName