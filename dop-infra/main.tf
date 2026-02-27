provider "azurerm" {{ 
  features {{}} 
}} 

resource "azurerm_app_service_plan" "plan" {{ 
  name                = "asp-{form_data.get('applicationName', 'defaultplan')}" 
  location            = "centralus" 
  resource_group_name = "dopRG" 
  kind                = "app" 
  reserved            = true # Required for Linux plans 
  sku {{ 
    tier = "Free" 
    size = "F1" 
  }} 
}} 

output "app_service_plan_id" {{ 
  value = azurerm_app_service_plan.plan.id 
}}