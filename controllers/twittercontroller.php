<?php

class TwitterController extends Controller
{
    function login()
    {
        $t = new Twitter();
        return array(
            'redirect'=>$t->getAuthenticateUrl(),
        );
    }
    
    function callback()
    {
        if (!isset($_GET['oauth_token'])) throw new Exception();

        $twitter = new Twitter();
        $twitter->setToken($_GET['oauth_token']);  
        $token = $twitter->getAccessToken();  

        return $this->login_with_oauth($token->oauth_token, $token->oauth_token_secret);              
    }
    
    protected function login_with_oauth($token,$secret)
    {
        $twitter = new Twitter();
        $twitter->setToken($token, $secret);
        
        $creds = $twitter->get('/account/verify_credentials.json');
        
        $user = $twitter->user_from_response($creds);
        
        $user->twitter_oauth_token = $token;
        $user->twitter_oauth_token_secret = $secret;
        
        $user->save();
        
        $this->login_user($user);  
        
        $twitter->update_friends_if_needed($user);
        
        return $this->return_to();
    }
        
    
    function test()
    {
        $user = $this->logged_in_user();
        
        $f = User::find_by_id(12);
        
        $user->add_follower($f);
    }
}
