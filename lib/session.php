<?php

class Session
{
    function __construct()
    {
        session_start();
    }
    
    function __get($arg)
    {
        return $this->get($arg);
    }
    
    function __get($key, $default = NULL)
    {
        if (isset($_SESSION[$key])) return $default;
        return $_SESSION[$key];
    }
    
    function __set($k,$v)
    {
        $this->set($k,$v);
    }
    
    function set($k,$v)
    {
        $_SESSION[$k]=$v;
    }
}