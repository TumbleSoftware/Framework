<?php
  
  
   /*List of constants corresponding to mysql data types*/
   /*Feel free to add more if your required data type is not here*/
   const MYSQL_DATA_TYPE_INT = 'INT(11)';
   const MYSQL_DATA_TYPE_VARCHAR = 'VARCHAR(10000)';
   const MYSQL_DATA_TYPE_TEXT = 'TEXT';
   const MYSQL_DATA_TYPE_DATETIME = 'DATETIME';
   
     

  /*This class stores the mySql table field information*/
  class data_type extends common_objects
  {
  
      /*field name should correspond to a variable in the class data_sotre*/
      /*Example if $field_name = 'title', there should be a public variable in the data_store class called $title*/
      public $field_name, $field_type;
      
      function __construct($field_name, $field_type)
      {
        $this->field_name = $field_name;
        $this->field_type = $field_type;
      }
  }
  
  

  
  /*The main tree class, starts with a root node and expands out from there*/
   class tree extends common_objects{
     
     /*$root is the root node, it will contain all the other nodes*/
     /*Examples: node-0 (root)
                    node-1
                    node-2 
                        $node-3
    */
    /*Database stores the connection to the database, Used to insert, select and create*/
    /*$Tablename is the string storing table used to store the tree*/
     protected $root, $tablename;
     public static $database; 
  
      /*Called when creating a new tree*/
      function __construct($obj_value, $root_node_id = 'root', $tablename)
      {
                   parent::__construct();
          $this->define_class(get_class($this));
         
         /*Create a new row of nodes, called root because it will store 1 low level root node*/
         $this->root = new row();
         /*Add the root node*, OVERWRITTED if you load data from a table*/
         $this->root->add_node($obj_value, $root_node_id);
         $this->tablename = $tablename;
         
      }
      
      
           
      /*Loads table data from a mySql table into the tree*/
      /*The variable $temp_data contains the field properties for user data in a node*/
      /*Example
              $obj_value = new data_store;  //Create a data_store
              $obj_value->describe_var('title',MYSQL_DATA_TYPE_VARCHAR); //Describe a filed in the mySql table called title
              $obj_value->describe_var('description',MYSQL_DATA_TYPE_TEXT); /Describe a filed in the mySql table called description
              
              //WHEN THE TREE CLASS LOADS DATA FROM A TABLE IT WILL USE THE INFORMATION PASSED IN THE DESCRIBE_VAR FUNCTION TO ASSIGN DATA
              $obj_value->title = 'A root level node'; //tHE TABLE CONTAINS A FIELD CALLED 'title'
              $obj_value->description = 'A root level node description'; //tHE TABLE CONTAINS A FIELD CALLED 'description'
              $tree = new tree($obj_value,'node-0','tumble_tree'); //CREATE A TREE CLASS WITH A ROOT NODE, also takes a $tablename param which stores the $tablename of the tree list
             $tree->database_connection('localhost','root', '', 'examples','3307'); //Coonnect to the database
             $tree->database_createtable('tumble_tree', $obj_value);  //Creates a table, the first param is the table name and the second param is a data_store object such as the one in this examples, field types must be set
             $tree->database_loadtable($obj_value); //Load data from a table, takes a param of type data_store which contains the fields types such as in this example
      */
          
      function database_loadtable()
      {


            $bool_root = true;
            $arr_list_of_ids = array();
            $str_query = 'SELECT * FROM ' . parent::$database->database_tablename($this->tablename) . ' WHERE tree_node_id = \'ROOT\'';
            $results =  parent::$database->database_query($str_query);
            $data = parent::$database->database_fetch($results);
            $this->root = new row();
            $arr_list_of_ids[] = $this->root->add_node($data,$data->tree_node_id);
            
            /*Grab all data in the table*/
            $str_query = 'SELECT * FROM ' . parent::$database->database_tablename($this->tablename) . ' WHERE tree_node_id <> \'ROOT\'';
            $results =  parent::$database->database_query($str_query); 
            

            while($data = parent::$database->database_fetch($results))
            {

               $arr_list_of_ids[] = $this->add_node($data->tree_node_parent,$data,$data->tree_node_id);   
                          
            
            }
            
            return $arr_list_of_ids;
      }
      
      function database_save()
      {
        $this->traverse_tree('', true);
      }
      
      /*Creates a table if one doesnt exists, saves the end user the hastle of making sure it contains the right fields*/
      function database_createtable($tablename, $class_data)
      {
          $str_query = 'CREATE TABLE IF NOT EXISTS `'. parent::$database->database_tablename($tablename).'` (`tree_id` int(11) NOT NULL AUTO_INCREMENT,`tree_node_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,`tree_node_parent` varchar(255) COLLATE utf8_unicode_ci NOT NULL,'.$class_data->output_data_types_as_sql().'  PRIMARY KEY (`tree_id`) );';
       
           parent::$database->database_query($str_query);
          $this->tablename = $tablename;
      }
      
      /*Adds a node to the tree, takes 2 params*/
      /*
          $parent: a string containing a node id to add the data too
          $$obj_value A object of type data_store
          $id A user defined id for the node
      */
      function add_node($parent, $obj_value, $id = '')
      {
          $obj_value = clone $obj_value;
          $node = $this->traverse_tree($parent, false);
          $node->children->add_node($obj_value, $id);
          return $id;
      }
      
      
      /*Moves a node and its children to another node, takes 2 params*/
      /*WHEN USING THIS FUNCTIONS BE SURE NOT TO MOVE THE NODE TO ONE OF THE NODES CHILDREN*/ 
      /*
          $id: The user defined id for the node 
          $parent_to_move_to: The new parent node the node will be added to
      */
      function move_node($id, $parent_to_move_to)
      {
         $node = $this->traverse_tree($id, false);
         $move_to = $this->traverse_tree($parent_to_move_to, false);
         $move_to->children->add_node_obj($node);
         $node->remove_node();
      }
      
      /*Removes the node and its children based of the user defined id*/
      function remove_node($id)
      {
        $node = $this->traverse_tree($id, false);
        
        if(isset($node))
        {
            $node->remove_node();
        }    
      }
      
      /*Gets the data associated with a node, the node is identified by the user defined id*/
      function get_node($id)
      {
        $node = $this->traverse_tree($id);
        return $node->obj_value;
      }
      
      function search($arr_params)
      {
         $arr_results = array();
         $this->root->search($arr_params, $arr_results);
         return $arr_results; 
      
      }
      
      /*Loop through all the nodes until we either find the node we're looking for or we have inserted all the data in the database*/
      function traverse_tree($parent,$insert_into_database = false)
      {
         $arr_null = array();
         $level = 0;
         if($insert_into_database == true)
         {
            $sql = 'TRUNCATE TABLE `'. parent::$database->database_tablename($this->tablename).'`';
             parent::$database->database_query($sql);
         }
         $node = $this->root->traverse($parent,$insert_into_database,  parent::$database, $this->tablename,'', false ,$arr_null);              
         return $node;
      }
      
      function get_row($parent, $data_only = false)
      {
        $node = $this->traverse_tree($parent);
        if($data_only)
        {
            return $node->children->return_row_data();
        }else
        {
            return $node->children->return_row();
        }
      }
      
     
      /*A debug function which outputs the structure of the tree*/
      function debug($debug = true)
      {
         $this->root->debug_traverse(0);
      }
      
      function node_ids()
      {
         $arr_node_ids = array();
         $this->root->traverse('',false, $this->database, $this->tablename,'', true, $arr_node_ids); 
         return $arr_node_ids;
      
      }
      
      function order_nodes($children = false, $parent, $field_to_sort)
      {
        $node = $this->traverse_tree($parent, false);
        $node->children->order($children, $field_to_sort);  
      
      }

  }
  
  /*Eachs nodes $children is an object of class ro, row is just a container the a nodes children*/
  
  class row
  {
        public $first_child, $last_node;
        
        function return_row()
        {
          $arr_nodes = array();           
          $node = $this->first_child;
          while($node != null)
          {
                $arr_nodes[] = $node;            
                $node = $node->next_node;
          }
          
          return $arr_nodes;
           
        }
        
        function return_row_data()
        {
          $arr_nodes = array();           
          $node = $this->first_child;
          while($node != null)
          {
                $arr_nodes[] = $node->obj_value;            
                $node = $node->next_node;
          }
          
          return $arr_nodes;
        
        }
        
        
        /*Add node to row,  Also handles previous_node and next_node so we can traverse the tree easily*/
        function add_node($obj_value,$id)
        {
          $temp_node = $this->first_child;
          $this->first_child = new node($obj_value, $id);
          if(isset($temp_node))
          {
          
          $this->first_child->next_node = $temp_node;
          $this->first_child->next_node->previous_node = $this->first_child;
          } 
          return $id;

        }
        /*Add node to row,  Also handles previous_node and next_node so we can traverse the tree easily*/
        /*This function is used in moving nodes*/
        function add_node_obj($node)
        {
            $temp_node = $this->first_child;
            $this->first_child = $node;
            if(isset($temp_node))
            {
            
            $this->first_child->next_node = $temp_node;
            $this->first_child->next_node->previous_node = $this->first_child;
            }
        }
        
        /*Prints the nodes in the row and adds indents to identify its level*/
        function debug_traverse($level)
        {
           $node = $this->first_child;          
           while($node != null)
           {
                echo str_repeat("-\t",$level).$node->id . '<br />' .str_repeat("-\t",$level);
                echo $node->obj_value->title . '<br />';
                $node->children->debug_traverse(($level + 1));
                           
                $node = $node->next_node;
           }
        }

        /*search the nodes for specific values*/
        function search($arr_params, &$arr_results)
        {
          $node = $this->first_child;
           while($node != null)
           {
               $obj_value = $node->obj_value;
               $bool_found = true;
               foreach($arr_params as $field => $value)
               {
                 if($obj_value->$field != $value)
                 {
                    
                    $bool_found = false;
                 }
               }
              
              if($bool_found == true)
              {
                  
                  $arr_results[] = $obj_value;
              }
              $node->children->search($arr_params, $arr_results);
           
               $node = $node->next_node;
           }
        }
        
        /*Traverse the row of nodes and also its children, this is a recursive function*/
        function traverse($id_to_find = '',$insert_into_database = false, &$database, &$tablename,$parent, $bool_store_ids = false, &$arr_node_ids)
        {
           $node = $this->first_child;
           while($node != null)
           {
                /*Insert node data into database*/
                if($insert_into_database == true)
                {                      
                      $obj_value = $node->obj_value;
                      $columns = '';
                      $values = '';
                      foreach(get_object_vars($obj_value) as $index => $value_obj)
                      {
                        if($index != 'arr_field_types' && $index != 'tree_id'  && $index != 'tree_node_id'  && $index != 'tree_node_parent')
                        {
                          $columns .= $index . ',';
                          $values .= '\''.$obj_value->{$index}.'\',';
                        }
                      }
                      $columns .= 'tree_node_id, tree_node_parent';
                      $values .= '\'' . $node->id . '\',\''.$parent.'\'';
                      $sql = 'INSERT INTO `'.$database->database_tablename($tablename).'`('. rtrim($columns,',').') VALUES ('.rtrim($values,',').')';
                                            
                      $database->database_query($sql);
                      $node->children->traverse($id_to_find, $insert_into_database, $database, $tablename,$node->id, false, $arr_node_ids);
                
                
                }else if($bool_store_ids == true)
                {
                      $arr_node_ids[] = $node->id;
                      $node->children->traverse($id_to_find, $insert_into_database, $database, $tablename,$node->id, $bool_store_ids, $arr_node_ids);
                
                }
                else
                {
                        /*Look for a specific node*/
                        if($node->id == $id_to_find)
                        {
                          return $node;
                        }
                        $temp_node = $node->children->traverse($id_to_find, $insert_into_database, $database, $tablename,'', false, $arr_node_ids);
                        if(isset($temp_node) && $temp_node->id == $id_to_find)
                        {
                          return $temp_node;
                        }
                }

                $node = $node->next_node;
           }
        }
        
        function order($children = false, $field_to_sort = '')
        {
           $arr_sort = array();
           
           $arr_nodes = array();
           $node = $this->first_child;
           while($node != null)
           {
             $arr_sort[$node->id] = $node->obj_value->$field_to_sort;
             $arr_nodes[$node->id] = $node;  

             $node = $node->next_node;

           }
           
           $this->first_child = null;
           
           asort($arr_sort, SORT_REGULAR);
           
           
           foreach($arr_sort as $key=>$value)
           {
             $arr_nodes[$key]->next_node = null;
             $arr_nodes[$key]->previous_node = null;
             $this->add_node_obj($arr_nodes[$key] ); 
           
           }
           
        
        }
  }
  
  /*A node, contains the user defined data, children nodes to the node*/
  class node
  {
    public $next_node, $obj_value, $id, $children, $previous_node;
    
    function __construct($obj_value, $id)
    {
       $this->obj_value = clone $obj_value;
       $this->id = $id;
       $this->children = new row();
    }
    
            
    function next()
    {
         $node = $node->next_node;
         return $node;        
    }
    
    /*Removes the node and cleans up the lists*/
    function remove_node()
    {
      $previous = $this->previous_node;
      $next = $this->next_node;
      
      if(isset($previous))
      {
          $previous->next_node = $next;
      }
      
      if(isset($next))
      {
          $next->previous_node = $previous;
      }
      unset($this);    
    }
  }


?>