// JavaScript Document
$(document).ready(function()
{
  
  
  
  

});

(function ($) {

    $.fn.progressIndicator = function (objSettings) {
    
          console.log('Here');
          var addTo = $(this);
          $.ajax({
          type: "GET" ,
          url: '../installation/install.xml' ,
          dataType: "xml" ,
          success: function(xml) {
      
            console.log(xml);
            
            $(xml).find('zip').each(
       
                    function()
                    {
                        console.log('here');
                        var file = $(this).text();
                        addTo.append('<p>Loading File: ' + file + '</p>');
                        
                        $.ajax({
                          type: "GET" ,
                          url: './ajaxinstall.php' ,
                          dataType: "json" ,
                          data: {'file': file},
                          success: function(json) {
                                     addTo.append('<p>' + json[0] + '</p>');
                                    }
                        });
                        
                        
                    }
          
              );  
             
          }
          });
    
    } 

})(jQuery); 