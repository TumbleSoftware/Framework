<?php
   
    class dynamic_menu extends tree
    {
      
      public $tree_menu, $nav;
      
      function __construct($obj_value, $root_node_id = 'root', $tablename, $templatewrapper)
      {
          parent::__construct($obj_value, $root_node_id, $tablename);
          $this->define_class(get_class($this));
          $this->nav = new DOMDocument();
          $this->nav->loadHTMLFile($GLOBALS['site_framework_location'].$templatewrapper);
          $this->database_loadtable();
          
      }
      
      function draw_menu($link_template, $func_callback, $selected)
      {
          $loadHTML = new DOMDocument;
          $loadHTML->loadHTMLFile($GLOBALS['site_framework_location'].$link_template);
          $menu_nodes = parent::get_row('ROOT', true);
          $root_node = parent::get_node('ROOT');
          
          $str_html = '';
          
          $func_callback($root_node,$loadHTML, $this, $selected);
          $elements = $loadHTML->getElementsByTagName('body')->item(0);
          $str_html .= $this->innerHTML($elements);
          
          foreach($menu_nodes as $key=>$obj_data)
          {
            $loadHTML = new DOMDocument;
            $loadHTML->loadHTMLFile($GLOBALS['site_framework_location'].$link_template);
            $func_callback($obj_data,$loadHTML, $this, $selected);
            $elements = $loadHTML->getElementsByTagName('body')->item(0);
            $str_html .= $this->innerHTML($elements); 
          
          }
          
          
          
          $nodes = $this->nav->getElementsByTagName('*');
          
          foreach($nodes as $node)
          {
            $str_rep = $node->getAttribute('data-replace');
          
            if($str_rep == 'menu-content')
            {
                  $fragment = $this->nav->createDocumentFragment();
                  $fragment->appendXML($str_html);         
                  $node->appendChild($this->nav->importNode($fragment, true));
            }
            
          }  
          

              
            
          
          

          

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
   
   
   
    class Menu extends common_objects
    {
        protected $document;
        public $nav, $nav_element;
        
        
        function __construct($template = '')
        {
          parent::__construct();
          $this->define_class(get_class($this));
          $this->menu_id = $menu_id;
          $this->nav = new DOMDocument();
          $this->nav->loadHTMLFile($GLOBALS['site_framework_location'].$template);

          
        }
        
        function selected($selected_element_id, $selected_class, $html_id_field = '', $search_through = 'a', $remove_id_attribute = true)
        {
          $items = $this->nav->getElementsByTagName($search_through);
          foreach($items as $item) { 
                     $item_menu_id = $item->getAttribute($html_id_field);
                     
                     if(strlen( $item_menu_id))
                     { 
                      if($item_menu_id == $selected_element_id)
                      {
                        $item->setAttribute('class',$item->getAttribute('class'). ' ' . $selected_class);
                      
                      }
                      if($remove_id_attribute == true)
                      {
                        $item->removeAttribute($html_id_field);
                      }
                    }
          }
          //$this->nav->saveHTML();

        }
        
        function breadcrumbs($selected_element_id, $selected_class, $html_id_field = '', $search_through = 'a', $remove_id_attribute = true)
        {
          $found = false;
          $items = $this->nav->getElementsByTagName($search_through);
          $arr_remove_link = array();
          foreach($items as $item) { 
                     $item_menu_id = $item->getAttribute($html_id_field);

                      if($found == true)
                      {
                          $arr_remove_link[] = $item;
                          
                      }
                      
                      
                       if($item_menu_id == $selected_element_id)
                      {
                        
                        $item->setAttribute('class',$item->getAttribute('class'). ' ' . $selected_class);
                        $found = true;
                      
                      }
                      


                      if($remove_id_attribute == true)
                      {
                        $item->removeAttribute($html_id_field);
                      }
                    
          }
          
          foreach($arr_remove_link as $key=>$item)
          {
              $this->DOMRemove($item);
          }
          
          $this->nav->saveHTML();
        
        }
        
        function DOMRemove(DOMNode $from) {
            $sibling = $from->firstChild;
            do {
                $next = $sibling->nextSibling;
                $from->parentNode->insertBefore($sibling, $from);
            } while ($sibling = $next);
            $from->parentNode->removeChild($from);    
        }
        
        
       
        function parse_html($element = 'body')
        {
          $mock = new DOMDocument;
          $body = $this->nav->getElementsByTagName($element)->item(0);
          foreach ($body->childNodes as $child){
              $mock->appendChild($mock->importNode($child, true));
          }
          return $mock->saveHTML();
        }
        
        
        
    }
        

?>