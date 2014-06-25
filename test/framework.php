<?php
  session_start();
  
  /*server config variables*/
$GLOBALS['site_framework_location'] = str_replace($_SERVER['REQUEST_URI'],'',dirname(__FILE__));
  echo dirname(__FILE__).' '.$GLOBALS['site_framework_location'] . ' ' . dirname($_SERVER['REQUEST_URI']);
  exit();
  
  $GLOBALS['LIST_OF_DEBUG_IPS'] = array($_SERVER['REMOTE_ADDR']); 
  $xml=simplexml_load_file($GLOBALS['site_framework_location'] ."./library/load_order.xml");


 foreach($xml->children() as $child) {
   require($GLOBALS['site_framework_location'] . './library/'.$child);
 }
 
 
  $log_errors = new error_reporter($GLOBALS['LIST_OF_DEBUG_IPS']);

  



  register_shutdown_function(array(&$log_errors,'check_for_fatal'));
  set_error_handler(array(&$log_errors,'add_error'));
?>