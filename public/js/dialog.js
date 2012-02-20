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
		}else if(options.returnedHTML){
			jQuery(dialogModal).append(options.returnedHTML);
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
		
		
		
		/*$('.dialogs #createEvent_longDescription, #createEvent_location, #createEvent_shortDescription').css({'color': '#bbb'}).focus(function(){
		    $(this).css({'color': '#000'}).val('');//.unbind(event);
		   });*/
		
		$('.dialogs #createEvent_shortDescription').defaultText({text: 'Eat Pizza', event: true});
		$('.dialogs #createEvent_location').defaultText({text: 'Tony\'s Pizzeria', event: true});
		$('.dialogs #createEvent_longDescription').defaultText({text: 'At 7pm\n155 Main St.\nSan Francisco, CA 94333', longdesc: true});
		$('.dialogs .invisible').hide();
	},
	loadLoginData:function(){
		
		
				
		 $('.dialogs #email').defaultText({text: 'Email'});
		 $('.dialogs #firstName').defaultText({text: 'First Name'});
		 $('.dialogs #lastName').defaultText({text: 'Last Name'});
		 $('.dialogs #city').defaultText({text: 'City'});
		 $('.dialogs #password').defaultText({text: 'Password'});
		 $('.dialogs #password2').defaultText({text: 'Password Again'});
		 $('.dialogs #betakey').defaultText({text: 'Beta Key'});
	},
	loadBetaData:function(){
		
		 $('.dialogs #city').defaultText({text: 'City'});
		 $('.dialogs #betakey').defaultText({text: 'Beta Key'});
	},
	doValidate:function() {
			
					$("input").blur(function()
						{
						 formid = $(this).get(0).form.id;
						 
						var formElementId = $(this).attr('id');
						doValidation(formElementId, formid);   
							  
					});
			
				
			
	},
	showAdvanced:function(){
		
					$('.invisible').toggle();
					if ($('.show-advanced a').html() == 'Include more details') {
							$(".show-advanced a").html('Include less details');
					} else {
							$(".show-advanced a").html('Include more details');
					}
					//} 				
			//not done
			
			
	}
};