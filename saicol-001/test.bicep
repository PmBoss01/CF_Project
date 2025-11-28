@description('The Azure region for the deployment.')
param location string = 'canadacentral'

@description('The name of the AKS cluster.')
param clusterName string = 'frontend-web'

@description('The number of nodes in the AKS cluster.')
param nodeCount int = 1

@description('The VM size for the AKS nodes.')
param vmSize string = 'Standard_B2s'

resource aksCluster 'Microsoft.ContainerService/managedClusters@2023-03-01' = {
  name: clusterName
  location: location
  tags: {
    environment: 'Production'
  }
  properties: {
    dnsPrefix: clusterName
    agentPoolProfiles: [
      {
        name: 'agentpool'
        count: nodeCount
        vmSize: vmSize
        mode: 'System'
      }
    ]
    identity: {
      type: 'SystemAssigned'
    }
  }
}

output kubeConfig object = listKeys(aksCluster.id, '2023-03-01').keys[0].value