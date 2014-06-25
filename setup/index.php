<?php
  //ini_set('display_errors', FALSE);
  require('../framework.php');
  //ini_set('display_errors', 0);
  $template = new Page('./setup/templates/index.html','TumbleSoftware - ');
  $template->load_css('./css/setup/');
  $template->load_css('./css/forms/');
  $template->load_css('./css/tooltips/');
  $template->add_jquery();
  

  $template->add_tooltips('./javascript/tooltips/tumble_tooltips.js','tumble-tooltip');
  $template->add_javascript('./javascript/common/ajax.js');

  if($database->connected)
  {
     $template->load_html_file('./setup/templates/database_already_connected.html');
  }else
  {
    include($GLOBALS['site_framework_location'].'/setup/forms/database.php');
    
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
    
    
    
    
    $template->load_form($form,'./setup/templates/forms/database.html');
    

    
    
  }
  
  /*Breadcrumbs*/
  //$breadcrumbs = new Menu('./setup/templates/setup/breadcrumbs/breadcrumbs.html');

  //$breadcrumbs->breadcrumbs('database-configuration', 'selected-breadcrumb', 'data-item-id','a');
    
  
  //$template->load_menu($breadcrumbs->nav);
  $template->display_html('Welcome to setup');
?>