<?php
  const FORM_AJAX = 0;
  const FORM_NORMAL = 1;
  const FORM_IFRAME = 2;
  
  
  const FORM_INLINE = 0;
  const FORM_COLUMNS = 1;
  
  const FORM_TOOLTIPS_ERRORS = 0;
  const FORM_MSG_ERRORS = 1;
  const FORM_BOTH_ERRORS = 2;
  
  
  class input
  {
      public $name, $type, $value, $id, $classname, $type_of;
  }
  
  class add_many extends input
  {
      public $fields = array(), $name, $value, $title, $type_of;
  
      function __construct($name, $value, $title, $modal_button_title)
      {
        $this->name = $name;
        $this->type = 'add_many';
        $this->value = $value;
        $this->title = $title;
        $this->type_of = 'add-many';
        $this->modal_button_title = $modal_button_title;
      }
      
      function draw_input()
      {
           
           $id = uniqid('add-many');
          if($this->value == '')
           {
             $this->value = '[]';
           }
           ob_start();
           ?>              
                    <div id = "<?=$id;?>"></div>
                    <script type = "text/javascript">
                    $('#<?=$id;?>').TumbleAddMany({
                                      'name':'<?=$this->name;?>',
                                      'values':<?=htmlspecialchars_decode($this->value,ENT_QUOTES);?>,
                                      'template':'<?=$GLOBALS['current_framework_folder'];?>./javascript/add-many/templates/default.html',
                                      'fields':[<?php
                                                foreach($this->fields as $key=>$value)
                                                {?>
                                                {'name':'<?=$value->name;?>',
                                                'title': '<?=$value->label;?>',
                                                'type': '<?=$value->type_of;?>',
                                                'defaultValue': '',
                                                'possibleValues':{}                                     
                                                },                                              
                                                <?php 
                                                }
                                                ?>],
                                      'id': '<?=$id;?>',
                                      'title': '<?=$this->title;?>',
                                      });
                    </script>          
              <?php 
              echo ob_get_clean();
              return ob_get_clean();


      }
  
  
  }
  
  
  class text_input extends input
  {
      public $placeholder, $tooltip;

      function __construct($name, $id, $value, $placeholder, $classname, $label = '',  $tooltip = null, $validate = null)
      {
        $this->name = $name;
        $this->type = 'text';
        $this->value = $value;
        $this->id = $id;
        $this->classname = $classname;
        $this->placeholder = $placeholder;
        $this->label = $label;
        $this->tooltip = $tooltip;
        $this->validate = $validate;
        $this->type_of = 'text';
      }


      function draw_input()
      {
          $str_data_attributes = '';
          $str_tooltip_class = '';
          if(isset($this->tooltip))
          {
              $str_data_attributes = $this->tooltip->data_tooltip();
              $str_tooltip_class = $this->tooltip->define_tooltip_class();
          }
          
          
          $output = '<input type = "text" name = "'.$this->name.'" placeholder = "'.$this->placeholder.'" value = "'.$this->value.'" class = "'.$this->classname.''. $str_tooltip_class .'" id = "'.$this->id.'"'.$str_data_attributes.'/>';
          return $output;
      }
  }
  
  class checkbox_input extends input
  {
      public $tooltip;

      function __construct($name, $id, $value, $placeholder, $classname, $label = '',  $tooltip = null, $validate = null)
      {
        $this->name = $name;
        $this->type = 'text';
        $this->value = $value;
        $this->id = $id;
        $this->classname = $classname;
        $this->label = $label;
        $this->tooltip = $tooltip;
        $this->validate = $validate;
        $this->type_of = 'checkbox';
      }


      function draw_input()
      {
          $str_data_attributes = '';
          $str_tooltip_class = '';
          if(isset($this->tooltip))
          {
              $str_data_attributes = $this->tooltip->data_tooltip();
              $str_tooltip_class = $this->tooltip->define_tooltip_class();
          }
          
          $str_checked = '';
          if($this->value == true)
          {
             $str_checked = ' checked = "checked" ';
          }
          $output = '<input type = "checkbox" name = "'.$this->name.'" placeholder = "'.$this->placeholder.'" value = "1" class = "'.$this->classname.''. $str_tooltip_class .'" id = "'.$this->id.'"'.$str_data_attributes.$str_checked .'/>';
          return $output;
      } 
  }
  
  class password_input extends input
  {
      public $placeholder, $tooltip;
      
      function __construct($name,$id,$value, $placeholder, $class, $label = '', $tooltip, $validate)
      {
        $this->name = $name;
        $this->type = 'password';
        $this->value = $value;
        $this->id = $id;
        $this->classname = $classname;
        $this->placeholder = $placeholder;
        $this->label = $label;
        $this->tooltip = $tooltip;
        $this->validate = $validate;
        $this->type_of = 'password';
      }

      function draw_input()
      {
          $str_data_attributes = '';
          $str_tooltip_class = '';
          if(isset($this->tooltip))
          {
              $str_data_attributes = $this->tooltip->data_tooltip();
              $str_tooltip_class = $this->tooltip->define_tooltip_class();
          }
          
          $output = '<input type = "password" name = "'.$this->name.'" placeholder = "'.$this->placeholder.'" value = "'.$this->value.'" class = "'.$this->classname.' '. $str_tooltip_class . '" id = "'.$this->id.'" '.$str_data_attributes.' />';
          return $output;
      }
  }
  
  class submit_button
  {
    public $type, $id, $text;
    
    function __construct($type, $id, $text)
    {
        $this->id = $id;
        $this->text = $text;
        $this->type = $type;

      
    }
  
  
    function draw_input()
    {
          $output = '<button type = "'.$this->type.'" id = "'.$this->id.'" class = "tumble-software-form-span1">'.$this->text.'</button>';
          return $output;
    }
  
  
  }
  
  class segment
  {
     public $arr_form_elements, $form_display_type, $id, $submit_button, $form_id;
  
      function __construct($id, $form_display)
      {
        $this->id = $id;
        $this->form_display_type = $form_display;
        $this->submit_button = array();      
      }
      
      function add_text_input($name,$id,$value, $placeholder, $class, $label = '', $tooltip, $validate)
      {
         $this->arr_form_elements[] = new text_input($name,$id,$value, $placeholder, $class, $label, $tooltip, $validate);
          
      }
      
      function add_password_input($name,$id,$value, $placeholder, $class, $label = '', $tooltip, $validate)
      {
         $this->arr_form_elements[] = new password_input($name,$id,$value, $placeholder, $class, $label, $tooltip, $validate);
           
      }
      
      function add_checkbox_input($name,$id,$value, $placeholder, $class, $label = '', $tooltip, $validate)
      {
        $this->arr_form_elements[] = new checkbox_input($name,$id,$value, $placeholder, $class, $label, $tooltip, $validate);
      }
      
      function add_add_many($obj_add_many)
      {
         $this->arr_form_elements[] = $obj_add_many;
      }
      
      function add_submit_button($type, $id, $text)
      {
         $this->submit_button[] = new submit_button($type, $id, $text);
      }
      
      function output_segment()
      {

          $str_add_class = '';
          if($this->form_display_type == FORM_INLINE)
          {
            $int_count = (count($this->arr_form_elements));
            
            
            $str_add_class = 'tumble-software-form-span'.$int_count;
          } 
          
          $str_default_class = 'column';
          $str_inlie_extra_markup = '';
          if($this->form_display_type == FORM_INLINE)
          {
            $str_default_class = 'inline';
          }
          
          
          $output = '<div class = "tumble-software-form-segment tumble-software-form-'.$str_default_class.'">';
          if(isset($this->submit_button) && $str_default_class == 'inline')
          {
            $output .= '<span class = "tumble-software-inline-submit-button">'.$this->submit_button->draw_input() . '</span><div class = "tumble-software-inline-fields">';
          
          }

          
          foreach($this->arr_form_elements as $index=>$value)
          {
              if($this->form_display_type == FORM_INLINE)
              {
                  /*Add wrappers to the fom elements with a special CSS form class*/
                  $output .= '<div class = "tumble-software-form-inline-input tumble-software-position-relative '.$str_add_class.'"><div class = "tumble-software-error-placeholder"></div>' . $value->draw_input() . '</div>' ;
              }
              else
              {
                
                $str_class = ' tumble-software-input-'.$value->type_of;
                if($value->type_of == 'add-many')
                {
                   $output .= '<div class = "tumble-software-form-column-input '.$str_class.'">' . $value->draw_input() . '</div>' ; 
                }else
                {
                  $output .= '<div class = "tumble-software-form-column-input '.$str_class.'"><label>'.$value->label.'</label>' . $value->draw_input() . '</div>' ;
                }
              }
          }
          
          if(isset($this->submit_button) && $str_default_class == 'inline')
          {
            $output .= '</div>';
          }
          
          if(isset($this->submit_button) && $str_default_class == 'column')
          {
            
            foreach($this->submit_button as $key3=>$submit_button)
            {
            $output .= '<div class = "tumble-software-form-column-input tumble-software-input-button tumble-software-form-span'.count($this->submit_button).'">'.$submit_button->draw_input() . '</div>';
            }
          }
          
          
          
          
          $output .= '</div>';
          
          return $output;
      
      }
      
  
  
  }
  
  
  
  class form extends common_objects
  {
     public $form_name, $form_type, $form_action, $form_id, $form_display_type, $arr_segments, $template, $ajax, $output_messages = 0, $validated = true, $messages;
     
     
     function __construct($form_name, $form_type, $form_action, $form_id, $form_display_type, $output_messages)
     {
                  parent::__construct();
          $this->define_class(get_class($this));
        $this->form_name = $form_name;
        $this->form_type = $form_type;
        $this->form_action = $form_action;
        $this->form_id = $form_id;
        $this->form_display_type = $form_display_type;
        $this->output_messages = $output_messages;
        $this->messages = new messages();
        
        
        $this->arr_ajax = array();

        
     }
     
     function segment($segment_name, $form_display_type)
     {
        $segment = new segment($segment_name, $form_display_type );
        $segment->form_id = $this->form_id;
        $this->arr_segments[] = $segment;
        return $segment;
     }
     
     function ajax($ajax)
     {
                  
         $this->arr_ajax[] = $ajax;
     }
     
     function process_form($error_msg_type)
     {
        $param = new param();

              $validated = true;
              $arr_data = array();
              foreach($this->arr_segments as $index => $value)
              {
                  foreach($value->arr_form_elements as $key => $input)
                  {
                     $value_param = $param->get_param($input->name,'',true);
                     if($input->type_of != 'password')
                     {
                        $input->value = $value_param;
                    }
                     
                     $arr_data[$input->name] = $value_param;
                     
                     
                     if(isset($input->validate))
                     {
                        $bool_validated = $input->validate->validate_var($value_param);
                        
                        
                        if(!$bool_validated)
                        {
                           $validated = false;
                           switch($error_msg_type)
                           {
                              case FORM_TOOLTIPS_ERRORS:
                              
                                    
                                    
                                      $tooltip = new tooltip();
                                      $tooltip->data_tip = "left";
                                      $tooltip->data_fade_out = '5000';
                                      $tooltip->data_fade_in = '2000';
                                      $tooltip->data_tooltip_event = 'load';
                                      $tooltip->class = 'tumble-tooltip';
                                    $tooltip->data_tooltip_content = $input->validate->msg;
                                    $tooltip->data_classes = "tooltip-error-class";
                                    $input->tooltip = $tooltip;
                                    $input->classname = 'tumble-tooltip-error-input ';
                              
                              break;
                                
                              case FORM_MSG_ERRORS:
                              
                              break;
                              
                              case FORM_BOTH_ERRORS:
                              
                              break;
                           
                           } 
                        }
                        
                     }
                  }
              }
              $this->validated = $validated;
              return $arr_data;  
     
     }
     
     function is_form_submitted()
     {
        $param = new param();
        if($param->get_integer($this->form_id.'-submit',0))
        {
            return true;
        }
        
        return false;
     }
     
     function compose_form($template)
     {
        $loadHTML = new DOMDocument;
        $loadHTML->loadHTMLFile($template);
        
        /*Now we need to add the form segments*/
        
        $temp_nodes = $loadHTML->getElementsByTagName('*');
        foreach($this->arr_segments as $index => $value)
        { 
              foreach($temp_nodes as $child_node)
              {
                $str_attr = $child_node->getAttribute('data-segment');                 
                
                if($str_attr == $value->id)
                {          
                    $temp_fragment = $loadHTML->createDocumentFragment();
                    $str_html = $value->output_segment();
                    $temp_fragment->appendXML($str_html);
                   
                   $child_node->appendChild($loadHTML->importNode($temp_fragment, true));
                                                      
                }                
              }   
        }
        
        

        $this->add_to_node = $loadHTML->getElementById('tumble-software-add-to-node');
        $innerHTML = $this->innerHTML($this->add_to_node);
        $error_str = '';
        if($this->is_form_submitted() && $this->validated == false)
        {
           $error_str = $this->messages->error('Your form has an error.');
 
        }
        //var_dump($innerHTML);
        $outerHTML = '<form name = "'.$this->form_name.'" enctype="multipart/form-data" method = "post" action = "'.$this->form_action.'" id = "'.$this->form_id.'" class = "tumble-software-form"><div class = "tumble-software-messages">'.$error_str.'</div><input type = "hidden" name = "'.$this->form_id.'-submit" value = "1" />' . $innerHTML . '</form>';
        foreach($this->arr_ajax as $key=>$ajax_obj)
        {
            $outerHTML .= $ajax_obj->ajax_process();
        
        }
        
        
        
        
        return $outerHTML;
     
     }
     
      /*Function Source: http://kuttler.eu/post/php-innerhtml/*/ 
      function innerHTML($nodes)
      {
          $output = '';
          	$elements = $nodes->childNodes;
          	foreach( $elements as $element ) { 
          		if ( $element->nodeType == XML_TEXT_NODE ) {
          			$text = $element->nodeValue;
          			// IIRC the next line was for working around a
          			// WordPress bug
          			//$text = str_replace( '<', '&lt;', $text );
          			$output .= $text;
          		}	 
          		// FIXME we should return comments as well
          		elseif ( $element->nodeType == XML_COMMENT_NODE ) {
          			$output .= '';
          		}	 
          		else {
          			$output  .= '<';
          			$output  .= $element->nodeName;
          			if ( $element->hasAttributes() ) { 
          				$attributes = $element->attributes;
          				foreach ( $attributes as $attribute )
          					$output  .= " {$attribute->nodeName}='{$attribute->nodeValue}'" ;
          			}	 
          			$output  .= '>';
          			$output  .= $this->innerHTML( $element );
          			$output  .= "</{$element->nodeName}>";
          		}	 
             }	 
            
            return $output;

      }

  }
?>