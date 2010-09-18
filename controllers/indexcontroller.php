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
    
    function not_found()
    {
        return array(
            'template'=>'not_found',
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
        
        if ($e instanceof PageNotFoundException) return $this->not_found();
        
        return array(
            'exception'=>$e,
        );
    }
}
