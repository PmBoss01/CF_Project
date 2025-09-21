provider "azurerm" {
  features {}
}

data "azurerm_resource_group" "rg" {
  name = "rg-prod"
}

resource "azurerm_app_service" "app" {
  name                = "myBesTecH-web-app"
  location            = data.azurerm_resource_group.rg.location
  resource_group_name = data.azurerm_resource_group.rg.name
  app_service_plan_id = "/subscriptions/sub-123/resourceGroups/rg-prod/providers/Microsoft.Web/serverfarms/app-service"

  app_settings = {
    "DB_CONNECTION_STRING": "placeholder_connection_string"
}
}

output "app_service_hostname" {
  value = azurerm_app_service.app.default_site_hostname
}