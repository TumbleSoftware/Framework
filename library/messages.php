<?php
  class messages extends common_objects
  {
      public $errors = array();
      
      function __construct()
      {
          parent::__construct();
          $this->define_class(get_class($this));
      
      }
      
      function error($msg)
      {
          $output = '<div class = "tumble-software-errors"><p>'.$msg.'</p>';
          if(count($this->errors))
          {
              $output .= '<ul>';
              foreach($this->errors as $key=>$value)
              {
                  $output .= '<li>'.$value.'</li>';
              }
              $output .= '</ul>';
          }
          $output .= '</div>';
          return $output;
      }
  
  
  
  
  
  
  }
?>