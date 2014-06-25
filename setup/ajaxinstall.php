<?php
    require('../framework.php');
    $xml=simplexml_load_file($GLOBALS['site_framework_location'] ."./installation/install.xml");
    $param = new param();
    $filename = $param->get_param('file','',true);
    include('./inc_cms.php');
  
    //WHEN THE TREE CLASS LOADS DATA FROM A TABLE IT WILL USE THE INFORMATION PASSED IN THE DESCRIBE_VAR FUNCTION TO ASSIGN DATA
    $obj_value->cms_section_name = 'Home'; //tHE TABLE CONTAINS A FIELD CALLED 'title'
    $obj_value->cms_section_description = 'Welcome to the CMS, please select an option.'; //tHE TABLE CONTAINS A FIELD CALLED 'description'
    $obj_value->cms_section_reserved_name = 'HOME';
    $obj_value->cms_section_image = 'Welcome to the CMS, please select an option.';
    $obj_value->cms_section_file = './home.php';
    $tree = new tree($obj_value,'home','cms'); //CREATE A TREE CLASS WITH A ROOT NODE, also takes a $tablename param which stores the $tablename of the tree list
    $tree->database_loadtable();
    
    foreach($xml->children() as $child) {
    
        if($child == $filename)
        {
            $zip = new ZipArchive;
            $res = $zip->open($GLOBALS['site_framework_location'] .'./installation/'.$filename);
            if ($res === true) {
                
                if (($index = $zip->locateName('settings/load.xml')) !== false) {
                  $data = $zip->getFromIndex($index);
                  
                  $xml_parse = new xml_parse();
                  $xml_parse->parse_string($data);
                  $obj_value->cms_section_name = $xml_parse->data['name'][0]; //tHE TABLE CONTAINS A FIELD CALLED 'title'
                  $obj_value->cms_section_description = $xml_parse->data['description'][0]; //tHE TABLE CONTAINS A FIELD CALLED 'description'
                  $obj_value->cms_section_reserved_name = $xml_parse->data['reservedname'][0];
                  $obj_value->cms_section_image = $xml_parse->data['icon'][0];
                  $obj_value->cms_section_file = 'index.php';
                  $obj_value->cms_section_folder = $xml_parse->data['folder'][0];
                  $obj_value->cms_section_highlight = $xml_parse->data['highlight'][0];
                  $tree->add_node($xml_parse->data['addto'][0],$obj_value, $xml_parse->data['reservedname'][0]);
                  
                  foreach($xml_parse->data['files'][0]['file'] as $key=>$file)
                  {
                  
                  $obj_value->cms_section_name = $file['name'][0]; //tHE TABLE CONTAINS A FIELD CALLED 'title'
                  $obj_value->cms_section_description = $file['description'][0]; //tHE TABLE CONTAINS A FIELD CALLED 'description'
                  $obj_value->cms_section_reserved_name = $file['reservedname'][0];
                  $obj_value->cms_section_image = $file['icon'][0];
                  $obj_value->cms_section_file = $file['filename'][0];
                  $obj_value->cms_section_folder = $xml_parse->data['folder'][0];
                  $obj_value->cms_section_highlight = $file['highlight'][0];
                  
                  $tree->add_node($file['addto'][0],$obj_value, $file['reservedname'][0]);  
                  }
                  
                  
                  $zip->extractTo($GLOBALS['site_framework_location'].'cms/');
                  $zip->close();
                  $tree->database_save();
                  echo json_encode(array('0'=>$filename . ' has been loaded.'));

                }

            }
        
        }
    }
    
?>