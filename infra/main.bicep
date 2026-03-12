@description('The Azure region for the deployment.')
param location string = 'centralus'

@description('The name of the AKS cluster.')
param clusterName string = 'asap-v2'

@description('The number of nodes in the AKS cluster.')
param nodeCount int = 2

@description('The VM size for the AKS nodes.')
param vmSize string = 'Standard_DS2_v2'

resource aksCluster 'Microsoft.ContainerService/managedClusters@2023-03-01' = {
  name: clusterName
  location: location
  identity: {
    type: 'SystemAssigned'
  }
  tags: {
    environment: 'dev'
  }
  properties: {
    dnsPrefix: clusterName
    agentPoolProfiles: [
      {
        name: 'agentpool'
        count: nodeCount
        vmSize: vmSize
        mode: 'System'
        osType: 'Linux'
        type: 'VirtualMachineScaleSets'
        upgradeSettings: {
          maxSurge: '1'
          maxUnavailable: '0'
        }
      }
    ]
    servicePrincipalProfile: {
      clientId: 'msi'
    }
  }
}

output clusterName string = aksCluster.name
output clusterFqdn string = aksCluster.properties.fqdn
output clusterResourceId string = aksCluster.id