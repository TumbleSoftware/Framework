// JavaScript Document
/*TumbleTooltips*/
/*A jquery plugin for tooltips*/
(function ($) {

    $.fn.TumbleTooltips = function (objSettings) {
                /*An array containing the various positions for the tooltip tip to be pointed at*/
                var tip_positions = ['top','left','right','bottom'];
                var settings_objects = [];

                 return this.each(function() {
                                
                                
                                var settings = {
                                data_tip: (tip_positions.indexOf($(this).attr('data-tip')) != -1) ? $(this).attr('data-tip') : 'left', 
                                data_fade_in:($(this).attr('data-fade-in') != '') ? $(this).attr('data-fade-in') : '0',
                                data_fade_out:($(this).attr('data-fade-out') != '') ? $(this).attr('data-fade-out') : '0',
                                data_tooltip:$(this),
                                data_content:$(this).attr('data-tooltip-content'),
                                data_contained: ($(this).attr('data-contained') == 'yes') ? $(this).attr('data-contained') : 'no',
                                data_event: ($(this).attr('data-tooltip-event') != '') ? $(this).attr('data-tooltip-event') : 'hover',
                                data_classes: $(this).attr('data-classes')
                                };
                                /*Compose the tooltip*/
                                if(typeof objSettings.tooltip_format == 'function')
                                {
                                    var content = objSettings.tooltip_format(settings.data_content);
                                }else
                                {
                                    var content = settings.data_content;
                                }
                                
                                console.log(settings.data_classes);
                                var output = '<div class = "tumble-tooltip-tooltip '+settings.data_classes+'">'+content+'<div class = "tumble-tooltip-tip"></div></div>';  
            
                                /*Calculate the width of the tooltip*/
                                
                                $(settings.data_tooltip).wrap('<div class = "tumble-tooltip-element-wrapper"></div>');
                                $(settings.data_tooltip).parent().append(output);
                                settings.data_tooltip = $(settings.data_tooltip).parent();
                                
                                var width = $(settings.data_tooltip).find('.tumble-tooltip-tooltip').outerWidth(true);
                                console.log(width);
                                var height = $(settings.data_tooltip).find('.tumble-tooltip-tooltip').outerHeight(true);
                                
                               
            
                                
                                /*Next we check where the tooltip has to go and calculate various points*/
                                
                                var topx;
                                var topy;
                                switch(settings.data_tip)
                                {
                                  case 'left':
                                    topx = width;
                                    topy = height - settings.data_tooltip.outerHeight();
                                    if(topy < 0)
                                    {
                                        var offset = (Math.floor((settings.data_tooltip.outerHeight(true) - height) / 2));
                                    }
                                    else
                                    {
                                        var offset = Math.floor(topy / 2) * -1;
                                    }
                                    
                                    topy = offset;
            
                                    size_of_tooltip = (height / 100) * 30;
                                    var borderwidth = $(settings.data_tooltip).find('.tumble-tooltip-tooltip').css('borderRightWidth');
            
            
            
                                    $(settings.data_tooltip).find('.tumble-tooltip-tip').addClass('tumble-tooltip-tip-left').css('top',((height - size_of_tooltip) / 2) + 'px').css('right','-'+((size_of_tooltip / 2)+parseInt(borderwidth.replace('px',''))) + 'px').css('height',size_of_tooltip+'px').css('width',size_of_tooltip+'px');
                                    $(settings.data_tooltip).find('.tumble-tooltip-tooltip').addClass('tumble-tooltip-background-left').css('top', topy + 'px').css('left', '-'+(width + size_of_tooltip) + 'px');
                                  break;
                                  case 'top':
                                    topy = height;
                                    topx = width - settings.data_tooltip.outerWidth(true);
                                    if(topx < 0)
                                    {
                                        var offset = (Math.floor((settings.data_tooltip.outerWidth(true) - width) / 2));
                                    }
                                    else
                                    {
                                        var offset = Math.floor(topx / 2) * -1;
                                    }
                                    
                                    topx = offset;
            
                                    size_of_tooltip = (height / 100) * 30;
                                    var borderwidth = $(settings.data_tooltip).find('.tumble-tooltip-tooltip').css('borderBottomWidth');
            
            
            
                                    $(settings.data_tooltip).find('.tumble-tooltip-tip').addClass('tumble-tooltip-tip-top').css('bottom','-' + ((size_of_tooltip) / 2) + 'px').css('left',((width-size_of_tooltip) /2) + 'px').css('height',size_of_tooltip+'px').css('width',size_of_tooltip+'px');
                                    $(settings.data_tooltip).find('.tumble-tooltip-tooltip').addClass('tumble-tooltip-background-left').css('top','-' + (topy+ size_of_tooltip) + 'px').css('left', topx+'px');
                                  
                                  
                                  
                                  break;
                                  case 'right':
                                    topx = width;
                                    topy = height - settings.data_tooltip.outerHeight();
                                    if(topy < 0)
                                    {
                                        var offset = (Math.floor((settings.data_tooltip.outerHeight(true) - height) / 2));
                                    }
                                    else
                                    {
                                        var offset = Math.floor(topy / 2) * -1;
                                    }
                                    
                                    topy = offset;
            
                                    size_of_tooltip = (height / 100) * 30;
                                    var borderwidth = $(settings.data_tooltip).find('.tumble-tooltip-tooltip').css('borderLeftWidth');
            
            
            
                                    $(settings.data_tooltip).find('.tumble-tooltip-tip').addClass('tumble-tooltip-tip-right').css('top',((height - size_of_tooltip) / 2) + 'px').css('left','-'+((size_of_tooltip / 2)+parseInt(borderwidth.replace('px',''))) + 'px').css('height',size_of_tooltip+'px').css('width',size_of_tooltip+'px');
                                    $(settings.data_tooltip).find('.tumble-tooltip-tooltip').addClass('tumble-tooltip-background-left').css('top', topy + 'px').css('right', '-'+(topx + size_of_tooltip) + 'px');
                                  
                                  
                                  
                                  break;
                                  case 'bottom':
                                    topy = height;
                                    topx = width - settings.data_tooltip.outerWidth(true);
                                    if(topx < 0)
                                    {
                                        var offset = (Math.floor((settings.data_tooltip.outerWidth(true) - width) / 2));
                                    }
                                    else
                                    {
                                        var offset = Math.floor(topx / 2) * -1;
                                    }
                                    
                                    topx = offset;
            
                                    size_of_tooltip = (height / 100) * 30;
                                    var borderwidth = $(settings.data_tooltip).find('.tumble-tooltip-tooltip').css('borderBottomWidth');
            
            
            
                                    $(settings.data_tooltip).find('.tumble-tooltip-tip').addClass('tumble-tooltip-tip-bottom').css('top','-' + ((size_of_tooltip) / 2) + 'px').css('left',((width-size_of_tooltip) /2) + 'px').css('height',size_of_tooltip+'px').css('width',size_of_tooltip+'px');
                                    $(settings.data_tooltip).find('.tumble-tooltip-tooltip').addClass('tumble-tooltip-background-left').css('bottom','-' + (topy+ size_of_tooltip) + 'px').css('left', topx+'px');
                                  
                                  
                                  
                                  break;
                                  
                                }
                                
                                switch(settings.data_event)
                                {
                                    case 'hover':
                                       $(settings.data_tooltip).hover(function(){$(settings.data_tooltip).find('.tumble-tooltip-tooltip').fadeIn(settings.data_fade_in);},function(){$(settings.data_tooltip).find('.tumble-tooltip-tooltip').fadeOut(settings.data_fade_out);});
                                    break;
                                    case 'click':
                                       $(settings.data_tooltip).click(function(){$(settings.data_tooltip).find('.tumble-tooltip-tooltip').fadeIn(settings.data_fade_in);});
                                        $(settings.data_tooltip).hover(function(){},function(){$(settings.data_tooltip).find('.tumble-tooltip-tooltip').fadeOut(settings.data_fade_out);});
                                    break;
                                    case 'load':
                                        $(document).ready(function(){$(settings.data_tooltip).find('.tumble-tooltip-tooltip').fadeIn(settings.data_fade_in);});
                                      
                                      break;
                                
                                }
                                
                                
      
                          });
                          
                          

                

                               
                
    } 

})(jQuery); 
