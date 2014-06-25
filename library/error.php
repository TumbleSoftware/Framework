<?php
   
   require('./library/phperrors.php');
  
  $GLOBALS['LIST_OF_DEBUG_IPS'] = array($_SERVER['REMOTE_ADDR']);
   $log_errors = new error_reporter($GLOBALS['LIST_OF_DEBUG_IPS'],'Global');   
   $log_errors->show_debug();
?>