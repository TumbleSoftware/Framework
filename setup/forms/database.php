<?php

  $ajax = new ajax('./ajax_connected.php','','#add-database-test-connection','click','function(data){
  
     if(data.connected)
     {
        $(\'#add-database-test-connection\').html(\'Database Connection Successful.\');
     }else
     {
      $(\'#add-database-test-connection\').html(\'Database Connection Unsuccesful.\');
     } 
  
  }','JSON','POST','$(\'#database-connection\').serialize()'); 


  $form = new form('database-connection',FORM_NORMAL,'','database-connection',FORM_COLUMNS,0);
  $form->ajax($ajax);
  $segment = $form->segment('add-database-settings', FORM_COLUMNS);
  $tooltip = new tooltip();
  $tooltip->data_tip = "right";
  $tooltip->data_fade_out = '5000';
  $tooltip->data_fade_in = '2000';
  $tooltip->class = 'tumble-tooltip';
  $tooltip->data_tooltip_event = 'click';
  $tooltip->data_tooltip_content = 'The host of the mysql server being used. This is typically localhost for security reasons.';
  $validate = new validate('The host is required.');
  $validate->required_var = true;
  $segment->add_text_input('database_hostname','database-hostname','localhost','Host','','Host', $tooltip, $validate);
  
  
  

  $tooltip = new tooltip();
  $tooltip->data_tip = "right";
  $tooltip->data_fade_out = '5000';
  $tooltip->data_fade_in = '2000';
  $tooltip->data_tooltip_event = 'click';
  $tooltip->class = 'tumble-tooltip';
  $tooltip->data_tooltip_content = 'When you create a database, you assign a user to that database. This is the username of that user. This information can be configured and found in your hosting control panel..';
  $validate = new validate('The database username is required.');
  $validate->required_var = true;
  $segment->add_text_input('database_username','database-username','','Username','','Username', $tooltip, $validate);
  

    $tooltip = new tooltip();
  $tooltip->data_tip = "right";
  $tooltip->data_fade_out = '5000';
  $tooltip->data_fade_in = '2000';
  $tooltip->class = 'tumble-tooltip';
  $tooltip->data_tooltip_event = 'click';
  $tooltip->data_tooltip_content = 'Password for the user of the database. It is important for your mySql database to have a user and a password set to protect your data.';
  $segment->add_text_input('database_password','database-password','','Password','','Password', $tooltip);
  
  

    $tooltip = new tooltip();
  $tooltip->data_tip = "right";
  $tooltip->data_fade_out = '5000';
  $tooltip->data_fade_in = '2000';
  $tooltip->data_tooltip_event = 'click';
  $tooltip->class = 'tumble-tooltip';
  $tooltip->data_tooltip_content = 'The name of the database the site uses. Database can be create in your hostings control panel..';
   $validate = new validate('The database name is required.');
  $validate->required_var = true;
  $segment->add_text_input('database_name','database-name','','Database Name','','Database Name', $tooltip, $validate);
  
  /*Stub is optional*/

      $tooltip = new tooltip();
  $tooltip->data_tip = "right";
  $tooltip->data_fade_out = '5000';
  $tooltip->data_fade_in = '2000';
  $tooltip->data_tooltip_event = 'click';
  $tooltip->class = 'tumble-tooltip';
  $tooltip->data_tooltip_content = 'The table stub is a prefix used to uniqly identify TumbleSoftware tables in the database. MUST FINISH WITH A _ . A typical stub would be tumblesoftware_';
  $segment->add_text_input('database_stub','database-stub','','Stub','','Database Table Prefix', $tooltip, null);
  
  
  $segment->add_submit_button('submit','add-database-settings-button', 'Add Database Settings');
  $segment->add_submit_button('button','add-database-test-connection', 'Test Connection');

  

?>