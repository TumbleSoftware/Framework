<?php
  $template = new Page('./cms/templates/index.html','TumbleSoftware - ');
  $template->load_css('./cms/css/setup/');
  $template->load_css('./cms/css/forms/');
  $template->load_css('./cms/css/admin/');
  $template->load_css('./cms/css/tooltips/');
  $template->add_jquery();
  $template->load_javascript('./cms/javascript/accordian/');
  $template->load_javascript('./cms/javascript/common/');
  tooltip_base::$data_tip = 'left';
  tooltip_base::$data_fade_out = "3000";
  tooltip_base::$data_fade_in = '3000';
  tooltip_base::$data_tooltip_event = 'click';
  tooltip_base::$class = 'tumble-tooltip';
  $template->add_tooltips('./cms/javascript/tooltips/tumble_tooltips.js',tooltip_base::$class);
  
  $template->load_html_file('./cms/templates/home/home.html');
  $obj_value = new data_store;  //Create a data_store
  $obj_value->describe_var('cms_section_name',MYSQL_DATA_TYPE_VARCHAR); //Describe a filed in the mySql table called title
  $obj_value->describe_var('cms_section_description',MYSQL_DATA_TYPE_TEXT); //Describe a filed in the mySql table called description
  $obj_value->describe_var('cms_section_reserved_name',MYSQL_DATA_TYPE_VARCHAR); //Describe a filed in the mySql table called description
  $obj_value->describe_var('cms_section_image',MYSQL_DATA_TYPE_VARCHAR);
  $obj_value->describe_var('cms_section_file',MYSQL_DATA_TYPE_VARCHAR);
  $obj_value->describe_var('cms_section_folder',MYSQL_DATA_TYPE_VARCHAR);
  $obj_value->describe_var('cms_section_highlight',MYSQL_DATA_TYPE_VARCHAR);
  
  $func_draw_menu = function($obj_node,$dom, &$tree, $selected)
  {
          $func_sub_menu = function($obj_node_2,$template, &$tree)
          {
              
              
              $menu_nodes = $tree->get_row($obj_node_2->tree_node_id, true);  
              $str_html_sub_str = '';
              foreach($menu_nodes as $key=>$obj_data)
              {
                
                $loadHTML = new DOMDocument;
                $loadHTML->loadHTMLFile($GLOBALS['site_framework_location'].$template);
                $nodes3 = $loadHTML->getElementsByTagName('*');
                  foreach($nodes3 as $node4)
                  {
                    $str_attr2 = $node4->getAttribute('data-replace');
                    $str_html_sub = '';
                    switch($str_attr2)
                    {
                        case 'link-sub';
                            $node4->setAttribute('href','./cms/'.$obj_data->cms_section_folder.'/'.$obj_data->cms_section_file);
                        break;
                        case 'text-sub':
                            $str_html_sub = $obj_data->cms_section_name;     
                        break;
                    
                    }
                    
                     
                    if(strlen($str_html_sub))
                    {
                      $fragment = $loadHTML->createDocumentFragment();
                      $fragment->appendXML($str_html_sub);         
                      $node4->appendChild($loadHTML->importNode($fragment, true)); 
                    }  
                  
                  }
                  
                  $elements = $loadHTML->getElementsByTagName('body')->item(0);
                  $str_html_sub_str .= $tree->innerHTML($elements);
                  
              
              }
              
              return $str_html_sub_str;
          
          };
          
          
          $nodes = $dom->getElementsByTagName('*');
          
          $str_class = " tumble-software-collapsed";
          if($obj_node->tree_node_id == $selected->tree_node_id || $obj_node->tree_node_id == $selected->tree_node_parent)
          {
             $str_class = '';
          }
          
          foreach($nodes as $node)
          {
            $str_attr = $node->getAttribute('data-replace');
            $str_html = '';
            switch($str_attr)
            {
                case 'link';
                    $node->setAttribute('href','./cms/'.$obj_node->cms_section_folder.'/'.$obj_node->cms_section_file);
                break;
                case 'text':
                    $str_html = $obj_node->cms_section_name;
                break;
                case 'sub-menu':
                    $str_html = $func_sub_menu($obj_node,'./cms/templates/menu/sub_menu.html',$tree);
                    $node->setAttribute('class',$node->getAttribute('class') . $str_class);
                break;
            
            }
            
             
            if(strlen($str_html))
            {
              $fragment = $dom->createDocumentFragment();
              $fragment->appendXML($str_html);         
              $node->appendChild($dom->importNode($fragment, true)); 
            }  
          
          }     
     
  };
  
  
  
  
  $menu = new dynamic_menu($obj_value,'ROOT','cms','./cms/templates/menu/wrapper.html');
  $menu->database_loadtable();
  
  /*We need to get the filename and folder*/
  $path_parts = pathinfo($_SERVER['PHP_SELF']);
  $current_folder = basename(getcwd());
  
  if($current_folder == 'cms')
  {
    $current_folder = '';
  }
  
  $current_file = $path_parts['filename'] . '.' . $path_parts['extension'];
  $arr_params = array('cms_section_folder'=>$current_folder,'cms_section_file'=>$current_file);  
  $arr_return = $menu->search($arr_params);
  
  $selected = $arr_return[0];
  
  
  $menu->draw_menu('./cms/templates/menu/link.html',$func_draw_menu,$selected);
  $template->load_menu($menu->nav);
?>