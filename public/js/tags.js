/**
 * 
 */
var Tags = {
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
		
	}
		
}