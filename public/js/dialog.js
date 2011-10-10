/**
 * Dialog framework for loading of dialogs.
 */
var Dialog = {
		
	showDialog:function(options){
		//either the action or the existing div
		var dialogModal = $(".header_ajax .modalWindow").clone();
		if(options.elementSelector){
			var content = jQuery(options.elementSelector).clone();
			jQuery(dialogModal).append(content);
		}
		//$.blockUI({message:""});
		jQuery(".dialogs").append(dialogModal);
		jQuery(".dialogs").show();
	},
	hideDialog:function(){
		jQuery(".dialogs").empty();
		jQuery(".dialogs").hide();
	}
};