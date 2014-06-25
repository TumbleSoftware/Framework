<?php
  class param extends common_objects
  {
    public static $database;
    function __construct()
    {
                  parent::__construct();
          $this->define_class(get_class($this));
    }
    
    function get_param($fieldname,$default, $htmlspecialchars_on = true)
    {
       if(isset($_REQUEST[$fieldname]))
       {
        $val = $_REQUEST[$fieldname];
       }else
       {
        $val = $default;  
       }
       if($htmlspecialchars_on)
       {
          $val = htmlspecialchars($val, ENT_QUOTES);
       }
       
       return $val;
    
    }
  
    function get_integer($fieldname, $default)
    {
        $val = $this->get_param($fieldname,$default, false);
        if(is_numeric($val))
        {
            return $val;
        }else
        {
            return $default;
        }    
    }
    
   
    function form_processed($form_id)
    {
      if($this->get_integer($form_id.'-submit',0))
      {
            return true;
      }
      return false;
    }
  
  
  
  }
?>