<?php

class IndexController extends Controller
{
    function index()
    {
        return array(
            'meh'=>$this->db()->q("SELECT * FROM users")->fetchAll(),
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
        if ($e instanceof PageNotFoundException) return $this->not_found();
        
        return array(
            'exception'=>$e,
        );
    }
}
