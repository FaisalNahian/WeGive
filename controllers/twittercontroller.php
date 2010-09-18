<?php

class TwitterController extends Controller
{
    function login()
    {
        return array(
            'redirect'=>Twitter::create()->getAuthenticateUrl(),
        );
    }
    
    function callback()
    {
        if (!isset($_GET['oauth_token'])) return array(
            'redirect'=>'/twitter/login',
        );
        
        $twitterObj = new Twitter();
        $twitterObj->setToken($_GET['oauth_token']);  
        $token = $twitterObj->getAccessToken();  
        $twitterObj->setToken($token->oauth_token, $token->oauth_token_secret);  
        setcookie('oauth_token', $token->oauth_token);  
        setcookie('oauth_token_secret', $token->oauth_token_secret);
        
    }
}
