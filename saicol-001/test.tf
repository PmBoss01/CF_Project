provider "azurerm" {
  features {}
}

resource "azurerm_resource_group" "rg" {
  name     = "dopstorage001"
  location = "eastus"
}

resource "azurerm_kubernetes_cluster" "aks" {
  name                = "frontend-001"
  location            = azurerm_resource_group.rg.location
  resource_group_name = azurerm_resource_group.rg.name
  dns_prefix          = "frontend-001"

  default_node_pool {
    name       = "default"
    node_count = 1
    vm_size    = "Standard_DS2_v2"
  }

  identity {
    type = "SystemAssigned"
  }

  tags = {
    environment = "Production"
  }
}

output "kube_config" {
  value     = azurerm_kubernetes_cluster.aks.kube_config_raw
  sensitive = true
}