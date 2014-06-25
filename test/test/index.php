<?php
 
  require('../../framework.php');

  
   include('./forms_php/add_node.php');
  
  

  
  /*Load another form*/
  /*$form_horizontal = new form('add_node',FORM_NORMAL,'./register.php','register-form',FORM_COLUMNS,0);
  $segment = $form_horizontal->segment('register-left', FORM_COLUMNS);
  $segment->add_text_input('user_username','Node Title','','','','Username');
  $segment->add_password_input('user_password','Node Description','','','','Password');
  $segment2 = $form_horizontal->segment('register-right', FORM_COLUMNS);
  $segment2->add_text_input('menu_title2','Node Title','','','','E-Mail');
  $segment2->add_text_input('menu_description2','Node Description','','','','Handle');
  $segment3 = $form_horizontal->segment('register-buttons', FORM_COLUMNS);
  $segment3->add_submit_button('submit','register-submit-button', 'Register');*/
  
  
  $menu = new Menu('./templates/site_menu/site_menu.html');
  $menu->selected('HelgeSverre', 'selected-nav', 'data-item-id','a');
  $template = new Page('./templates/index/index.html','TumbleSoftware - ');
  
  $template->load_css('./css/');

  $template->add_jquery();
  $template->load_javascript('./javascript/common/');
  $template->load_html_file('./templates/header/header.html');
  $template->load_menu($menu->nav);
  $template->load_form($form,'./templates/forms/add_node.html');
  $template->load_form($form_horizontal, './templates/forms/register.html');
  $template->display_html('Welcome');
  
  





  



   


?>