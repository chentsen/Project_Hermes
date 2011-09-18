/*$(function()
		{
		$("input").blur(function()
			{
			var formElementId = $(this).parent().prev().find('label').attr('for');
                             
                        doValidation(formElementId);   
                  
		});
	});
function doValidation(id)
{
    if (window.location.pathname=='/index')
        {
            var url = window.location+'/ajaxform'
        }
    else if (window.location.pathname=='/registration')
       {
           var url = window.location+'/ajaxform'
       }
    else if (window.location.pathname=='/')
           {
        var url = window.location+'/index/ajaxform'
           }
    else
        {
    var url = window.location+'/ajaxform'
        }
    var data = {};
    $("input").each(function() {
           data[$(this).attr('name')] = $(this).val();
     });
     $.post(url,data,function(resp)
     {
        $("#"+id).parent().parent().find('.errors').remove();
        $("#"+id).parent().parent().append(getErrorHtml(resp[id], id));
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
    
}*/

//close status


$(document).ready(function(){
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
     
     
     /****** events page *******/
     $( "#createEvent_date" ).datepicker({dateFormat: 'dd/mm/yy'});
     
     $('#createEvent_shortDescription').val('eat pizza'); 
     $('#createEvent_location').val("Tony's Pizzeria");
     $('#createEvent_longDescription').val('At 7pm\n155 Main St.\nSan Francisco, CA 94333');
    
     $('#createEvent_longDescription, #createEvent_location, #createEvent_shortDescription').css({'color': '#bbb'}).focus(function(){
         $(this).css({'color': '#000'}).val('').unbind(event);
        });
        
        
       
        //registration page
      function BdOrange(nClass, rClass){
           
          $(nClass).focus(function(){
          $(this).addClass('change_border_color')
          $(this).addClass('removebg');
          $(rClass).addClass('remove_top_border');
          });
          $(nClass).blur(function(){
              if ($.trim(this.value) == '') { 
                  $(this).removeClass('removebg');
             }
               $(this).removeClass('change_border_color');
               $(rClass).removeClass('remove_top_border');
          });
       }
        BdOrange('#login #email', '#login #password');
        BdOrange('#login #password', '#login #password');
        BdOrange('#registration #email', '#registration #firstName');
        BdOrange('#registration #firstName', '#registration #lastName');
        BdOrange('#registration #lastName', '#registration #city');
        BdOrange('#registration #city', '');
        BdOrange('#registration #password', '#registration #password2');
        BdOrange('#registration #password2', '');
        
  //login page and registration remove bg
        
        function BgRemove(nClass) {
           //email 
           
            if($(nClass).val().length === 0)
            {
                    $(nClass).removeClass('removebg');
            }
           else {
               $(nClass).addClass('removebg');
           }
          
          }
          BgRemove('#email');
          BgRemove('#firstName');
          BgRemove('#lastName');
          BgRemove('#city');
});