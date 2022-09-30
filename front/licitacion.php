<?php
/*
   ------------------------------------------------------------------------
   Autor: Grupo Inforges - Elena Martínez Ballesta
   Fecha: Enero 2016
   Plugin Contratos
   ------------------------------------------------------------------------
*/

include ("../../../inc/includes.php");

Html::header(__('Contratos', 'contratos'), $_SERVER['PHP_SELF'] ,"config", "PluginContratosLicitacion", "licitacion");

// Check if plugin is activated...
$plugin = new Plugin();
if(!$plugin->isInstalled('contratos') || !$plugin->isActivated('contratos')) {
   Html::displayNotFoundError();
}

if (Session::haveRight('plugin_contratos',READ)) {
	Search::Show('PluginContratosLicitacion');
	Html::footer();
} else {
	Html::displayRightError();
}
?>