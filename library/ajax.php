<?php
  
  $ajax_table = new create_table('ajax',$database->stub);
  $ajax_table->add_field(true,'ajax_id','INT(11)');
  $ajax_table->add_field(false,'ajax_action','VARCHAR(100)');
  $ajax_table->add_field(false,'ajax_element','VARCHAR(100)');
  $ajax_table->add_field(false,'ajax_event','VARCHAR(100)');
  $ajax_table->add_field(false,'ajax_callback','VARCHAR(100)');
  $ajax_table->add_field(false,'ajax_return_type','VARCHAR(100)');
  $ajax_table->add_field(false,'ajax_method','VARCHAR(100)');
  $ajax_table->add_field(false,'ajax_form_id','VARCHAR(100)');
  
  $database->database_create_tables($ajax_table);
  
  class ajax_data
  {
     public $ajax_action, $ajax_element, $ajax_event, $ajax_callback, $ajax_return_type, $ajax_method, $ajax_form_id;
     public static $database;
     
      function __construct($action, $form_id, $element, $event, $callback, $return_type, $method_of_action)
     {
        $this->ajax_action = $action;
        $this->ajax_element = $element;
        $this->ajax_event = $event;
        $this->ajax_callback = $callback;
        $this->ajax_return_type = $return_type;
        $this->ajax_method = $method_of_action;
        $this->ajax_form_id = $form_id;
     }
  
  }
  
  
  class ajax extends common_objects
  {
     public $ajax_action, $ajax_element, $ajax_event, $ajax_callback, $ajax_return_type, $ajax_method, $ajax_form_id;
  
     function __construct($action, $form_id, $element, $event, $callback, $return_type, $method_of_action, $data)
     {
        parent::__construct();
        $this->define_class(get_class($this));
        
        $this->ajax_action = $action;
        $this->ajax_element = $element;
        $this->ajax_event = $event;
        $this->ajax_callback = $callback;
        $this->ajax_return_type = $return_type;
        $this->ajax_method = $method_of_action;
        $this->ajax_form_id = $form_id;
        $this->ajax_data = $data;
     }
     
     function ajax_process()
     {         
          ob_start();
          ?>
            <script type = "text/javascript">
            $(document).ready(function(){
                $('<?=$this->ajax_element;?>').tumbleAjax({'url':'<?=$this->ajax_action;?>','method': '<?=$this->ajax_method;?>','data_type': '<?=$this->ajax_return_type;?>','data':<?=$this->ajax_data;?>,'done': <?=$this->ajax_callback;?>});
            });
            </script> 
          <?php
          return ob_get_clean();
      }
     


  }
?>