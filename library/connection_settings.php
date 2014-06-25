<?php
    
  /*Set the database object*/
  $config = new config('./library/database.ini');

    $database = new database($config->data['database_hostname'],$config->data['database_username'],$config->data['database_password'],$config->data['database_database'],'3307',$config->data['database_stub']);
    common_objects::$database = $database;
  
?>