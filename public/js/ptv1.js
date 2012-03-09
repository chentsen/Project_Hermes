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
    
    /***** click menu top *****/
	$('.icon_bar ul .friends-button').click(function(){
        $(this).find('ul.sub-setting2').toggle('fast');
		$('ul.sub-settings').hide();
        //$(this).toggleClass('icon_bar_bg');
    });
	
   $('.icon_bar ul .settings-button').click(function(){
        $(this).find('ul.sub-settings').toggle('fast');
       $('ul.sub-setting2').hide();
    });
   
   $('ul.sub-setting2').hide();
   $('ul.sub-setting2').hide();
   
    //$('.icon_bar ul .settings-button ul.sub-settings').hide();
  
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
    ToggleIt('.notifications_block .block-header', '.notifications_block .block-body', '.notifications_block .block-header'); 
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
    //Non Modal Input fields
	if (window.location.pathname=='/password-reset') {
	  $('#email').defaultText({text: 'Email'});
	} else if (window.location.pathname=='/password-change') {
	  $('#originalPassword').defaultText({text: 'Original Password'});
	  $('#password').defaultText({text: 'New Password'});
	  $('#password2').defaultText({text: ' New Password Again'});
	}  else if (window.location.pathname=='/contact') {
		 $('#email').defaultText({text: 'Email'});
		 $('#name').defaultText({text: 'Name'});
		 $('#subject').defaultText({text: 'Subject'});
		 $('#text').defaultText({text: 'Your Text'});
	} else if (window.location.pathname=='/' || window.location.pathname=='/index' ||
			   window.location.pathname=='/index#' || window.location.pathname=='/index/index'){
       $('#email').defaultText({text: 'Email'});
    	  $('#password').defaultText({text: 'Password'});
	}
});


var Display = {
        hideDisplay:function(parent){
                $(parent).hide();

        }
    };      