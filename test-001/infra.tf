provider "azurerm" {
  features {}
}

data "azurerm_resource_group" "rg" {
  name = "DOP_Resource_Group"
}

resource "azurerm_app_service" "app" {
  name                = "test-frontend"
  location            = data.azurerm_resource_group.rg.location
  resource_group_name = data.azurerm_resource_group.rg.name
  app_service_plan_id = "/subscriptions/6ef0b1f8-cd7a-48c1-b1c3-ce79eb0de7c7/resourceGroups/DOP_Resource_Group/providers/Microsoft.Web/serverfarms/app-service"

  app_settings = {
    "db_password": "1234"
}
}

output "app_service_hostname" {
  value = azurerm_app_service.app.default_site_hostname
}