<?php

class IndexController extends Controller
{
    function index()
    {
        $users = User::find('all');
        
        return array(
            'users'=>$users,
        );
    }
    
    function log_out()
    {
        $this->logout();
        return array(
            'redirect'=>'/',
        );
    }
    
    function not_found($e = NULL)
    {
        return array(
            'template'=>'not_found',
            'exception'=>$e,
        );
    }
    
    function internal_error($e = NULL)
    {
        if ($e instanceof EpiTwitterNotAuthorizedException || 
            $e instanceof EpiOAuthUnauthorizedException ||
            $e instanceof LoginException) {
                
            $this->set_return_to($_SERVER['REQUEST_URI']); // FIXME: use uri set in controller?
            
            return array(
                'redirect'=>'/twitter/login',
            );
        }
        
        if ($e instanceof PageNotFoundException) return $this->not_found($e);
        
        return array(
            'exception'=>$e,
        );
    }
}
