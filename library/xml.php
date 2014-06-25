<?php
  class xml_parse extends common_objects
  {
        public $data = array();
        function __construct()
        {
          parent::__construct();
          $this->define_class(get_class($this));
        }
        
        function parse_file($filename)
        {
           
          $sxi = new SimpleXmlIterator($filename);
          $this->parse($sxi,$this->data);
        }
        
        function parse_string($string)
        {
           //$xml =  new SimpleXMLElement($string);
           $sxi = new SimpleXmlIterator($string);
           $this->parse($sxi,$this->data);
           
        }
        
        function parse($sxi, &$data)
        {
           
           for( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {

              
              if($sxi->hasChildren()){
              
                $data[$sxi->key()][] = array();
                $this->parse($sxi->current(), $data[$sxi->key()][count($data[$sxi->key()]) - 1]);  
              }
              else
              {
                $data[$sxi->key()][] = strval($sxi->current());
              }
           }
        }
  
  
  }
?>