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
  
     function __construct($action, $form_id, $element, $event, $callback, $return_type, $method_of_action)
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
     }
     
     
     function database_store_ajax_call()
     {
       if(!parent::$database->database_check_exists('ajax','ajax_form_id',$this->ajax_form_id))
       {
          $temp_data = new ajax_data($this->ajax_action,$this->ajax_form_id,$this->ajax_element,$this->ajax_event,$this->ajax_callback,$this->ajax_reutrn_type,$this->ajax_method);  
         
          $int_id = parent::$database->database_insert('ajax',$temp_data);
       }
       return $this->ajax_form_id; 
      
     }
     
     function call_script($output_messages)
     {
        $data = array('id'=>urlencode($this->ajax_form_id),
              'message_output'=>$output_messages);

        $query = http_build_query($data);
        $query = str_replace('&',"&amp;", $query);
        
        $url = 'tumblesoftware_ajax.php?'.$query;
        return '<script src = "'.$url.'" type = "text/javascript"></script>';
     
     
     }
     
     function output_javascript($message_type = 0)
     {
         ob_start();
         ?>$('#<?=$this->ajax_element;?>').on('<?=$this->ajax_event;?>', function(){
         
              $.ajax({
                
                  type: "POST",
                
                  url: "<?=$this->ajax_action;?>",
                
                  data: $('#<?=$this->ajax_form_id;?>').serialize(),
                  
                  dataType: 'JSON'
                
                })
                
                  .done(function( msg ) {
                      
                       console.log(msg);
                       
                      if(msg[0]=='0')
                      {
                          
                          var output = '<div class = "tumble-software-errors"><ul>';
                          
                          for(i = 0; i < msg[2].length; i=i+1)
                          {
                              
                              <?php
                              
                                  if($message_type == 0)
                                  {
                                       ?>
                                       
                                          output += '<li>'+msg[2][i]['msg']+'</li>';
                                       
                                       <?php
                                  
                                  }
                                  else if($message_type == 1)
                                  {
                                      ?>
                                      $('#<?=$this->ajax_form_id;?> *[name='+msg[2][i]['form_element']+']').parent().find('.tumble-software-error-placeholder').html('<span class = "tumble-software-error-tooltip">'+msg[2][i]['msg']+'</span>').show();
                                      $('#<?=$this->ajax_form_id;?> *[name='+msg[2][i]['form_element']+']').parent().find('.tumble-software-error-tooltip').css('top',($('#<?=$this->ajax_form_id;?> *[name='+msg[2][i]['form_element']+']').position().top - $('#<?=$this->ajax_form_id;?> *[name='+msg[2][i]['form_element']+']').parent().find('.tumble-software-error-tooltip').outerHeight(true)) + 'px' );
                                      <?php
                                  }
                                  else
                                  {
                                    ?>
                                       
                                      output += '<li>'+msg[2][i]['msg']+'</li>';

                                      $('#<?=$this->ajax_form_id;?> *[name='+msg[2][i]['form_element']+']').parent().find('.tumble-software-error-placeholder').html('<span class = "tumble-software-error-tooltip">'+msg[2][i]['msg']+'</span>').show();
                                      $('#<?=$this->ajax_form_id;?> *[name='+msg[2][i]['form_element']+']').parent().find('.tumble-software-error-tooltip').css('top',($('#<?=$this->ajax_form_id;?> *[name='+msg[2][i]['form_element']+']').position().top - $('#<?=$this->ajax_form_id;?> *[name='+msg[2][i]['form_element']+']').parent().find('.tumble-software-error-tooltip').outerHeight(true)) + 'px' );
                                      <?php
                                    
                                    
                                  }   
                                  ?>
                          
                          }
                          
                          output += '</ul></div>';
                          <?php
                          if($message_type == 0 || $message_type > 1)
                          {
                               ?>
                               
                                $('#<?=$this->ajax_form_id;?>').find('.tumble-software-messages').html(output);  
                               
                               <?php
                          
                          }
                          ?>
                      }
                  
                  });
         });
         
         
         
         
         <?php 
         return ob_get_clean( );
     
     }

  }
?>