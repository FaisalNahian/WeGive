<?php

/**
 * I don't like spamming every anonymous user with pointless PHPSESSID cookie
 * and I don't like session_start sprinkled all over the place.
 */
class Session
{
    /**
     * @todo start session lazily
     */
    function __construct()
    {
        session_start();
    }
    
    function __get($arg)
    {
        return $this->get($arg);
    }
    
    function get($key, $default = NULL)
    {
        if (!isset($_SESSION[$key])) return $default;
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