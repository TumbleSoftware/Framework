<?php
 //ini_set('display_errors', FALSE);
  require('../framework.php');
  
  $template = new Page('./cms/templates/index.html','TumbleSoftware - ');
  $template->load_css('./cms/css/setup/');
  $template->load_css('./cms/css/forms/');
  $template->load_css('./cms/css/admin/');
  $template->load_css('./cms/css/tooltips/');
  $template->add_jquery();
  

  tooltip_base::$data_tip = 'left';
  tooltip_base::$data_fade_out = "3000";
  tooltip_base::$data_fade_in = '3000';
  tooltip_base::$data_tooltip_event = 'click';
  tooltip_base::$class = 'tumble-tooltip';
  $template->add_tooltips('./cms/javascript/tooltips/tumble_tooltips.js',tooltip_base::$class);
  
  $template->load_html_file('./cms/templates/home/home.html');
  
  /*Breadcrumbs*/
  //$breadcrumbs = new Menu('./cms/templates/breadcrumbs/breadcrumbs.html');

  //$breadcrumbs->breadcrumbs('database-configuration', 'selected-breadcrumb', 'data-item-id','a');
    
  
  //$template->load_menu($breadcrumbs->nav);
  $template->display_html('CMS - Welcome');
?>