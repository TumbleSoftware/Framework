<?php
   /*A common functions class*/
   /*For things which are common but dont really need a class*/
   function convert_arr_to_object($arr_data)
   {
       $obj_data = new stdClass();
       foreach($arr_data as $key=>$value)
       {
          $obj_data->$key = $value;
       }
       return $obj_data;
   }
   
   function innerHTML($nodes)
      {
          $output = '';
          	$elements = $nodes->childNodes;
          	foreach( $elements as $element ) { 
          		if ( $element->nodeType == XML_TEXT_NODE ) {
          			$text = $element->nodeValue;
          			// IIRC the next line was for working around a
          			// WordPress bug
          			//$text = str_replace( '<', '&lt;', $text );
          			$output .= $text;
          		}	 
          		// FIXME we should return comments as well
          		elseif ( $element->nodeType == XML_COMMENT_NODE ) {
          			$output .= '';
          		}	 
          		else {
          			$output  .= '<';
          			$output  .= $element->nodeName;
          			if ( $element->hasAttributes() ) { 
          				$attributes = $element->attributes;
          				foreach ( $attributes as $attribute )
          					$output  .= " {$attribute->nodeName}='{$attribute->nodeValue}'" ;
          			}	 
          			$output  .= '>';
          			$output  .= innerHTML( $element );
          			$output  .= "</{$element->nodeName}>";
          		}	 
             }	 
            
            return $output;

      }
   
?>