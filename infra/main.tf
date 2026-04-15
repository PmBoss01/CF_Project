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
  skip_provider_registration = false
}

resource "azurerm_resource_group" "rg" {
  name     = "dopRG"
  location = "centralus"
}

resource "azurerm_kubernetes_cluster" "aks" {
  name                = "app-test-vv1"
  location            = azurerm_resource_group.rg.location
  resource_group_name = azurerm_resource_group.rg.name
  dns_prefix          = "app-test-vv1"

  default_node_pool {
    name       = "agentpool"
    node_count = 2
    vm_size    = "Standard_DS2_v2"
    upgrade_settings {
      max_surge       = "1"
      max_unavailable = "0"
    }
  }

  identity {
    type = "SystemAssigned"
  }

  tags = {
    environment = "prod"
  }
}

output "kube_config" {
  value     = azurerm_kubernetes_cluster.aks.kube_config_raw
  sensitive = true
}

output "cluster_name" {
  value = azurerm_kubernetes_cluster.aks.name
}

output "cluster_fqdn" {
  value = azurerm_kubernetes_cluster.aks.fqdn
}