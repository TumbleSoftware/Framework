<?php
 //ini_set('display_errors', FALSE);
  require('../../framework.php');
  include('../inc_common.php');
  
  $call_func = function($obj_data, $dom)
  {
      $nodes = $dom->getElementsByTagName('*');                   
      foreach($nodes as $node)
      {
          $str_rep = $node->getAttribute('data-replace');
          
          if(strlen($str_rep))
          {
            $str_replace_with = '';
            switch($str_rep)
            {
              case 'cms-section-image':
                  $str_replace_with = '<img src="./cms/'.$obj_data->cms_section_folder.'/'.$obj_data->cms_section_image.'" />';
              break;
              case 'cms-section-name':
                  $str_replace_with = $obj_data->cms_section_name;
              break;
              case 'cms-section-description':
                  $str_replace_with = ''.$obj_data->cms_section_description.'';
              break;
              case 'sub-links':
                  //$str_replace_with = $func_sub_menu2($obj_data,'./cms/templates/home/sub_menu.html');
              break;
            }
            
            if(strlen($str_replace_with))
            {
                $fragment = $dom->createDocumentFragment();
                $fragment->appendXML( $str_replace_with);         
                $node->appendChild($dom->importNode($fragment, true));
            }
          }
      
      }
      return $dom;
  
  };
  
  
  $template->load_single_template($selected, './cms/templates/common/index.html','right-column',$call_func); 
   $arr_obj = $menu->get_row('SETTINGS', true);

  $template->load_repeating_template($arr_obj, './cms/templates/common/sub_menu_right.html','right-column',$call_func);
  
  
  $template->display_html('CMS - Welcome');
?>