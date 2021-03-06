<?php

require_once APPLICATION_PATH.'twitter/EpiCurl.php';
require_once APPLICATION_PATH.'twitter/EpiOAuth.php';
require_once APPLICATION_PATH.'twitter/EpiTwitter.php';

/**
 * OAuth API wrapper of a wrapper of a wrapper.
 */
class Twitter extends EpiTwitter
{
    const CONSUMER_KEY = 'H1xFwXIVtUC6WI6S4WrQrg';
    const CONSUMER_SECRET = 'gB4owMNP3MULWJYtiIgXufKHmMOaKNoVYvdFobOAm4';

    public function __construct()
    {
        return parent::__construct(self::CONSUMER_KEY, self::CONSUMER_SECRET);
    }
    
    /**
     * Reads object from Twitter API and loads/creates User for it.
     */
    public function user_from_response($creds)
    {
        $user = User::find_by_twitter_id($creds->id);
        if (!$user) {
            $user = new User();
        }
        
        $user->twitter_id = $creds->id;
        $user->screen_name = $creds->screen_name;
        $user->profile_image_url = $creds->profile_image_url;
        //$user->description = $creds->bio;
        
        return $user;
    }
    
    /**
     * Read followers of the given user from the API
     * 
     * @todo needs to remove users who stopped following     
     * @todo needs to support cursor
     */
    public function get_followers(User $user)
    {       
        $batch_size = 5;
        
        $followers = $this->get('/followers/ids.json',array('cursor'=>-1,'user_id'=>$user->twitter_id));

        if (isset($followers, $followers->ids)) {

            $ids=array();
            foreach($followers->ids as $follower) {
                $ids[] = $follower;
                if (count($ids) > $batch_size) {
                    $this->lookup_followers($user,$ids);
                    $ids=array();
                }                
            }
            $this->lookup_followers($user, $ids);
        }
    }
    
    /**
     * Reads info (screen_name, etc.) for given IDs, creates users and adds them as followers
     */
    protected function lookup_followers(User $user, array $ids)
    {
        $info = $this->get('/users/lookup.json', array('user_id'=>implode(',',$ids)));
        
        if ($info) {
            foreach($info as $userinfo) {
                $follower = $this->user_from_response($userinfo);
                $follower->save();
                
                $user->add_follower($follower);
            }
        }
    }
    
}
