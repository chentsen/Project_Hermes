$(function()
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
    
}

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
});