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

data "azurerm_resource_group" "rg" {
  name = "dopRG"
}

variable "app_service_plan_id" {
  description = "The ID of the App Service Plan to use."
  type        = string
}

resource "azurerm_app_service" "app" {
  name                = "appS-acr-vv2"
  location            = data.azurerm_resource_group.rg.location
  resource_group_name = data.azurerm_resource_group.rg.name
  app_service_plan_id = var.app_service_plan_id

  app_settings = {}

  site_config {
    linux_fx_version = "DOCKER|doptestcontainer.azurecr.io/pythonimage:latest"
  }
}

output "app_service_hostname" {
  value = azurerm_app_service.app.default_site_hostname
}