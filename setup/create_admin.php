<?php
  require('../framework.php');
  
  $template = new Page('./setup/templates/index.html','TumbleSoftware - ');
  $template->load_css('./css/setup/');
  $template->load_css('./css/forms/');
  $template->load_css('./css/tooltips/');
  $template->add_jquery();
  $template->add_many();
  

$template->add_tooltips('./javascript/tooltips/tumble_tooltips.js','tumble-tooltip');
  
 
  /*Breadcrumbs*/
 /* $breadcrumbs = new Menu('./templates/setup/breadcrumbs/breadcrumbs.html');

  $breadcrumbs->breadcrumbs('admin-setup', 'selected-breadcrumb', 'data-item-id','a');*/
  include($GLOBALS['site_framework_location'].'./setup/forms/admin.php');
  $template->load_form($form,'./setup/templates/forms/admin.html');  
  
 // $template->load_menu($breadcrumbs->nav);
  $template->display_html('Welcome to setup');
?>