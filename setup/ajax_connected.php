<?php
require('../framework.php');
include($GLOBALS['site_framework_location'].'/setup/forms/database.php');


        $data = $form->process_form(0);  
        
        

          $database_connection_status = new database($data['database_hostname'],$data['database_username'],$data['database_password'],$data['database_database'],'3307',$data['database_stub']);
          if(!$database_connection_status)
          {
             echo json_encode(array('connected'=>true));
             exit();
          }else
          {
            echo json_encode(array('connected'=>false));  
            exit();
          }
        




            echo json_encode(array('connected'=>false));  
            exit();

?>