<?php
  require('../framework.php');
  
  $template = new Page('./templates/setup/index.html','TumbleSoftware - ');
  $template->load_css('./css/setup/');
  $template->load_css('./css/forms/');
  $template->load_css('./css/tooltips/');
  $template->add_jquery();
  $template->add_many();
  

  tooltip_base::$data_tip = 'left';
  tooltip_base::$data_fade_out = "3000";
  tooltip_base::$data_fade_in = '3000';
  tooltip_base::$data_tooltip_event = 'click';
  tooltip_base::$class = 'tumble-tooltip';
  $template->add_tooltips('./javascript/tooltips/tumble_tooltips.js',tooltip_base::$class);
  
 
  /*Breadcrumbs*/
  $breadcrumbs = new Menu('./templates/setup/breadcrumbs/breadcrumbs.html');

  $breadcrumbs->breadcrumbs('admin-setup', 'selected-breadcrumb', 'data-item-id','a');
  include($GLOBALS['site_framework_location'].'./forms_php/setup/admin.php');
  $template->load_form($form,'./templates/forms/setup/admin.html');  
  
  $template->load_menu($breadcrumbs->nav);
  $template->display_html('Welcome to setup');
?>