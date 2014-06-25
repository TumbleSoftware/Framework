<?php

    define('MYSQL_ERROR', 52);
    
    class error_reporter
    {
        protected $errors, $allowed = array(), $class_name, $show_debug_details = 0;
        

        function define_class($class_name = 'Unknown')
        {
           $this->class_name = $class_name;
           
           if(isset($_SESSION['errors'][$_SERVER['PHP_SELF']][$class_name]['error_log']))
           {
            $this->errors = $_SESSION['errors'][$_SERVER['PHP_SELF']][$class_name]['error_log'];
           }
        }

        
        function __construct($ips = array()) /*Called when we create an object of this class*/
        {
          
          
          $this->show_debug_details = isset($_GET['debug_show']) == true ? 1: 0;
          
          

          
          
          $this->add_allowed_ip($ips);
        }
        
        function add_allowed_ip($ips = array())
        {
            foreach($ips as $key=>$ip)
            {
                $this->allowed[] = $ip;
            }
        }
        

        
        function add_error($errno, $errstr, $errfile, $errline)
        {

         $trace = ''; 
        

            $this->errors[] = array('Number'=>$errno,'Message'=>$errstr,'File'=>$errfile, 'Line'=> $errline, 'Backtrace'=>$trace);
           $_SESSION['errors'][$_SERVER['PHP_SELF']][$this->class_name]['error_log'] = $this->errors;

        }
        
        
        function check_for_fatal()
         {

            
            $error = error_get_last();
            if(isset($error))
            {
            $this->add_error($error["type"],$error["message"],$error["file"],$error["line"]);
            }
              
                 
         
         }
        
       
        
        function show_debug_all($clear = false)
        {
            if(in_array($_SERVER['REMOTE_ADDR'],$this->allowed) && $this->show_debug_details == 1)
            {
                
                foreach($_SESSION['errors'] as $filename => $arr_data)
                {
                
                foreach($arr_data as $class_name => $arr_data)
                {
                /*Print the errors*/
                echo '<h1>Errors for '.$filename . ': ' . $class_name . '</h1>';
                
                foreach($_SESSION['errors'][$filename][$class_name]['error_log'] as $key=>$error_log)
                {
                    
                    $str_type = '';
                    switch ($error_log['Number']) {
                      case E_ERROR:
                           $this->check_for_fatal();
                          break;
                  
                      case E_WARNING:
                          $str_type = 'Warning';
                          break;
                  
                      case E_NOTICE:
                          $str_type = 'Notice';
                          break;
                  
                      default:
                          $str_type = 'Unknown';
                          break;
                      }
                    
                    
                    echo '<strong>'. $str_type.'</strong> - Line: '.$error_log['Line'] . ' - <em>' . $error_log['Message'] . '</em><br />';
                    var_dump($error_log['Backtrace']);
                
                }
                
                }
                
                echo '<hr />';
            
               }
            
            }
            
            if($clear == true)
            {
                unset($_SESSION['errors']);
            }
        
        }

    
    
    
    
    
    }
?>