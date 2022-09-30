<?php
/*
   ------------------------------------------------------------------------
   Autor: Grupo Inforges - Elena Martínez Ballesta
   Fecha: Enero 2016
   Plugin Contratos
   ------------------------------------------------------------------------
*/

if (!defined('GLPI_ROOT')) {
        die("Sorry. You can't access directly to this file");
}

// Class of the defined type
class PluginContratosContrato extends CommonDBTM {
	
   public $dohistory=true;

   //[INICIO] [CRI] JMZ18G CAMBIOS CORE - Heredar los permisos del objeto contract
   //static $rightname = "plugin_contratos";
   static $rightname = "contract";
   //[INICIO] [CRI] JMZ18G CAMBIOS CORE  - Heredar los permisos del objeto contract 
   
   static protected $notable=true;   
   
   // Should return the localized name of the type
   static function getTypeName($nb = 0) {
       return "Contratos - Extra";
   }
   
   static function canCreate() {
         return (Session::haveRight('plugin_contratos','UPDATE'));
   }
   
   static function canView() {
 	  return Session::haveRight('plugin_contratos', READ);
   }   

     
}
?>