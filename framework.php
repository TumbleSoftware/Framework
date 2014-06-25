<?php
  session_start();
  
  /*server config variables*/
  $GLOBALS['current_framework_folder'] = str_replace('\\','/',str_replace(realpath($_SERVER["DOCUMENT_ROOT"]),'', realpath(dirname(__FILE__)))) . '/';
$GLOBALS['site_framework_location'] = $_SERVER["DOCUMENT_ROOT"] . ltrim(str_replace('\\','/',str_replace(realpath($_SERVER["DOCUMENT_ROOT"]),'', realpath(dirname(__FILE__)))),'/') . '/';

  $GLOBALS['LIST_OF_DEBUG_IPS'] = array($_SERVER['REMOTE_ADDR']); 
  $xml=simplexml_load_file($GLOBALS['site_framework_location'] ."./library/load_order.xml");


 foreach($xml->children() as $child) {
   require($GLOBALS['site_framework_location'] . './library/'.$child);
 }
 
 
  $log_errors = new error_reporter($GLOBALS['LIST_OF_DEBUG_IPS']);

  



  register_shutdown_function(array(&$log_errors,'check_for_fatal'));
  set_error_handler(array(&$log_errors,'add_error'));
?>