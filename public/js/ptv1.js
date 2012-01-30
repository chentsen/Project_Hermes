$(function()
		{
		$("input").blur(function()
			{
			  
			var formElementId = $(this).attr('id');
               //alert(formElementId);
			   formid = $(this).get(0).form.id;
                        doValidation(formElementId, formid);   
                  
		});

	});
function doValidation(id, formname)
{
    if (window.location.pathname=='/index' && formname == 'registration')
        {
            var url = '/ajax/ajaxform';
        } else if (window.location.pathname=='/index' && formname == 'login')
		{
			var url = '/ajax/ajaxlogin';
		}
	  else if (window.location.pathname=='/registration/index' || window.location.pathname=='/registration/')
       {
		 
           var url = '/ajax/ajaxform';
       }
    else if (window.location.pathname=='/' && formname == 'registration')
           {
        var url = '/ajax/ajaxform';
           }
    else if (window.location.pathname=='/' && formname == 'login')
        {
    var url = 'ajax/ajaxlogin';
        }
    var data = {};
    $("input").each(function() {
           data[$(this).attr('id')] = $(this).val();
     });
     $.post(url,data,function(resp)
     {
	  
			if(formname == 'registration') {
			
			$("#registration #"+id).parent().find('.errors').remove();
			 $("#registration #"+id).parent().append(getErrorHtml(resp[id], id));
			} else {
			   $("#"+id).parent().find('.errors').remove();			
			$("#"+id).parent().append(getErrorHtml(resp[id], id));
			
			}
		
	  },'json');
	
}
function getErrorHtml(formErrors, id)
{
    var output = '<ul id="errors-'+id+'" class="errors">';
    for (errorKey in formErrors)
        {
             output += '<li>' + formErrors[errorKey] + '</li>';
               
        }
    output += '</ul>';
	
    return output;
    
}
function getAlert(formErrors) {
   var output = "";
   for(errorKey in formErrors) {
	  output += formErrors[errorKey];
   }
   return output;
   }

//close status


$(document).ready(function(){
   /*** Onclick hide add button ***/
   $('.remove-anchor').click(function(){
	  $(this).hide('slow');
	  });
    /*** remove background image on any form input that has been submitted incorrectly **/
			if($('input[type="text"]').val())
                {
					 
					 $('input[type="text"]').addClass('removebg');	  
				}
    
    /***** click menu top *****/
   $('.icon_bar ul .settings-button').click(function(){
        $(this).find('ul.sub-settings').toggle('fast');
       
    });
   $('.icon_bar ul .friends-button').click(function(){
        $(this).find('ul.sub-setting2').show('fast');
        $(this).toggleClass('icon_bar_bg');
    });

    
  
    $('.eventFeedObject:last-child').css({
        'border-bottom-right-radius':'5px',
        'border-bottom-left-radius':'5px',
        'border-bottom' : 'none'
    
    });
   
   
 
   function ToggleIt(toggler, toggled, bgchange){
  
    $(toggler).click(function(){
       
        $(toggled).slideToggle('fast');
        $(bgchange).toggleClass('block-close');
       });
      
    }
    ToggleIt('.upcoming_events .block-header', '.upcoming_events .block-body', '.upcoming_events .block-header');
    ToggleIt('.friends_block .block-header', '.friends_block .block-body', '.friends_block .block-header'); 
  /*
   
   
     $('.loginonce').click(function(){
            $(this).hide(2000, function(){
            $(this).remove();
            });
            $.cookie('loginOnce','removed');
     });
     
     var loginOnce = $.cookie('loginOnce')
     
     if(loginOnce == 'removed') {
         $('.loginonce').hide();
     }
     
     */
   
        
       
        //registration page
      function BdOrange(nClass, rClass){
           
          $(nClass).focus(function(){
          $(this).addClass('change_border_color')
          $(this).addClass('removebg');
          
          });
          $(nClass).blur(function(){
              if ($.trim(this.value) == '') { 
                  $(this).removeClass('removebg');
             }
               $(this).removeClass('change_border_color');
               
          });
      }
        BdOrange('input[type=text], input[type=password]', 'input[type=text], input[type=password]');
        
        BdOrange('textarea', 'textarea');
        
        var BdRemove = function(noClass) {
            $(noClass).focus(function(){
                $(this).removeClass("change_border_color");
            });
            
        } 
        BdRemove('.profile #content_area .tag_input');
          
            /****** events page *******/
     //$( "#createEvent_date" ).datepicker({dateFormat: 'dd/mm/yy'});
      
   
        
  //login page and registration remove bg

     
           //email 
           function BgRemove(nClass) {
                if($(nClass).val())
                {
                        $(nClass).focus(function(){
								$(nClass).addClass('removebg');
                });
						$(nClass).blur(function(){
						 $(nClass).removeClass('removebg');
						});
				}
               
           }
		   BgRemove('#email');
          BgRemove('#firstName');
          BgRemove('#lastName');
          BgRemove('#city');
		  BgRemove('#password');
		  BgRemove('#password2');
          BgRemove('#betakey');
          

		 
      /** disable highlights ***/
      $('.block-header h3').addClass('noSelect');
      $('.tags').addClass('noSelect');
       
       /** disable text highlight ***/
	$.extend($.fn.disableTextSelect = function() {
        return this.each(function(){
            if($.browser.mozilla){//Firefox
                $(this).css('MozUserSelect','none');
            }else if($.browser.msie){//IE
                $(this).bind('selectstart',function(){return false;});
            }else{//Opera, etc.
                $(this).mousedown(function(){return false;});
            }
        });
    });
    $('.noSelect').disableTextSelect();
    //*** end disable function
    

});

var Display = {
        hideDisplay:function(parent){
                $(parent).hide();

        }
    };      