<?php

class User extends Model
{
    static $has_many = array(
        array('follows'),
        array('challenges'),
        array('followers', 'class_name'=>'User',  'through'=>'follows'),
    );
    
    function twitter()
    {   
        if (!$this->twitter_oauth_token) return NULL;
        
        $twitter = new Twitter();        
        $twitter->setToken($this->twitter_oauth_token, $this->twitter_oauth_token_secret);  
     
        return $twitter;
    }
    
    function add_follower(User $follower)
    {
        $f = Follow::find_by_user_id_and_follower_id($this->id,$follower->id);
        if (!$f) {
            $f = new Follow();
            $f->user_id = $this->id;
            $f->follower_id = $follower->id;
            $f->save();
        }
        
        // foreach($this->follows as $f) {
        //     echo $f->follower_id."\n<br>";
        // }
    }
    
    public function has_active_challenge()
    {
        // this is completely fudged
        return $this->id%23==1 || $this->twitter_oauth_token;
    }
    
    public function followers_available()
    {
        return !!$this->twitter_oauth_token; 
    }
    
    private $followers;
    function get_followers()
    {
        if (null !== $this->followers) return $this->followers;
        
        if (!$this->followers_last_updated_date) {
            $twitter = $this->twitter();
            if ($twitter) $twitter->get_followers($this);
            
            $this->followers_last_updated_date = new DateTime();
            $this->save();
        }
        
        return $this->followers = User::find_by_sql("SELECT u.* FROM users u INNER JOIN follows f ON u.id = f.follower_id WHERE f.user_id = ?",array($this->id));
    }
    
}
