// JavaScript Document
(function ($) {

    $.fn.TumbleAccordian = function (objSettings) {
    
        return this.each(function() {
        
        
            var wrapper = $(this);
            $(this).find('a[data-accordian]').each(function(){
               var strClass = $(this).attr('data-accordian');
               
                  
            });
            
            
           $(this).find('a[data-accordian]').click(
              
              function()
              {
                  var strClass = $(this).attr('data-accordian');
                  console.log(strClass);
                  
                  wrapper.find('.'+strClass).animate({
                       
                            height: "toggle"
                        
                          }, 1000, function() {
                        
                            // Animation complete.
                        
                          });


                 return false; 
                  
              }
           
           );
        
        
        });
    
    
    }
    
})(jQuery);     