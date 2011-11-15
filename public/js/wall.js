var Wall = {
    postComment : function(options){
        if(!options.eid)
            return false;
	var message = $('#wall_comment').val();
	if(!message)
	    return false;   
        $.ajax({
            url:"/event/add/",
            data:{eid:options.eid,wall_comment:message},
            type:'POST',
            success:function(){
                Wall.refreshWall({eid:options.eid});
            }
        }
        );
    },
    deleteComment : function(options){
        if(!options.eid && !options.postId)
            return;
        $.ajax({
            url:"/event/delete/",
            data:{eid:options.eid,postid:options.postId},
            type:'GET',
            success:function(){
                Wall.refreshWall({eid:options.eid});
            }
        }
        );
    },
    refreshWall : function(options){
	$.ajax({
            url:"/event/ajax-wall-refresh",
            data:{eid:options.eid},
            type:'GET',
            success:function(results){
		$("#posts").empty();
                var wallposts = null;
		eval('wallposts='+results);
		for(var i = 0; i < wallposts.length;i++){
		   //alert("running" + wallpost.firstName);
		    var wallpost = wallposts[i];
		    var wallpost_template = $('.ajax_template .wallpost').clone();
			wallpost_template.find('.wall_image').append('<img height="50" width="50"src="/img/profile-pic/uid/' + wallpost.email+ '" />');
		    wallpost_template.attr('id',wallpost.postID);
		    wallpost_template.find('.wall_name').text(wallpost.firstName+' Says');
		    wallpost_template.find('.wall_text').text(wallpost.message);
		    if(wallpost.isPoster == true){
			//Wall.deleteComment({eid:\"{$eid}\",postId:\"{$postid}\"})
			var delete_template = $('.ajax_template .wallpost .delete_post').clone();
			delete_template.click(function() {
				Wall.deleteComment({eid:options.eid,postId:wallpost.postID});
			    }
			);
			wallpost_template.find('.wall_text').append(delete_template);
		    }
		    $('#posts').append(wallpost_template);
		    	
		}
		//eval('wallposts='+results);
              
            }
        })
    }
}

