<?php
 //ini_set('display_errors', FALSE);
  require('../framework.php');
  
  $template = new Page('./cms/templates/index.html','TumbleSoftware - ');
  $template->load_css('./cms/css/setup/');
   $template->load_css('./cms/css/admin/');
  $template->load_css('./cms/css/forms/');
  $template->load_css('./cms/css/tooltips/');
  $template->add_jquery();
  

  tooltip_base::$data_tip = 'left';
  tooltip_base::$data_fade_out = "3000";
  tooltip_base::$data_fade_in = '3000';
  tooltip_base::$data_tooltip_event = 'click';
  tooltip_base::$class = 'tumble-tooltip';
  $template->add_tooltips('./cms/javascript/tooltips/tumble_tooltips.js',tooltip_base::$class);
  
  

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
  $login = new stdClass();
  $login->cms_section_name = 'Login';
  $login->cms_section_folder = '';
  $login->cms_section_image = './images/icons/login.png';  
  $template->load_single_template($login, './cms/templates/common/title.html','main',$call_func);
  
  include($GLOBALS['site_framework_location'].'/cms/inc_login.php');
  $template->load_form($form,'./cms/templates/login/login.html');
  
  //$template->load_menu($breadcrumbs->nav);
  $template->display_html('CMS');
?>