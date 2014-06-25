<?php
   class tooltip_base
   {
      public $data_tip, $data_fade_out, $data_fade_in, $data_tooltip_event, $class;  
   }
   
   class tooltip extends tooltip_base
   {
       public $data_tooltip_content, $data_classes = '';
        
        
        function __construct()
        {
 
        }
        
        function data_tooltip()
        {
            return ' data-tip="'.$this->data_tip.'" data-classes="'.$this->data_classes.'" data-fade-out="'.$this->data_fade_out.'" data-fade-in="'.$this->data_fade_in.'" data-tooltip-content="'.$this->data_tooltip_content.'" data-tooltip-event="'.$this->data_tooltip_event.'" ';
        
        }
        
        function define_tooltip_class()
        {
            return $this->class;
        }
   }
?>