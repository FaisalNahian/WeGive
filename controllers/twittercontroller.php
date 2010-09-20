<?php

class TwitterController extends Controller
{
    /**
     * Redirects to Twitter
     */
    function login()
    {
        $t = new Twitter();
        return array(
            'redirect'=>$t->getAuthenticateUrl(),
        );
    }
    
    /**
     * Good news from Twitter
     */
    function callback()
    {
        if (!isset($_GET['oauth_token'])) throw new Exception();

        $twitter = new Twitter();
        $twitter->setToken($_GET['oauth_token']);  
        $token = $twitter->getAccessToken();  

        return $this->login_with_oauth($token->oauth_token, $token->oauth_token_secret);              
    }
    
    /**
     * Figure out identity of the Twitterrer and log them in
     */
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
        
//        return $this->return_to();  // since return_to saves any stupid URL, this causes redirect loops
        
        return array(
            'redirect'=>'/',
        );
    }
}
