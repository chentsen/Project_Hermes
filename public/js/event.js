var Event = {
    processJoinRequest:function(eid,uid,response){
        $.ajax({
            url:'/event/response/response/'+response+'/eid/'+eid+'/uid/'+uid,
            data:{},
            type:'GET',
            success:function(data){
                if(data.success){
                    $('.waiting-item-'+uid).hide();
                    $().toastmessage('showSuccessToast', data.msg);
                    var returnAjax = $('.attending-list-ajax .attending-item').clone();
                    returnAjax.find('.attending-item').addClass('attending-item-'+data.uid);
                    returnAjax.find('img').attr('src','/img/profile-pic/uid/'+data.uid);
                    returnAjax.find('a').attr('href','/profile/public/uid/'+data.uid);
                    returnAjax.find('.attending-details').text(data.firstName+' is attending.');
                    $('.attendingList').append(returnAjax);
                }else{
                    $().toastmessage('showSuccessToast', "There was an problem completing your request.");
                }
            }
        })
    },
    
}