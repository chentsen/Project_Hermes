
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
                        //if(data){
                          //  data =  eval('(' + data + ')');
                        //}
                        if(!data.fb_account_exists){
                            if(data.success){
                                console.log('Registration was successful!');
                            }else if(data.form){
                                console.log('Registration failed! Showing remaining info dialog!');
                                Dialog.showDialog({returnedHTML:data.form});
                                Dialog.loadBetaData();
 //                               $('.main_ajax_content').html(data.form);
                                
                                //redirect to page that uses session variable to show the remaining stuff still needed.
                            }else{
                                $('#flashMessages ul').append('<li>An account is already associated with this email address. Please login with your email and password! </li>');
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