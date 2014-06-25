<?php
  class Page extends common_objects
  {
      protected $dom, $title_stub, $pageroot;
      public static $database;
      
      function __construct($template = '', $title_stub = '')
      {
                   parent::__construct();
          $this->define_class(get_class($this));
         $this->dom = new DOMDocument();
         $this->dom->loadHTMLFile($GLOBALS['site_framework_location'].$template);
         $this->title_stub = $title_stub;
        if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
            $this->pageroot = 'https://'.$_SERVER['HTTP_HOST'].$GLOBALS['current_framework_folder'];
        }
        else
        {
            $this->pageroot = 'http://'.$_SERVER['HTTP_HOST'].$GLOBALS['current_framework_folder'];
        } 
   
      }
      
      function load_css($folder='')
      {
          /*code taken from php.net*/
          if ($handle = opendir($GLOBALS['site_framework_location'].$folder)) {
                                
              /* This is the correct way to loop over the directory. */
              while (false !== ($entry = readdir($handle))) {
                  
                  if(!is_dir($entry))
                  {
                    $this->add_stylesheet($this->pageroot.$folder.$entry,'');
                       
                  }
              }
                         
              closedir($handle);
          }
      
      
      }
      
      function load_javascript($folder = '')
      {

          /*code taken from php.net*/
          if ($handle = opendir($GLOBALS['site_framework_location'].$folder)) {
                                
              /* This is the correct way to loop over the directory. */
              while (false !== ($entry = readdir($handle))) {
                  
                  if(!is_dir($entry))
                  {$this->add_javascript($this->pageroot.$folder.$entry);
                       
                  }
              }
                         
              closedir($handle);
          }
      }
      
      function add_jquery($url = 'https://code.jquery.com/jquery-latest.min.js')
      {
         $this->add_javascript($url);
      
      }
      
      function add_many($url = './javascript/add-many/add_many.js',$css = './javascript/add-many/css/style.css')
      {
        $this->add_javascript('./javascript/jquery_ui/jquery-ui-1.10.4.custom.min.js');
        $this->add_javascript($url);
        $this->add_stylesheet($css);
       $this->add_stylesheet('./css/jquery_ui/jquery-ui-1.10.4.custom.css'); 
      }
      
      function add_tooltips($url = './javascript/tooltips/',$class)
      {
         $this->add_javascript($url);
          ob_start();
          ?>
            <script type = "text/javascript">
            $(document).ready(function(){
                $('.<?=$class;?>').TumbleTooltips({'tooltip_format':function(message){return message;}});
            });
            </script> 
          <?php
          $this->load_html(ob_get_clean( ),'body');
         
      }
      
          public function add_stylesheet ( $url, $media='all' )
         {
             $element = $this->dom->createElement( 'link' );
             $element->setAttribute( 'rel', 'stylesheet' );
             $element->setAttribute( 'href', $url );
             $element->setAttribute( 'media', $media );
             $this->dom->getElementsByTagName('head')->item(0)->appendChild($element);
         }
         
            public function add_javascript ( $url )
         {
             $element = $this->dom->createElement( 'script' );
             $element->setAttribute( 'type', 'text/javascript' );
             $element->setAttribute( 'src', $url );
             $this->dom->getElementsByTagName('head')->item(0)->appendChild($element);
         }
      
          
      
      function display_html($title = '')
      {
         $element = $this->dom->getElementsByTagName('title');
         $element->item(0)->nodeValue = $this->title_stub . $title;
         
         $this->absolutee_urls($this->dom->getElementsByTagName('html'));
         
         echo $this->dom->saveHTML(); 
      }
      
            function absolutee_urls($elements)
            {
                if (!is_null($elements)) {
                 foreach ($elements as $element) {

                 if($element->nodeName != '#text' && $element->nodeName != '#comment' && $element->nodeName != '#cdata-section')
                 {
                      $src = $element->getAttribute('src');
                      $href = $element->getAttribute('href');
                      
                      if(strlen($src))
                      {
                        $pos = strpos($src, 'http://');
                        $secure = strpos($src, 'https://');
                        
                       
                        if($pos === false && $secure === false)
                        {          
                            $element->setAttribute('src',$this->pageroot.$src);
                        }
                        
                      }else if(strlen($href))
                      {
                        $pos = strpos($href, 'http://');
                        $anchorPos = strpos($href, '#');
                        $secure = strpos($href, 'https://');
                                        
                        if($pos === false && $anchorPos === false && $secure === false)
                        {          
                            $element->setAttribute('href',$this->pageroot.$href);
                        } 
                      
                      }
                      
                      
                 
                 }
                    
                                        
                  
                    if(is_object($element->childNodes))
                    {
                       
                        $this->absolutee_urls($element->childNodes);
                    
                    }
                      
                      
               
                 }
               }
            
            }     
      
      function load_repeating_template($arr_obj_data, $template, $append_to, $call_function)
      {
          $str_html = '';
          foreach($arr_obj_data as $key=>$obj_data)
          {
              $loadHTML = new DOMDocument;
              $loadHTML->loadHTMLFile($GLOBALS['site_framework_location'].$template);
              
              $loadHTML = $call_function($obj_data, $loadHTML);
              $loadHTML->saveHTML();
              $elements = $loadHTML->getElementsByTagName('body')->item(0);
              $str_html .= $this->innerHTML($elements);
          }
      
          $this->load_html($str_html, $append_to);

      }
      
      function load_single_template($obj_data, $template, $append_to, $call_function)
      {
          $str_html = '';

          $loadHTML = new DOMDocument;
          $loadHTML->loadHTMLFile($GLOBALS['site_framework_location'].$template);
          
          $loadHTML = $call_function($obj_data, $loadHTML);
          $loadHTML->saveHTML();
          $elements = $loadHTML->getElementsByTagName('body')->item(0);
          $str_html .= $this->innerHTML($elements);
        
          $this->load_html($str_html, $append_to);

      }
      
      
      function load_html_file($template = '',$add_where = '')
      {
          $loadHTML = new DOMDocument;
          $loadHTML->loadHTMLFile($GLOBALS['site_framework_location'].$template);
          $elements = $loadHTML->getElementById('tumble-software-add-to-node');
          
          $nodes = $this->dom->getElementsByTagName('*');
                    
          foreach($nodes as $node)
          {
            $str_attr = $node->getAttribute('data-element-id');
             
            if($str_attr == $elements->getAttribute('data-add-to-element'))
            {
               $innerHTML = $this->innerHTML($elements);
               $fragment = $this->dom->createDocumentFragment();
               $fragment->appendXML($innerHTML);
                            
               $node->appendChild($this->dom->importNode($fragment, true)); 
            
            }  
          
          }
          
          $this->dom->saveHTML();
          
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
      
        function parse_html($element = 'body')
        {
          $mock = new DOMDocument;
          $body = $this->nav->getElementsByTagName($element)->item(0);
          foreach ($body->childNodes as $child){
              $mock->appendChild($mock->importNode($child, true));
          }
          return $mock->saveHTML();
        }
      
      function load_html($str_html = '', $append_to)
      {
                                    
        $nodes = $this->dom->getElementsByTagName('*');
                    
          foreach($nodes as $node)
          {
            $str_attr = $node->getAttribute('data-element-id');

            if($str_attr == $append_to)
            {
              
              $fragment = $this->dom->createDocumentFragment();
              $fragment->appendXML($str_html);         
              $node->appendChild($this->dom->importNode($fragment, true)); 
            
            }  
          
          } 
          $this->dom->saveHTML();

      }
      
      function load_menu($menu)
      {
          $elements = $menu->getElementById('tumble-software-add-to-node');
          
          $nodes = $this->dom->getElementsByTagName('*');
                    
          foreach($nodes as $node)
          {
            $str_attr = $node->getAttribute('data-element-id');
             
            if($str_attr == $elements->getAttribute('data-add-to-element'))
            {
               $innerHTML = $this->innerHTML($elements);
               $fragment = $this->dom->createDocumentFragment();
               $fragment->appendXML($innerHTML);
                            
               $node->appendChild($this->dom->importNode($fragment, true)); 
            
            }  
          
          }
          
          $this->dom->saveHTML(); 
      }
      
      function load_form($form, $template)
      {

        $this->dom->saveHTML();
        $outerHTML = $form->compose_form($GLOBALS['site_framework_location'].$template);
        $elements = $form->add_to_node;
        
        $fragment = $this->dom->createDocumentFragment();
        $fragment->appendXML($outerHTML);

        $nodes = $this->dom->getElementsByTagName('*');
                    
        foreach($nodes as $node)
        {
          $str_attr = $node->getAttribute('data-element-id');
           
          if($str_attr == $elements->getAttribute('data-add-to-element'))
          {

                          
             $node->appendChild($this->dom->importNode($fragment, true)); 
          
          }  
        
        }
        
                 
      
      }
      

      
  
  
  
  }
?>