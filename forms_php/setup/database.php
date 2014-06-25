<?php
  
  
  
  
  $form = new form('database-connection',FORM_NORMAL,'./setup.php','database-connection',FORM_COLUMNS,0);
  $segment = $form->segment('add-database-settings', FORM_COLUMNS);
  $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'The host of the mysql server being used. This is typically localhost for security reasons.';
  $validate = new validate('The host is required.');
  $validate->required_var = true;
  $segment->add_text_input('database_hostname','Host Name','','','','Host', $tooltip, $validate);
  
  
  
  $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'When you create a database, you assign a user to that database. This is the username of that user. This information can be configured and found in your hosting control panel..';
  $validate = new validate('The database username is required.');
  $validate->required_var = true;
  $segment->add_text_input('database_username','Username','','','','Username', $tooltip, $validate);
  
  $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'Password for the user of the database. It is important for your mySql database to have a user and a password set to protect your data.';
  $segment->add_text_input('database_password','Password','','','','Password', $tooltip);
  
  
  $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'The name of the database the site uses. Database can be create in your hostings control panel..';
   $validate = new validate('The database name is required.');
  $validate->required_var = true;
  $segment->add_text_input('database_database','Database Name','','','','Database Name', $tooltip, $validate);
  
  /*Stub is optional*/
    $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'The table stub is a prefix used to uniqly identify TumbleSoftware tables in the database. MUST FINISH WITH A _ . A typical stub would be tumblesoftware_';
  $segment->add_text_input('database_stub','Database table prefix (Stub)','','','','Database table prefix (Stub)', $tooltip);
  
  
  $segment->add_submit_button('submit','add-database-settings-button', 'Add Database Settings');
  
  if($form->is_form_submitted())
  {
    $data = $form->process_form(0);  
    
    
    if($form->validated == true)
    {
      $database_connection_status = new database($data['database_hostname'],$data['database_username'],$data['database_password'],$data['database_database'],'3307',$data['database_stub']);
      if(!$database_connection_status)
      {
        $form->messages->errors[] = 'The database settings provided did not connect to the database.';
      }else
      {
          $config = new config('./library/database.ini');
          $config->write_config($data);
          $redirect = new redirect('./setup.php');
      }  
    }
  }
  

?>