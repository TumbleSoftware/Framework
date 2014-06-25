<?php
  
  
  
  
  $form = new form('add-admin-form',FORM_NORMAL,'./create_admin.php','add-admin-form',FORM_COLUMNS,0);
  $segment = $form->segment('add-admin', FORM_COLUMNS);
  $tooltip = null;
  $validate = new validate('The username is required..');
  $validate->required_var = true;
  $segment->add_text_input('user_username','Admin Username','','','','Username', $tooltip, $validate);
  
  
  
  $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'Must be greater than 6 characters in length and contain letters and numbers.';
  $validate = new validate('The password must be 8 characters long and contain at least one number and letter.');
  $validate->is_password = true;
  $segment->add_password_input('user_password','Admin Password','','','','Password', $tooltip, $validate);
  
    $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'Must be greater than 6 characters in length and contain letters and numbers.';
  $validate = new validate('The Admin Password is required.');
  $validate->required_var = true;
  $segment->add_password_input('confirm','Confirm Password','','','','Confirm Password', $tooltip, $validate);

  
  $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'Must be a valid E-Mail address.';
   $validate = new validate('The E-Mail address must be valid..');
  $validate->is_email_var = true;
  $segment->add_text_input('user_email','Admin E-Mail','','','','Admin E-Mail', $tooltip, $validate);
  
  
  
  $segment2 = $form->segment('add-admin-settings', FORM_COLUMNS);
  $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'If checked your Admin details will be E-Mailed to the above address..';
  $validate = null;
  $segment2->add_checkbox_input('email_details', false, 'email-details', '', 'E-Mail Details',$tooltip, $validate);
  
  
  $segment3 = $form->segment('add-admin-settings-right', FORM_COLUMNS);
  
  $add_ips = new add_many('allowed_ips','','IP Addresses allowed access to the admin account','ADD IP');
  
    $tooltip = new tooltip();
  $tooltip->data_tooltip_content = 'Use www.ipshark.net to obtain your current IP address.';
  $validate = null;
  $ip_field = new text_input('enter_ip', '', 'enter-ip', '', 'IP Address', 'IP Address',  $tooltip, $validate); 
  $add_ips ->fields[] = $ip_field;
  $segment3->add_add_many($add_ips);  
  
  $segment4 = $form->segment('add-admin-submit', FORM_COLUMNS);
   $segment4->add_submit_button('submit','add-admin-button', 'Create Admin');
  
  
  if($form->is_form_submitted())
  {
    $data = $form->process_form(0);  
    
    if($data['user_password'] != $data['confirm'])
    {
       $form->messages->errors[] = 'The password and confirm password fields do not match.';
       $form->validated = false; 
    }

    $ips = json_decode(htmlspecialchars_decode($data['allowed_ips'],ENT_QUOTES));
    $allowed_ips = array();
    foreach($ips as $key => $value)
    {
        foreach($value as $key2 => $ip)
        {

          
          $validate = new validate('The IP entered is invalid.');
          $validate->is_ip_var = true;
          $result = $validate->validate_var($ip->value);
          if($result == false)
          {
           $form->messages->errors[] = 'One of the entered IP\'s is invalid.';
           $form->validated = false;

          }
          $allowed_ips[] = $ip->value;
          
        } 
    }
    $user = new user('backend', 'users', 'users_ip_access');
    
    if($user->check_exists($data['user_username']))
    {
        $form->messages->errors[] = 'The user already exists.';
       $form->validated = false;  
    }
    
    
    if($form->validated == true)
    {
       $email = $data['email_details'];
       echo $email;
       unset($data['confirm']);
       unset($data['email_details']);
       unset($data['allowed_ips']);
       $obj_data = convert_arr_to_object($data);
       
       
       $user->create_user($obj_data, $email, $allowed_ips);
       
       $redirect = new redirect('./create_admin.php');
    }
  }
  

?>