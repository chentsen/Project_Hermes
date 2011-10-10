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
                    //tags disabled
		    $('.tags').click(function(){
		                $(this).toggleClass('tag_disable');
                                 $.cookie('tag_disable','permanent');
                                });
                               
                             var tag_disable = $.cookie('tag_disable');
                             
                             if(tag_disable == 'permanent') {
                                 $('.tags').toggleClass('');
                             };
                            
		            $('.close_tag').click(function(){
		             
                               
		            });


		            $('.close_tags a').click(function(){
		                $(this).addClass('tag_remove');
		            });



				  $(".tag_input").autoSuggest(stats,
						  {startText:"Enter tag",emptyText:"",neverSubmit:true});

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
	},
	toggleTag:function(tagID){
		 $("#"+tagID).toggleClass('tag_disable');
	},
	removeTag:function(tagID){
		
	},
	refreshTags:function(results){
		if(results.length > 0){
			 var stats = null;
			 eval('stats='+results);
			 //alert(stats);
			 var tag_base = $('.tags_base.ajax').clone();
			 for(var i in stats){
				 var tag = stats[i];
				//alert(tag);			 
				var tag_id = "tag_"+tag;
				var tag_html = jQuery(".ajax_content .tags").clone();
				$(tag_html).attr('id',"tag_"+tag);
				$(tag_html).attr('onclick',"Tags.toggleTag('"+tag_id+"')");
				$(tag_html).find(".close_tag").attr('onclick',"Tags.removeTag('"+tag_id+"')");
				$(tag_html).find(".tag_text").text(tag);
				$(tag_base).append(tag_html);
			 }
			 $(tag_base).attr('class','tags_base');
			 $(".tags_area").empty();
			 $(".tags_area").append(tag_base);
		}
		//refreshes tags using results;
	}
	
		
}