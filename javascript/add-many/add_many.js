// JavaScript Document
// JavaScript Document
/*Add many, a object to add multiple values to a form before submission*/
/*A jquery plugin for tooltips*/
(function ($) {

    $.fn.TumbleAddMany = function (objSettings) {
    
        var element = $(this);
        
        /*load the template*/
        $.get( objSettings.template, function( data ) {

            var addrow = '';
            
            for(var i = 0; i < objSettings.fields.length; i++)
            {
              addrow += '<div class = "tumble-software-add-many-input"><label>'+objSettings.fields[i].title+'</label>'+addField(objSettings.fields[i].name,objSettings.fields[i].title, objSettings.fields[i].type,objSettings.fields[i].defaultValue,objSettings.fields[i].possibleValues)+'</div>';
            }

            /*process the template*/
            data += '<input type = "hidden" name = "'+objSettings.name+'" value = "" />';
          element.html(data); 
          element.attr('id','tumble-software-add-many-id-'+objSettings.id);
          element.find('.tumble-software-add-many-add-row').html(addrow);
          element.find('.tumble-software-add-many-add-row > div').css('width',(100 / objSettings.fields.length)+'%');
          element.find('.tumble-software-add-many-header').html(objSettings.title);
          addRows(element);
          
          /*Add data*/
          element.find('.tumble-software-add-many-add-button button').click(function(){
            console.log('here');
            var output = '<div class = "tumble-software-add-many-inline"><span class = "tumble-software-add-many-options"><a class = "tumble-software-add-many-delete" href = "#">Delete</a></span><div class = "tumble-software-add-many-row-data">';
          
            for(var i = 0; i < objSettings.fields.length; i++)
            {
              output += '<div class = "tumble-software-add-many-input-field-value" data-index="'+i+'" data-value="'+getValue(objSettings.fields[i].name,objSettings.fields[i].type,element,objSettings.fields[i].possibleValues ).value+'"><span>'+getValue(objSettings.fields[i].name,objSettings.fields[i].type,element,objSettings.fields[i].possibleValues).holder+'</span></div>';
            }   
            output += '</div></div>';
            element.find('.tumble-software-add-many-data').prepend(output);
            deleteRow();
            element.find('.tumble-software-add-many-row-data > div').css('width',(100 / objSettings.fields.length)+'%');
            
            onFocus(element);
            element.find('.tumble-software-add-many-data').sortable();
            element.find('.tumble-software-add-many-data').disableSelection();
            storeValues(element);
        
        });
        
            onFocus(element);
        
        });
        
        function addRows(element)
        {
           

            
            for(var k = 0; k < objSettings.values.length; k++)
            {
                  var output = '<div class = "tumble-software-add-many-inline"><span class = "tumble-software-add-many-options"><a class = "tumble-software-add-many-delete" href = "#">Delete</a></span><div class = "tumble-software-add-many-row-data">';
          
                      
                  
                  for(var j = 0; j < objSettings.values[k].length; j++)
                  {
                      
                      for(var i = 0; i < objSettings.fields.length; i++)
                      {
                          if(objSettings.fields[i].name == objSettings.values[k][j].name)
                          {
                          
                            var value = '';
                            switch(objSettings.fields[i].type)
                           {
                                case 'text':
                                      value = objSettings.values[k][j].value;
                                break;
                                
                                case 'check':
                                     value = objSettings.fields[i].possibleValues[objSettings.values[k][j].value]; 
                                break;
                                
                                case 'select':
                                     value = objSettings.fields[i].possibleValues[objSettings.values[k][j].value];
                                break;
                                   
                           }
                            output += '<div class = "tumble-software-add-many-input-field-value" data-index="'+i+'" data-value="'+objSettings.values[k][j].value+'"><span>'+value+'</span></div>';
                          }
                      }
                      

                  }
                  
                                        output += '</div></div>';
                      element.find('.tumble-software-add-many-data').prepend(output);
              
            }   
            
            deleteRow();
            element.find('.tumble-software-add-many-row-data > div').css('width',(100 / objSettings.fields.length)+'%');
            
            onFocus(element);
            element.find('.tumble-software-add-many-data').sortable();
            element.find('.tumble-software-add-many-data').disableSelection();
            storeValues(element); 
        }
        
        
        function deleteRow()
        {
           $('.tumble-software-add-many-delete').unbind('click');
                  $('.tumble-software-add-many-delete').click(function() {
      
                     $(this).parent().parent().remove();
                     storeValues(element) 

                      
                  }); 
        }
        
        
        function storeValues(element)
        {
            var obj_values = [];
            
            element.find('.tumble-software-add-many-row-data').each(function(){
            
                var row = [];
                $(this).find('.tumble-software-add-many-input-field-value').each(function(){
                
                 row.push({'name':objSettings.fields[$(this).attr('data-index')].name,'value':$(this).attr('data-value')});  
                
                });
                obj_values.push(row);
            });
            
            element.find('input[name="'+objSettings.name+'"]').val(JSON.stringify(obj_values));
            console.log(JSON.stringify(obj_values)); 
            
            
        }
        
        
        
        function loseFocus(element)
        {
                  $('.tumble-software-add-many-input-field-value input, .tumble-software-add-many-input-field-value select').unbind('focusout');
                  $('.tumble-software-add-many-input-field-value input, .tumble-software-add-many-input-field-value select').focusout(function() {
      
                     $(this).parent().attr('data-value',getValue(objSettings.fields[$(this).parent().attr('data-index')].name+'-edit',objSettings.fields[$(this).parent().attr('data-index')].type,element,objSettings.fields[$(this).parent().attr('data-index')].possibleValues).value);
                     $(this).parent().html('<span>'+getValue(objSettings.fields[$(this).parent().attr('data-index')].name+'-edit',objSettings.fields[$(this).parent().attr('data-index')].type,element,objSettings.fields[$(this).parent().attr('data-index')].possibleValues).holder+'</span>');
                     storeValues(element) 
                     onFocus(element); 
                      
                  });         
        }
        
        function onFocus(element)
        {
              $('.tumble-software-add-many-input-field-value span').unbind('click');
              $('.tumble-software-add-many-input-field-value span').click(function(){
            
                  
                  $(this).parent().html(addField(objSettings.fields[$(this).parent().attr('data-index')].name+'-edit',objSettings.fields[$(this).parent().attr('data-index')].title, objSettings.fields[$(this).parent().attr('data-index')].type,$(this).parent().attr('data-value'), objSettings.fields[$(this).parent().attr('data-index')].possibleValues));
                  $('.tumble-software-add-many-input-field-value input, .tumble-software-add-many-input-field-value select').focus();
                  
                  loseFocus(element);
            });  
        }
        

        function addField(name, title, type, defaultValue, possibleValues)
        {
           switch(type)
           {
                case 'text':
                      return '<input type = "text" name="tumble-software-add-many-field-'+name+'" value = "'+defaultValue+'" />';
                break;
                
                case 'check':
                     
                     var checked = "";
                     if(defaultValue == 1)
                     {
                       checked = ' checked="checked" ';
                     }
                     
                     
                     return '<input type = "checkbox" name="tumble-software-add-many-field-'+name+'" value = "1"'+checked+' />';
                break;
                
                case 'select':
                      output = '<select name = "tumble-software-add-many-field-'+name+'">';
                     
                     for (key in possibleValues) {
                          
                          if(defaultValue == key)
                          {
                            output += '<option value = "'+key+'" selected="selected">'+possibleValues[key]+'</option>';  
                          }else
                          {
                            output += '<option value = "'+key+'">'+possibleValues[key]+'</option>';
                          }
                          
                          
                      }
                      
                      output += '</select>';
                      
                      return output;
                break;
                   
           }

        }
        
        function getValue(name, type, element, possibleValues)
        {
            console.log(element.find('input[name=tumble-software-add-many-field-'+name+']').prop('checked'));
            
            switch(type)
           {
                case 'text':
                      return {'value':element.find('input[name=tumble-software-add-many-field-'+name+']').val(),'holder':element.find('input[name=tumble-software-add-many-field-'+name+']').val()};
                break;
               case 'check':
                     
                     
                     var checked = 0;
                     if(element.find('input[name=tumble-software-add-many-field-'+name+']').prop('checked') == true)
                     {
                       checked = 1;
                     } 

                      return {'value':checked,'holder':possibleValues[checked]};
                break;
                
                case 'select':

                      return {'value':element.find('select[name=tumble-software-add-many-field-'+name+']').val(),'holder':possibleValues[element.find('select[name=tumble-software-add-many-field-'+name+']').val()]};
                break;    
           }
        }


    
    
    
    } 

})(jQuery);