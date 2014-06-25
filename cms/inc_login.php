<?php
   $form = new form('login-form',FORM_NORMAL,'./index.php','login-form',FORM_COLUMNS,0);
  $segment = $form->segment('login-form', FORM_COLUMNS);
  $tooltip = null;
  $validate = new validate('The username is required..');
  $validate->required_var = true;
  $segment->add_text_input('user_username','Username','','','','Username', null, null);
  
  
  
  $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'Must be greater than 6 characters in length and contain letters and numbers.';
  $validate = new validate('The password must be 8 characters long and contain at least one number and letter.');
  $validate->is_password = true;
  $segment->add_password_input('user_password','Password','','','','Password', null, null);
  
  $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'If checked your Admin details will be E-Mailed to the above address..';
  $validate = null;
  $segment->add_checkbox_input('remember_me', false, 'remember-me', '', 'Remember Me?',null, null);
  
  $segment4 = $form->segment('login-submit', FORM_COLUMNS);
  $segment4->add_submit_button('submit','login-admin-button', 'Login');

  if($form->is_form_submitted())
  {
    $data = $form->process_form(0);
    $user = new user('backend', 'users', 'users_ip_access');
    $logged_in = $user->check_login($data['user_username'],$data['user_password'],false,'users',$data['remember_me']); 
    if(!$logged_in)
    {
        $form->messages->errors[] = 'Invalid Username/Password Combination.';
        $form->validated = false;
    }else
    {
        $redirect = new redirect('./home.php');
    }
    
    
    
  }



?>