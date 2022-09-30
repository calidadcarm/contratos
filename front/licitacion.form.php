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

$lic = new PluginContratosLicitacion();

if (isset($_POST["add"])) {
   $lic->check(-1, CREATE,$_POST);

   if ($newID = $lic->add($_POST)) {
	  //Actualizamos el histórico 
		$insert_logs = "INSERT INTO glpi_logs (itemtype, items_id, linked_action, user_name) 
                        VALUES ('PluginContratosLicitacion',".$lic->fields['id'].", '20', '".getUserName($_SESSION['glpiID'])."')";
		$result = $DB->query($insert_logs);
   }
   Html::back();

} else if (isset($_POST["purge"])) {
   $lic->check($_POST["id"], PURGE);

   if ($lic->delete($_POST, 1)) {		 
	  //Actualizamos el histórico 
		$insert_logs = "INSERT INTO glpi_logs (itemtype, itemtype_link, items_id, linked_action, user_name, date_mod, old_value) 
                        VALUES ('Contract', 'PluginContratosLicitacion', ".$lic->fields['contracts_id'].", '19', '".getUserName($_SESSION['glpiID'])."', 
						NOW(), '".$_POST['name']."(".$_POST['id'].")')";
		$result = $DB->query($insert_logs);
					 
   }
   $contract = new Contract();
   $contract->getFromDB($lic->fields['contracts_id']);
   Html::redirect(Toolbox::getItemTypeFormURL('Contract').'?id='.$lic->fields['contracts_id'].
                  ($contract->fields['is_template']?"&withtemplate=1":""));

} else if (isset($_POST["update"])) {
	
   $lic->check($_POST["id"], UPDATE);
   if ($lic->update($_POST)) {
 	  //Actualizamos el histórico 
		$insert_logs = "INSERT INTO glpi_logs (itemtype, itemtype_link, items_id, linked_action, user_name, date_mod, new_value) 
                        VALUES ('Contract', 'PluginContratosLicitacion', ".$lic->fields['contracts_id'].", '18', '".getUserName($_SESSION['glpiID'])."', NOW(), 
						'".$_POST['name']."(".$_POST['id'].")')";
		$result = $DB->query($insert_logs);				 
   }
   Html::back();

}  else {
	  
   Html::header(__('Contratos', 'contrato'),
      $_SERVER['PHP_SELF'],
      "config",
      "PluginContratosConfig",
      "licitacion"
   );
    if (Session::haveRight('plugin_contratos_licitacion',READ)) {
		$lic->showForm($_GET["id"]);
		Html::footer();
	} else {
			Html::displayRightError();
	}     
}
?>