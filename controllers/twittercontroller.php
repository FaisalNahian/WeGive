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
        if (!isset($_GET['oauth_token'])) throw new Exception();

        $twitter = new Twitter();
        $twitter->setToken($_GET['oauth_token']);  
        $token = $twitter->getAccessToken();  

        return $this->login_with_oauth($token->oauth_token, $token->oauth_token_secret);              
    }
    
    function login_with_oauth($token=NULL,$secret=NULL)
    {
        $twitter = new Twitter();
        $twitter->setToken("69655255-qD8uFEbkSclFVOkUaSE6IkluD3YbGlcxEJqwQTzOq", "nKnFwDDeI6lxUQZIONosSPWXbzZjAPaDfuKrMROdbo");
        
        $creds = $twitter->get('/account/verify_credentials.json');
        
        $user = User::find_by_twitter_id($creds->id);
        if (!$user) {
            $user = new User();
        }
        
        $user->twitter_id = $creds->id;
        $user->screen_name = $creds->screen_name;
        $user->profile_image_url = $creds->profile_image_url;
        
        $user->save();
    }
    
    // protected function update_profile(Twitter $twitter)
    // {
    //     
    //     $u->save();
    //     
    // }
    
    public function test()
    {
        $twitter = new Twitter();        
        $twitter->setToken($_COOKIE['oauth_token'], $_COOKIE['oauth_token_secret']);  
                
        $creds = $twitter->get('/account/verify_credentials.json');

        die('done');
    }
}
