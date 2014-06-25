<?php
   /*Your data class, assign public variables representing your node data*/
   /*If you wish to create a table you need to add field type vars using the describe_var function*/
   /*Use the constants above to define the field type*/
  class data_store
  {
      /*The field 'arr_field_types' is REQUIRED*/
      /*All other public variables are your node data*/
      public $arr_field_types;


      /*Used to not only create tables with the correct field types, but also LOAD data from the database*/
      function describe_var($field_name, $field_type)
      {
         $this->arr_field_types[$field_name] = new data_type($field_name, $field_type);
         
      }
      
      /*Creates a list of mySql table fields for your data in this class, used for creating tables*/
      function output_data_types_as_sql()
      {
          $str_output = '';
          foreach($this->arr_field_types as $index=>$value)
          {
             $str_output .= '`'.$index.'` '.$value->field_type." NOT NULL,";
          }
          return $str_output;
      }

  }
  
  /*Users table*/
  $users_table = new create_table('users', $database->stub);
  $users_table->add_field(true,'user_id','INT(11)');
  $users_table->add_field(false,'user_username','VARCHAR(255)');
  $users_table->add_field(false,'user_password','VARCHAR(255)');
  $users_table->add_field(false,'user_email','VARCHAR(255)');
  $users_table->add_field(false,'user_created','DATETIME');
  $users_table->add_field(false,'user_last_logged_in','DATETIME');
  $users_table->add_field(false,'user_avatar','VARCHAR(255)');
  $database->database_create_tables($users_table);
  
  /*IP Access table*/
  $ip_table = new create_table('users_ip_access', $database->stub);
  $ip_table->add_field(true,'allow_id','INT(11)');
  $ip_table->add_field(false,'allow_user','INT(11)');
  $ip_table->add_field(false,'allow_ip','VARCHAR(255)');
  $database->database_create_tables($ip_table);
  
  $obj_value = new data_store;  //Create a data_store
  $obj_value->describe_var('cms_section_name',MYSQL_DATA_TYPE_VARCHAR); //Describe a filed in the mySql table called title
  $obj_value->describe_var('cms_section_description',MYSQL_DATA_TYPE_TEXT); //Describe a filed in the mySql table called description
  $obj_value->describe_var('cms_section_reserved_name',MYSQL_DATA_TYPE_VARCHAR); //Describe a filed in the mySql table called description
  $obj_value->describe_var('cms_section_image',MYSQL_DATA_TYPE_VARCHAR);
  $obj_value->describe_var('cms_section_file',MYSQL_DATA_TYPE_VARCHAR);
  $obj_value->describe_var('cms_section_folder',MYSQL_DATA_TYPE_VARCHAR);
  $obj_value->describe_var('cms_section_highlight',MYSQL_DATA_TYPE_VARCHAR);
  
  //WHEN THE TREE CLASS LOADS DATA FROM A TABLE IT WILL USE THE INFORMATION PASSED IN THE DESCRIBE_VAR FUNCTION TO ASSIGN DATA
  $obj_value->cms_section_name = 'Home'; //tHE TABLE CONTAINS A FIELD CALLED 'title'
  $obj_value->cms_section_description = 'Welcome to the CMS, please select an option.'; //tHE TABLE CONTAINS A FIELD CALLED 'description'
  $obj_value->cms_section_reserved_name = 'HOME';
  $obj_value->cms_section_image = 'Welcome to the CMS, please select an option.';
  $obj_value->cms_section_file = './home.php';
  $tree = new tree($obj_value,'home','cms'); //CREATE A TREE CLASS WITH A ROOT NODE, also takes a $tablename param which stores the $tablename of the tree list
  $tree->database_createtable('cms', $obj_value);  //Creates a table, the first param is the table name and the second param is a data_store object such as the one in this examples, field types must be set
 
?>