<?php
/*
   ------------------------------------------------------------------------
   Autor: Grupo Inforges - Elena Martínez Ballesta
   Fecha: Enero 2015
   Plugin Contratos
   ------------------------------------------------------------------------
 */
 
define('GLPI_ROOT', '../../..');
include (GLPI_ROOT."/inc/includes.php");
include_once (GLPI_ROOT."/plugins/contratos/inc/profile.class.php");

Session::checkRight("profile","READ");
$prof=new PluginContratosProfile();

//Save profile
if (isset ($_POST['update'])) {
	$prof->update($_POST);
	Html::redirect($_SERVER['HTTP_REFERER']);
}

?>