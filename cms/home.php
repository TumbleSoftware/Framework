<?php
 //ini_set('display_errors', FALSE);
  require('../framework.php');
  include('./inc_common.php');
  
  $func_menu = function($obj_data, $dom)
  {
      $func_sub_menu2 = function($obj_node_2,$template)
          {
              
              
              $menu_nodes = $obj_node_2->children->return_row_data();  
              
              
              
              $str_html_sub_str = '';
              foreach($menu_nodes as $key=>$obj_data2)
              {
                
                $loadHTML2 = new DOMDocument;
                $loadHTML2->loadHTMLFile($GLOBALS['site_framework_location'].$template);
                
                
                $nodes = $loadHTML2->getElementsByTagName('*');
                  foreach($nodes as $node)
                  {
                    $str_attr2 = $node->getAttribute('data-replace');
                     $node->removeAttribute('data-replace');
                     $str_html_sub = '';
                        if(strlen($str_attr2))
                        {
                        
                              
                              switch($str_attr2)
                              {
                                  case 'link-sub';
                                      
                                      
                                      $node->setAttribute('href','./cms/'.$obj_data2->cms_section_folder.'/'.$obj_data2->cms_section_file);
                                  break;
                                  case 'text-sub':
                                      
                                      if(file_exists($GLOBALS['site_framework_location'].'./cms/'.$obj_data2->cms_section_folder.'/'.$obj_data2->cms_section_image))
                                      {
                                        $str_html_sub.= '<img src = "./cms/'.$obj_data2->cms_section_folder.'/'.$obj_data2->cms_section_image.'" />';
                                      }
                                      
                                      $str_html_sub .= $obj_data2->cms_section_name;     
                                  break;
                              
                              }
                              
                           if(strlen($str_html_sub))
                            {    
                                
                                $fragment = $loadHTML2->createDocumentFragment();
                                $fragment->appendXML($str_html_sub);         
                                $node->appendChild($loadHTML2->importNode($fragment, true));
                             } 
                        }  
                  
                  }
                  
                  //var_dump($elements->firstChild->nodeValue);
                  
                  //$str_html_sub_str .= innerHTML($loadHTML);
                  $elements = $loadHTML2->getElementsByTagName('body')->item(0);
                  $str_html_sub_str .= innerHTML($elements);
              
              }
              
              return $str_html_sub_str;
          
          };
      
      
      $nodes = $dom->getElementsByTagName('*');                   
      foreach($nodes as $node)
      {
          $str_rep = $node->getAttribute('data-replace');
          
          if(strlen($str_rep))
          {
            switch($str_rep)
            {
              case 'cms-section-image':
                  $str_replace_with = '<img src="./cms/'.$obj_data->obj_value->cms_section_folder.'/'.$obj_data->obj_value->cms_section_image.'" />';
              break;
              case 'cms-section-name':
                  $str_replace_with = '<a href = "./cms/'.$obj_data->obj_value->cms_section_folder.'/'.$obj_data->obj_value->cms_section_file.'">'.$obj_data->obj_value->cms_section_name.'</a>';
              break;
              case 'cms-section-description':
                  $str_replace_with = ''.$obj_data->obj_value->cms_section_description.'';
              break;
              case 'sub-links':
                  $str_replace_with = $func_sub_menu2($obj_data,'./cms/templates/home/sub_menu.html');
              break;
            }
            $fragment = $dom->createDocumentFragment();
            $fragment->appendXML( $str_replace_with);         
            $node->appendChild($dom->importNode($fragment, true));
          }
      
      }
      
      return $dom;
      
  
  
  };
  
  $arr_obj = $menu->get_row('ROOT', false);
  
  
  $template->load_repeating_template($arr_obj, './cms/templates/home/front_menu.html','right-column',$func_menu);
  
  

  $template->display_html('CMS - Welcome');
?>