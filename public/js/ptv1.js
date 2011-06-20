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
    var url = '/registration/ajaxform'
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