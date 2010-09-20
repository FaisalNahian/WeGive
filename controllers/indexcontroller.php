<?php

class IndexController extends Controller
{
    function index()
    {
        return array(
            'hide_sidebar'=>true,
        );
    }
    
    /**
     * Name collision caused nomenclature crime.
     * 
     * This is method for page that calls actual logout method
     */
    function log_out()
    {
        $this->logout();
        return array(
            'redirect'=>'/',
        );
    }
    
    /**
     * 404 page
     */
    function not_found($e = NULL)
    {
        return array(
            'template'=>'not_found',
            'exception'=>$e,
        );
    }
    
    /**
     * Site-wide last-resort exception handler
     */
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
