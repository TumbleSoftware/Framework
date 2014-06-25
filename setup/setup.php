<?php
  ini_set('display_errors', FALSE);
  require('./framework.php');
  
  $template = new Page('./templates/setup/index.html','TumbleSoftware - ');
  $template->load_css('./css/setup/');
  $template->load_css('./css/forms/');
  $template->load_css('./css/tooltips/');
  $template->add_jquery();
  

  tooltip_base::$data_tip = 'left';
  tooltip_base::$data_fade_out = "3000";
  tooltip_base::$data_fade_in = '3000';
  tooltip_base::$data_tooltip_event = 'click';
  tooltip_base::$class = 'tumble-tooltip';
  $template->add_tooltips('./javascript/tooltips/tumble_tooltips.js',tooltip_base::$class);
  
  if($database->connected)
  {
     $template->load_html_file('./templates/setup/database_already_connected.html');
  }else
  {
    include('./forms_php/setup/database.php');
    $template->load_form($form,'./templates/forms/setup/database.html');
  }
  
  /*Breadcrumbs*/
  $breadcrumbs = new Menu('./templates/setup/breadcrumbs/breadcrumbs.html');

  $breadcrumbs->breadcrumbs('database-configuration', 'selected-breadcrumb', 'data-item-id','a');
    
  
  $template->load_menu($breadcrumbs->nav);
  $template->display_html('Welcome to setup');
?>