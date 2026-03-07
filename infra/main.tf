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
  name                = "canary-terraform-app"
  location            = data.azurerm_resource_group.rg.location
  resource_group_name = data.azurerm_resource_group.rg.name
  app_service_plan_id = var.app_service_plan_id

  app_settings = {
    "APP_NAME": "RocketDash",
    "#APP_ENV": "production",
    "#DB_HOST": "db.internal.rocketdash.io",
    "DB_NAME": "rocketdash_prod",
    "DB_USER": "rd_admin",
    "DB_PASS": "xT7#mQ2!vZ9$kL4n",
    "API_KEY": "********",
    "SECRET_TOKEN": "********",
    "SCM_DO_BUILD_DURING_DEPLOYMENT": "true"
}

  site_config {
    linux_fx_version = "PHP|8.2"
  }
}

output "app_service_hostname" {
  value = azurerm_app_service.app.default_site_hostname
}