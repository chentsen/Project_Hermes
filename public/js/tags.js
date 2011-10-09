/**
 * 
 */
var Tags = {
	showTagInput:false,
	init:function(){
		var data;
		$.get('/tag/get-display',
			  function(results){
				  var stats = null;
				  eval('stats='+results);
				  $(".tag_input").autoSuggest(stats);
		});
	},
	fetchTagData:function(){
		
	},
	toggleDropDown:function(){
		if(!Tags.showTagInput){
			Tags.showTagInput = true;
			jQuery(".tag_input_wrapper").slideDown('slow');
		}
		else if(Tags.showTagInput){
			Tags.showTagInput = false;
			jQuery(".tag_input_wrapper").slideUp('slow');
		}
	}
		
}