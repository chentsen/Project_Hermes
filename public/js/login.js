var Login = {
    logout:function(){
        $.ajax({
            url:'/index/logout/',
            data:{},
            success:function(data){
                //just try logging out twice for now, change to once later
                FB.logout(function(){
                    
                })
                window.location=data.redirect;
            }
        });
        
    }
    
}