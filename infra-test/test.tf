provider "azurerm" {
  features {}
}

data "azurerm_resource_group" "rg" {
  name = "DOP_ResourceGroup"
}

variable "app_service_plan_id" {
  description = "The ID of the App Service Plan to use."
  type        = string
}

variable "container_image" {
  description = "The container image to deploy."
  type        = string
  default     = "placeholder.azurecr.io/image:latest"
}

resource "azurerm_app_service" "app" {
  name                = "forntend "
  location            = data.azurerm_resource_group.rg.location
  resource_group_name = data.azurerm_resource_group.rg.name
  app_service_plan_id = var.app_service_plan_id

  app_settings = {}

  site_config {
    linux_fx_version = "DOCKER|${var.container_image}"
  }
}

output "app_service_hostname" {
  value = azurerm_app_service.app.default_site_hostname
}