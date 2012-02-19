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
                }else{
                    $().toastmessage('showSuccessToast', "There was an problem completing your request.");
                }
            }
        })
    }
    
}