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
  name = "pot-rg"
}

variable "app_service_plan_id" {
  description = "The ID of the App Service Plan to use."
  type        = string
}

resource "azurerm_app_service" "app" {
  name                = "staticWeb-prod-vv17877"
  location            = data.azurerm_resource_group.rg.location
  resource_group_name = data.azurerm_resource_group.rg.name
  app_service_plan_id = var.app_service_plan_id

  app_settings = {
    "WEBSITES_PORT": "8080"
}

  site_config {
    linux_fx_version = "NODE|20-lts"
    app_command_line = "echo ok > /home/site/wwwroot/robots933456.txt; test -f /home/npm-global/bin/serve || npm install -g serve --prefix /home/npm-global --quiet; /home/npm-global/bin/serve -s . -l tcp://0.0.0.0:8080"
  }
}

output "app_service_hostname" {
  value = azurerm_app_service.app.default_site_hostname
}