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
  name                = "net-tf-test-vv1"
  location            = data.azurerm_resource_group.rg.location
  resource_group_name = data.azurerm_resource_group.rg.name
  app_service_plan_id = var.app_service_plan_id

  app_settings = {
    "SCM_DO_BUILD_DURING_DEPLOYMENT": "true",
    "WEBSITE_SWAP_WARMUP_PING_STATUSES": "200,301,302",
    "ASPNETCORE_URLS": "http://*:8080"
}

  site_config {
    linux_fx_version = "DOTNETCORE|8.0"
  }
}

output "app_service_hostname" {
  value = azurerm_app_service.app.default_site_hostname
}