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
		$(document).ready(function(){
		    $('.tags').click(function(){
		                $(this).toggleClass('tag_disable');

		            });
		            $('.close_tag').click(function(){
		                $(this).removeClass('tag_disable');

		            });


		            $('.close_tags a').click(function(){
		                $(this).addClass('tag_remove');
		            });

		     
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