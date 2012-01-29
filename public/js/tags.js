/**
 * 
 */     
var Tags = {
	showTagInput:false,
	tagData:null,
	init:function(){
		var data;
		$.get('/tag/get-display',
			  function(results){
				  
				  var stats = null;
				  eval('stats='+results);
				  Tags.tagData = stats;
				  $(".tag_input").autoSuggest(Tags.tagData,
						  {startText:"",emptyText:"",neverSubmit:true});
		});
	},
	fetchTagData:function(){
		
	},
	toggleDropDown:function(){
		if(!Tags.showTagInput){
			Tags.showTagInput = true;
			jQuery(".tag_input_wrapper").slideDown('fast');
		}
		else if(Tags.showTagInput){
			Tags.showTagInput = false;
			jQuery(".tag_input_wrapper").slideUp('fast');
		}
	},
	toggleTag:function(tagID){
		$("#"+tagID).toggleClass('tag_disable');
		$.get('/tag/toggle-tag',
				{tag:$("#"+tagID+" .tag_text").text()}
		);
		
	},	
	removeTag:function(tagID){
		jQuery.get('/tag/delete-tag',
				{tag:$("#"+tagID+" .tag_text").text()}
		)
		$("#"+tagID).remove();
		
	},
	refreshTags:function(results){
		if(results.length > 0){
			 var stats = null;
			 eval('stats='+results);
			 //alert(stats);
			 var tag_base = $('.tags_base.ajax').clone();
			 for(var i in stats){
				 var tag = stats[i].tagName;
				 var tagReplaced = tag.replace(/ /gi,"_");
				//alert(tag);			 
				var tag_id = "tag_"+tagReplaced;
				//alert(tag_id);
				var tag_html = jQuery(".ajax_tags_wrap").clone();
				$(tag_html).find(".tags").attr('id',tag_id);
				if(!stats[i].enabled)
					$(tag_html).find(".tags").toggleClass('tag_disable');
				$(tag_html).find(".tag_text").text(tag);
				tag_html = $(tag_html).children();
				$(tag_base).append(tag_html);
			 }
			 $(tag_base).attr('class','tags_base');
			 
			 $(".tags_area").empty();
			 $(".tags_area").append(tag_base);
			 for(var i in stats){
				 var tag = stats[i].tagName.replace(/ /gi,"_");
				//alert(tag);			 
			    $(".tags_base .tags#tag_" + tag).data('tag_id', tag).click(function(){Tags.toggleTag("tag_"+$(this).data('tag_id'));});
				 $(".tags_base .tags#tag_"+tag).find(".close_tag").data('tag_id', tag).click(function(){Tags.removeTag("tag_"+$(this).data('tag_id'))});
			 } 
			 
			 //Tags.toggleDropDown();
                         //let people continuously add by pressing enter
                         
		}
		//refreshes tags using results;
	}
	
		
}