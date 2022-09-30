<?php
/*
   ------------------------------------------------------------------------
   Autor: Grupo Inforges - Elena Martínez Ballesta
   Fecha: Enero 2016
   Plugin Contratos
   ------------------------------------------------------------------------
*/

 
include ("../../../inc/includes.php");                

$plugin = new Plugin();
if (!$plugin->isInstalled('contratos') || !$plugin->isActivated('contratos')) {
   echo "Plugin no instalado o activado";
   return;
}

if (!isset($_GET["id"])) {
   $_GET["id"] = "";
}
if (!isset($_GET["contracts_id"])) {
   $_GET["contracts_id"] = "";
}

$fact = new PluginContratosFacturacion();

if (isset($_POST["add"])) {
	
	if ($_POST['reg_date'] === ''){
		unset($_POST['reg_date']);
	}
	   
   if ($newID = $fact->add($_POST)) {
	  //Actualizamos el histórico 
		$insert_logs = "INSERT INTO glpi_logs (itemtype, items_id, linked_action, user_name) 
                        VALUES ('PluginContratosFacturacion',".$fact->fields['id'].", '20', '".getUserName($_SESSION['glpiID'])."')";
		$result = $DB->query($insert_logs);
   }
   Html::back();

} else if (isset($_POST["purge"])) {
   $fact->check($_POST["id"], PURGE);

   if ($fact->delete($_POST, 1)) {		 
	  //Actualizamos el histórico 
		$insert_logs = "INSERT INTO glpi_logs (itemtype, itemtype_link, items_id, linked_action, user_name, date_mod, old_value) 
                        VALUES ('Contract', 'PluginContratosFacturacion', ".$fact->fields['contracts_id'].", '19', '".getUserName($_SESSION['glpiID'])."', 
						NOW(), '".$_POST['name']."(".$_POST['id'].")')";
		$result = $DB->query($insert_logs);
					 
   }
   $contract = new Contract();
   $contract->getFromDB($fact->fields['contracts_id']);
   Html::redirect(Toolbox::getItemTypeFormURL('Contract').'?id='.$fact->fields['contracts_id'].
                  ($contract->fields['is_template']?"&withtemplate=1":""));

} else if (isset($_POST["update"])) {
	
   $fact->check($_POST["id"], UPDATE);
   if ($fact->update($_POST)) {
 	  //Actualizamos el histórico 
		$insert_logs = "INSERT INTO glpi_logs (itemtype, itemtype_link, items_id, linked_action, user_name, date_mod, new_value) 
                        VALUES ('Contract', 'PluginContratosFacturacion', ".$fact->fields['contracts_id'].", '18', '".getUserName($_SESSION['glpiID'])."', NOW(), 
						'".$_POST['name']."(".$_POST['id'].")')";
		$result = $DB->query($insert_logs);				 
   }
   Html::back();

}  else {
	  
   Html::header(__('Contratos', 'contrato'),
      $_SERVER['PHP_SELF'],
      "config",
      "PluginContratosConfig",
      "facturacion"
   );
    if (Session::haveRight('plugin_contratos_facturacion',READ)) {
		$fact->showForm($_GET["id"]);
		Html::footer();
	} else {
			Html::displayRightError();
	}     
}
?>