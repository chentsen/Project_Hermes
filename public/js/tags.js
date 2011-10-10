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


                           
                            /*
   
   
     $('.loginonce').click(function(){
            $(this).hide(2000, function(){
            $(this).remove();
            });
            $.cookie('loginOnce','removed');
     });
     
     var loginOnce = $.cookie('loginOnce')
     
     if(loginOnce == 'removed') {
         $('.loginonce').hide();
     }
     
     */
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