<?php
   class validate extends common_objects
   {
        public $required_var = false, $is_email_var = false, $is_url_var = false, $is_float_var = false, $is_numeric_var = false, $is_price_var = false,$is_password = false ,$is_ip_var = false, $msg;
        private $error;
        
        function __construct($msg)
        {
          parent::__construct();
          $this->define_class(get_class($this));
          $this->msg = $msg;
        }
        
        function validate_var($value)
        {
           if($this->required_var == true)
           {
              $this->required($value);
           }
           
            if($this->is_email_var == true)
           {
              $this->is_email($value);
           }
           
                      if($this->is_url_var == true)
           {
              $this->is_url($value);
           }
           
                      if($this->is_float_var_var == true)
           {
              $this->is_float($value);
           }
           
            if($this->is_numeric_var == true)
           {
              $this->is_numeric($value);
           }
           
           if($this->is_price_var == true)
           {
              $this->is_price($value);
           }
           
            if($this->is_ip_var == true)
           {
              $this->is_ip($value);
           }
           
           if($this->is_password == true)
           {
              $this->is_password($value);
           }
           
            if($this->is_ip_var == true)
           {

              $this->is_ip($value);
           }
           
           if($this->error == false)
           {
              return true;  
           }
           
           
           
           return false;
           
        }
        
        function required($value)
        {
           if(strlen(trim($value)) == '')
           {
              $this->error = true;
           }
        
        }
        
        function is_password($pwd)
        {
            if (strlen($pwd) < 8) {
                $this->error = true;
            }
        
            if (!preg_match("#[0-9]+#", $pwd)) {
               $this->error = true;
            }
        
            if (!preg_match("#[a-zA-Z]+#", $pwd)) {
                $this->error = true;
            }    
        }
        
        
        function is_email($email)
        {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
              // invalid emailaddress
              $this->error = true;
            }
        }
        
        function is_ip($ip)
        {

           
            if(!filter_var($ip, FILTER_VALIDATE_IP)) {
              // invalid emailaddress
 
              $this->error = true;
            }
        }
        
        function is_url($url)
        {
            if(!filter_var($url, FILTER_VALIDATE_URL))
            {
              $this->error = true;  
            }
        }
        
        function is_float($float)
        {
            if(!is_float($float))
            {
              $this->error = true;
            }
        
        }
        
        function is_numeric($number)
        {
            if(!is_numeric($number))
            {
              $this->error = true;
            }
        
        }
        
        function is_price($price)
        {
            $pattern = '/^\d+(?:\.\d{2})?$/';
            if(!preg_match($pattern, $price))
            {
              $this->error = true;
            }
        
        }
        
        
   
   
   
   
   
   
   
   
   }
?>