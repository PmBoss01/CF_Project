@description('The Azure region for the deployment.')
param location string = 'eastus'

@description('The name of the AKS cluster.')
param clusterName string = 'saicol-frontend-01'

@description('The number of nodes in the AKS cluster.')
param nodeCount int = 1

@description('The VM size for the AKS nodes.')
param vmSize string = 'Standard_DS2_v2'

resource aksCluster 'Microsoft.ContainerService/managedClusters@2023-03-01' = {
  name: clusterName
  location: location
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