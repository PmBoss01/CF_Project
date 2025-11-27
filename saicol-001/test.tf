provider "azurerm" {
  features {}
}

resource "azurerm_app_service_plan" "plan" {
  name                = "asp-frontend-service"
  location            = "eastus"
  resource_group_name = "dop-rg"
  kind                = "Linux"
  reserved            = true # Required for Linux plans
  sku {
    tier = "Standard"
    size = "S1"
  }
}

output "app_service_plan_id" {
  value = azurerm_app_service_plan.plan.id
}