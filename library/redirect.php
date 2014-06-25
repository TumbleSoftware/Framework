<?php
  class redirect extends common_objects
  {
      public $file, $data;
           
      function __construct($file)
      {
          parent::__construct();
          $this->define_class(get_class($this));
          header('Location: ' . $file);
          exit();
      
      }
      
  
  
  
  
  }
?>