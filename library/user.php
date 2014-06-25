<?php
  class user extends common_objects
  {
      public $user_id, $logged_in, $session_name, $obj_user_data, $tablename, $ip_tablename;
      
      function __construct($session_name, $tablename, $ip_tablename)
      {
          parent::__construct();
          $this->define_class(get_class($this));
          $this->session_name = $session_name;
          $this->tablename = $tablename;
          $this->ip_tablename = $ip_tablename;
            if(isset($_COOKIE[$this->session_name]))
            {
              $_SESSION[$sessionName]['username'] = $_COOKIE[$this->session_name]['username']; 
              $_SESSION[$sessionName]['password'] = $_COOKIE[$this->session_name]['password']; 
            }
        
            if(isset($_SESSION[$this->session_name]))
            {
                $this->check_login($_SESSION[$sessionName]['username'],$_SESSION[$sessionName]['password'],true, $tablename, true);
            }
          
            
          
      }
      
      function check_exists($username)
      {
         if(parent::$database->database_check_exists($this->tablename, 'user_username', $username))
          {
          
              return true;
          
          }
          
          return false;
      }
      
      function allowed_ips($arr_ips)
      {
         
         parent::$database->database_delete($this->ip_tablename,'allow_user='. $this->obj_user_data->user_id);
         foreach($arr_ips as $key=>$ip)
         {
            $obj_allow = new stdClass();
            $obj_allow->allow_user = $this->obj_user_data->user_id;
            $obj_allow->allow_ip = $ip;
            parent::$database->database_insert($this->ip_tablename, $obj_allow);
         }
      }
      
      function create_user($obj_data, $email_user = false, $allowed_ips = array())
      {
          if(!parent::$database->database_check_exists($this->tablename, 'user_username', $obj_data->user_username))
          {        
                $seed = md5(uniqid(rand(), true));
                $length = rand(10,15);
                $seed = substr($seed,0,$length);
                $password = $obj_data->user_password;
                $obj_data->user_password = crypt($obj_data->user_password, $seed);
                
                $config = new config('./library/seeds.ini');
                $config->data[$obj_data->user_username] = $seed;
                
                $config->write_config($config->data);
              
              
              $this->user_id = parent::$database->database_insert($this->tablename, $obj_data);
              $this->obj_user_data = $obj_data;
              $this->obj_user_data->user_id = $this->user_id;
              if($email_user)
              {
                  $this->mail_user($password, $this->user_id, $this->tablename);
              }
              $this->allowed_ips($allowed_ips);
              
              
              return true;
          }
          
          return false;
      }
      
      function mail_user($password, $user_id, $tablename)
      {
          $str_query = 'SELECT * FROM ' . parent::$database->database_tablename($tablename) . ' where user_id = ' . $user_id;
          
          $rst_user = parent::$database->database_query($str_query);
          $obj_user = parent::$database->database_fetch($rst_user);
          
          $message = "Your Login Details are below....\r\n";
          $message .= "Username: ".$obj_user->user_username."\r\n";
          $message .= "Password: ".$password."\r\n";
          // In case any of our lines are larger than 70 characters, we should use wordwrap()
          $message = wordwrap($message, 70, "\r\n");
          $headers = 'From: ' . $obj_user->user_email .  "\r\n" .
    'Reply-To: '.$obj_user->user_email ."\r\n" .
    'X-Mailer: PHP/' . phpversion();
          
          // Send
          mail($obj_user->user_email, 'Login Details', $message, $headers);
      
      }
      
      function check_login($username, $password, $encrypted = false,  $tablename, $remember_me = false)
      {
         $config = new config('./library/seeds.ini');
         if(!$encrypted)
         {
            $encrypted_password = crypt($password, $config->data[$username]);
         }else
         {
           $encrypted_password = $password; 
         }
         $str_query = 'SELECT * FROM ' . parent::$database->database_tablename($tablename) . ' WHERE user_username = \''.$username.'\' AND user_password = \''.$encrypted_password.'\'';
         $rst_logged_in = parent::$database->database_query($str_query);
         
         if(parent::$database->database_hasrows($rst_logged_in))
         {
            $this->logged_in = true;
            $this->obj_user_data = parent::$database->database_fetch($rst_logged_in);
            
            $_SESSION[$this->session_name]['username'] = $this->obj_user_data->user_username;
            $_SESSION[$this->session_name]['password'] = $this->obj_user_data->user_password;
            
            if($remember_me)
            {
                $expire = strtotime(date('Y-m-d H:i:s',time()).' + 1 Month');
                setcookie($this->session_name.'[username]',$this->obj_user_data->user_username,$expire);
                setcookie($this->session_name.'[password]',$this->obj_user_data->user_password,$expire);
            }
            
            return true;
         }
        
          return false;
      
      }
      
      
      

  
  
  
  
  
  
  }
?>