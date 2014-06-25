<?php
  class config extends common_objects
  {
      public $file, $data, $loaded = false;
           
      function __construct($file)
      {
          parent::__construct();
          $this->define_class(get_class($this));
          $this->file = $GLOBALS['site_framework_location'].$file;
          
          if(file_exists($this->file))
          {
              $this->data = parse_ini_file($this->file);
              $this->loaded = true;
          }
      
      }
      
      function write_config($config)
      {
          $res = array();
          foreach($config as $key => $val)
          {
              if(is_array($val))
              {
                  $res[] = "[$key]";
                  foreach($val as $skey => $sval) $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
              }
              else $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
          }
         file_put_contents($this->file, implode("\r\n", $res));
         chmod($this->file,400);
      }
  
  
  
  
  
  
  }
?>