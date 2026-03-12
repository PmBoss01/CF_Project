terraform {
  required_providers {
    azurerm = {
      source  = "hashicorp/azurerm"
      version = "~> 2.0"
    }
  }
}

provider "azurerm" {
  features {}
}

resource "azurerm_app_service_plan" "plan" {
  name                = "asp-canary-infra"
  location            = "centralus"
  resource_group_name = "dopRG"
  kind                = "app"
  reserved            = true
  sku {
    tier = "Standard"
    size = "S1"
  }
}

output "app_service_plan_id" {
  value = azurerm_app_service_plan.plan.id
}