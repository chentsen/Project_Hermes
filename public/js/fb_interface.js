window.fbAsyncInit = function() {
    FB.init({
        appId      : '276813252365802',
        status     : true, 
        cookie     : true,
        xfbml      : true,
        oauth      : true
    });
};
(function(d){
    var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
    js = d.createElement('script'); js.id = id; js.async = true;
    js.src = "//connect.facebook.net/en_US/all.js";
    d.getElementsByTagName('head')[0].appendChild(js);
}(document));
/*Bridge between Facebook SDK and PT */
var FBI = {
    authenticate:function(){
        FB.login(function(response) {
            if (response.authResponse) {
                           
                console.log('data was',response.authResponse);
                $.ajax({
                    type:'POST',
                    url:'/registration/fb-login',
                    data:{access_token:response.authResponse.accessToken,uid:response.authResponse.userID},
                    success:function(data){
                        data =  eval('(' + data + ')');
                        if(!data.fb_account_exists){
                            if(data.success){
                                console.log('Registration was successful!');
                            }else{
                                console.log('Registration failed! Showing remaining info dialog!');
                                $('.main_ajax_content').html(data.form);
                                
                                //redirect to page that uses session variable to show the remaining stuff still needed.
                            }
                        }else{
                            window.location = '/profile/';
                        }
                        
                        //redirect user and log them in
                    }
                })
                console.log('Welcome!  Fetching your information.... ');
                FB.api('/me', function(response) {
                    console.log('Good to see you, ' + response.name + '.');
                    
                });
            } else {
              console.log('User cancelled login or did not fully authorize.');
            }
        }, {scope: 'email'});
    }
    
}