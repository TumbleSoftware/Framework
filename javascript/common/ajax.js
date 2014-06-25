     /*Ajax class defines the behavious of forms and other objects*/
     
     (function ($) {

          $.fn.tumbleAjax = function (objSettings) {
          
              $(this).click(function()
              {
                              console.log('here');
                              $.ajax({
                                  cache: false,
                                  type: objSettings.method,
                                  dataType: objSettings.data_type,
                                  url: objSettings.url,
                                  xhrFields: {
                                              withCredentials: true
                                  },
                                }).done(function( msg ) {
                                        console.log('here');
                                        if(typeof objSettings.done == 'function')
                                        {
                                            objSettings.done(msg);
                                        }  
                    
                                }); 
              }
                                          
              );
          
          
          
          }
          
          })(jQuery);