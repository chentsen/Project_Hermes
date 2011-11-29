/**
 * Dialog framework for loading of dialogs.
 */
var Dialog = {
	showDialog:function(options){
		//either the action or the existing div
		var dialogModal = $(".footer_ajax .modalWindow").clone();
		if(options.elementSelector){
			var content = jQuery(options.elementSelector).clone();
			jQuery(dialogModal).append(content);
		}
		else if(options.renderAction){
			$.post(options.renderAction,function(results){
				var content = results;
				jQuery(dialogModal).append(content);
			});
		}
		$(".modalBackground").show();
		$(".modalBackground").block({message:''});
		jQuery(".dialogs").append(dialogModal);
		jQuery(".dialogs").show();
		if(options.func){
			var func = options.func;
			func();
		}
		//extraneous code for datepicker
		   
		
	},
	hideDialog:function(){
		jQuery(".dialogs").empty();
		jQuery(".dialogs").hide();
		$(".modalBackground").unblock({message:""});
		$(".modalBackground").fadeOut("slow");
	},
	loadEventDatePicker:function(){
		//throw away function-- need to bring this into datePicker proper
		$(".dialogs #createEvent_date").attr("id","createEvent_date_active")
		$(".dialogs #createEvent_date_active" ).datepicker({dateFormat: 'dd/mm/yy', minDate: +0});
		$("#ui-datepicker-div").css("z-index", "9999");
		$('.dialogs #createEvent_shortDescription').val('eat pizza'); 
		$('.dialogs #createEvent_location').val("Tony's Pizzeria");
		$('.dialogs #createEvent_longDescription').val('At 7pm\n155 Main St.\nSan Francisco, CA 94333');
		$('.dialogs #createEvent_longDescription, #createEvent_location, #createEvent_shortDescription').css({'color': '#bbb'}).focus(function(){
		    $(this).css({'color': '#000'}).val('');//.unbind(event);
		   });
	},
	loadLoginData:function(){
		
		function BgRemover(nClass) {
				$(nClass).focus(function(){
						$(nClass).addClass('removebg');
				});
				
						$(nClass).blur(function(){
						if ($.trim(this.value) == '')
								{
								$(nClass).removeClass('removebg');	
								} 
								});
				}         
				BgRemover('.dialogs #email');
          BgRemover('.dialogs #firstName');
          BgRemover('.dialogs #lastName');
          BgRemover('.dialogs #city');
		  BgRemover('.dialogs #password');
		  BgRemover('.dialogs #password2');
          BgRemover('.dialogs #betakey');
	},
		doValidate:function() {
				
						$("input").blur(function()
							{
							 formid = $(this).get(0).form.id;
							 
							var formElementId = $(this).attr('id');
							doValidation(formElementId, formid);   
								  
						});
				
					
				
		}
};