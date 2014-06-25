<?php
    $obj_value = new data_store;  //Create a data_store
  $obj_value->describe_var('cms_section_name',MYSQL_DATA_TYPE_VARCHAR); //Describe a filed in the mySql table called title
  $obj_value->describe_var('cms_section_description',MYSQL_DATA_TYPE_TEXT); //Describe a filed in the mySql table called description
  $obj_value->describe_var('cms_section_reserved_name',MYSQL_DATA_TYPE_VARCHAR); //Describe a filed in the mySql table called description
  $obj_value->describe_var('cms_section_image',MYSQL_DATA_TYPE_VARCHAR);
  $obj_value->describe_var('cms_section_file',MYSQL_DATA_TYPE_VARCHAR);
  $obj_value->describe_var('cms_section_folder',MYSQL_DATA_TYPE_VARCHAR);
  $obj_value->describe_var('cms_section_highlight',MYSQL_DATA_TYPE_VARCHAR);
?>