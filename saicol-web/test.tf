provider "azurerm" {
  features {}
}

resource "azurerm_resource_group" "rg" {
  name     = "dop-rg"
  location = "eastus"
}

resource "azurerm_kubernetes_cluster" "aks" {
  name                = "saicol-frontend"
  location            = azurerm_resource_group.rg.location
  resource_group_name = azurerm_resource_group.rg.name
  dns_prefix          = "saicol-frontend"

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