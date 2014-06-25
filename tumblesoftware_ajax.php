<?php
   require('./framework.php');
   $param = new param();
   
   $str_id = $param->get_param('id','', true);
    $str_message = $param->get_param('message_output','', true);
   $str_query = 'SELECT * FROM ' . $database->database_tablename('ajax') . ' where ajax_form_id = \''.$str_id.'\'';
   $results = $database->database_query($str_query);
   
   if($database->database_hasrows($results))
   {
      $obj = $database->database_fetch('ajax_id','ajax_id',$results);
      $ajax = new ajax($obj->ajax_action, $obj->ajax_form_id, $obj->ajax_element, $obj->ajax_event, $obj->ajax_callback, $obj->ajax_return_type, $obj->ajax_method);
      header('Content-Type: application/javascript');
      echo $ajax->output_javascript($str_message);
   
   
   }
   
   
?>