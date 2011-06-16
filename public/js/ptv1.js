$(function()
		{
			$("input").blur(function()
			{
				var formElementId = $(this).get(0).name;
				//find('label').attr('name'))
				doValidation(formElementId);
				console.log($(this).attr('name'));
			});
		});
function doValidation(id)
	{
		var url='/index/validateform'
		var data = {};
		$("input").each(function()
		{		
			data[$(this).attr('name')] = $(this).val();
		});
		$.post(url,data,function(resp)
		{
			console.log(resp);
			$("#"+id).parent().find('.errors').remove();
			$("#"+id).parent().append(getErrorHtml(resp[id], id))
		},'json');
	});
function getErrorsHtml (formerrors, id)
	{
		var o = '<ul id="errors-'+id+'" class="errors"';
		for(errorKey in formErrors)
			{
				o += '<li>' + formErrors[errorKey] + '</li>';
			}
		o += '</ul>'
			return o;
	});