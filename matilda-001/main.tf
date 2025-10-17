provider "azurerm" {
  features {}
}

data "azurerm_resource_group" "rg" {
  name = "DOP_ResourceGroup"
}

resource "azurerm_app_service" "app" {
  name                = "matilda-001-frontend"
  location            = data.azurerm_resource_group.rg.location
  resource_group_name = data.azurerm_resource_group.rg.name
  app_service_plan_id = "/subscriptions/b13ed3be-59f0-4103-ad2a-a5b101af07f3/resourceGroups/DOP_ResourceGroup/providers/Microsoft.Web/serverfarms/app-service"

  app_settings = {}
}

output "app_service_hostname" {
  value = azurerm_app_service.app.default_site_hostname
}