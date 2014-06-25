<?php
  class common_objects extends error_reporter
  {
      public static $database;
      
      function __construct()
      {
          parent::__construct($GLOBALS['LIST_OF_DEBUG_IPS']);
      
      }
     

  }
?>