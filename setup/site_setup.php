<?php
    require('../framework.php');
  
  $template = new Page('./templates/setup/index.html','TumbleSoftware - ');
  $template->load_css('./css/setup/');
  $template->load_css('./css/forms/');
  $template->load_css('./css/tooltips/');
  $template->add_jquery();
  $template->load_javascript('./javascript/common/');
  $template->load_javascript('./javascript/setup/');
  $template->add_many();
  include('./inc_cms.php');
  
    //WHEN THE TREE CLASS LOADS DATA FROM A TABLE IT WILL USE THE INFORMATION PASSED IN THE DESCRIBE_VAR FUNCTION TO ASSIGN DATA
    $obj_value->cms_section_name = 'Home'; //tHE TABLE CONTAINS A FIELD CALLED 'title'
    $obj_value->cms_section_description = 'Welcome to the CMS, please select an option.'; //tHE TABLE CONTAINS A FIELD CALLED 'description'
    $obj_value->cms_section_reserved_name = 'ROOT';
    $obj_value->cms_section_image = '';
    $obj_value->cms_section_file = './home.php';
    $tree = new tree($obj_value,'ROOT','cms'); //CREATE A TREE CLASS WITH A ROOT NODE, also takes a $tablename param which stores the $tablename of the tree list
    $tree->database_save();
 
  /*Breadcrumbs*/
  $breadcrumbs = new Menu('./templates/setup/breadcrumbs/breadcrumbs.html');

  $breadcrumbs->breadcrumbs('asite-setup-setup', 'selected-breadcrumb', 'data-item-id','a');
  $template->load_html_file('./templates/setup/site_ready.html');
  
  $template->load_menu($breadcrumbs->nav);
  $template->display_html('Welcome to setup');
?>