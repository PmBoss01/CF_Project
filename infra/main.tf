terraform {
  required_providers {
    azurerm = {
      source  = "hashicorp/azurerm"
      version = "~> 3.0"
    }
  }
}

provider "azurerm" {
  features {}
  use_cli = false
}

resource "azurerm_app_service_plan" "plan" {
  name                = "asp-frontend-terraform"
  location            = "centralus"
  resource_group_name = "dopRG"
  kind                = "app"
  reserved            = true
  sku {
    tier = "Free"
    size = "F1"
  }
}

output "app_service_plan_id" {
  value = azurerm_app_service_plan.plan.id
}