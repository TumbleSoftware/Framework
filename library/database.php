<?php
  
  class create_table
  {
      protected $fields;
      public $tablename = '', $stub = '';
      
      function __construct($tablename, $stub)
      {
        $this->tablename = $stub.$tablename;
      
      
      }
      
      function add_field($primary = false, $field_name = '', $field_type = '')
      {
         $str_extras = '';
         if($primary == true)
         {
              $str_extras = 'NOT NULL AUTO_INCREMENT PRIMARY KEY';
         
         }
         
         $this->fields[] = array('field_name'=>$field_name,'field_type'=>$field_type,'field_extras'=>$str_extras,'primary'=>$primary);
      
      
      }
      
      function create_sql_query()
      {
           
           $str_query = 'CREATE TABLE IF NOT EXISTS ' . $this->tablename . '(';
           foreach($this->fields as $index=>$field)
           {
              
              $str_extra = '';
              if($field['primary'] == true)
              {
                 $str_extra = ' NOT NULL AUTO_INCREMENT PRIMARY KEY';
              }
              $str_query .= $field['field_name'] . ' ' . $field['field_type'] . $str_extra . ',';
           
           }
           $str_query = rtrim($str_query,',');
           $str_query .= ')';

           return $str_query;
      
      }
  
  
  }
  
  
  
  class database extends common_objects
  {
        protected $mysqli_object, $results;
        public $connected = false, $stub;
        
        function __construct($host, $username, $password, $database, $port, $stub = '')
        {
          parent::__construct();
          $this->define_class(get_class($this));
          $this->stub = $stub;
          $this->mysqli_object = new mysqli($host, $username, $password, $database, $port);
          if ($this->mysqli_object->connect_errno) {
              parent::add_error(MYSQL_ERROR, "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error, 'datavase.php', '__construct');
              $this->connected = false;
              return $this->connected;
          }
          
          $this->connected = true;
          return $this->connected;
        }
        
        function database_tablename($tablename)
        {
           return $this->stub . $tablename;
        }
        
        function database_query($strQuery)
        {
          
          $results = $this->mysqli_object->query($strQuery); 
          if ($this->mysqli_object->error)
          { 
             parent::add_error(MYSQL_ERROR, "Failed to execute query :" . $strQuery, 'datavase.php', 'database_query();');        
            return false;
          
          }
          
          return $results;
          
        }
        
        function database_hasrows($results)
        {
            return isset($results->num_rows) ? $results->num_rows : 0; 
        }
        
        function database_fetch($results)
        {

             $obj = $results->fetch_object();
            
 

              
               
              return $obj;

        }
        
        function database_insert($table,$class_var)
        {
           $arr_values = get_object_vars($class_var);
           foreach($arr_values as $index=>$value)
           {
                  if($index != 'id' && $index != 'where_field')
                  {
                  $fields[] = '`' . $index . '`';
		              $values[] = "'".$value."'";
                  }
           }
           $field_list = join(',', $fields);
            $value_list = join(', ', $values); 
            
            $this->database_query("INSERT INTO `" . $this->database_tablename($table) . "` (" . $field_list . ") VALUES (" . $value_list . ")");
            return $this->mysqli_object->insert_id;
        
        }
        
        
        
        
        function  database_update($table, $class_var)
          {
              	$arr_values = get_object_vars($class_var);

                foreach ($arr_values as $index=>$value) {
              		                if($index != 'id' && $index != 'where_field')
                  {
                  $fields[] = sprintf("`%s` = '%s'", $index, $value);
                  }
              	}
              	$field_list = join(',', $fields);
              	echo $arr_values['where_field'] . ' - ' . $arr_values['id'] . '<br />';
              	$query = sprintf("UPDATE `%s` SET %s WHERE `%s` = %s", $this->database_tablename($table), $field_list, $arr_values['where_field'], $arr_values['id']);
              	
              	$this->database_query($query);
            }
            
            function database_delete($tablename,$clause)
            {
              $query = "DELETE FROM " . $this->database_tablename($tablename) . " WHERE ".$clause;
              $this->database_query($query);            
            }
            
            function database_flush_table($table)
            {
              $query = "DELETE FROM " . $this->database_tablename($table) . " WHERE 1=1";
              $this->database_query($query);   
              
            }
            
            function database_check_exists($tablename, $fieldname, $fieldvalue)
            {
              $query = 'SELECT * FROM ' . $this->database_tablename($tablename) . ' WHERE ' . $fieldname . ' = \'' . $fieldvalue . '\'';
              $results = $this->database_query($query);
              
              return $this->database_hasrows($results);
            
            }
            
            function database_multiple_insert(&$arr_objects = array())
            {
                
                $arr_ids = array();
                $arr_obj_data = array();
                foreach($arr_objects as $index => $obj_data)
                {
                    $obj_data->id = $this->database_insert('data',$obj_data);
                    $arr_obj_data[] = $obj_data;
                }
            
                
            
            }
            
            function database_create_tables($obj_create_table)
            {
              $query = $obj_create_table->create_sql_query();
              $this->database_query($query);
              
            }
  
  
  
  
  
  }
?>