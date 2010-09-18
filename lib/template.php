<?php

class Template
{
    private function outputHTTP(array $result)
    {
        if (isset($result['redirect'])) {
            // FIXME: sanitise
            header("Location: ".$result['redirect']);
            die();
        }
    }
    
    function output(array $result)
    {
        $this->outputHTTP($result);
                
        if (!isset($result['template'])) {
            throw new Exception("No template?");
        }
        
        $path = 'templates/'.strtolower($result['controller_name']).'_'.$result['template'].'.php';
        
        if (!file_exists($path)) {
            throw new Exception("No template $path");
        }
        
        extract($result,EXTR_SKIP);
        
        require_once $path;
        die();
    }
}