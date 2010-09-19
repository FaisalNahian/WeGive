<?php

require_once "phptal/PHPTAL.php";
require_once "phptal/PHPTAL/FileSourceResolver.php";

class Template
{
    private static function outputHTTP(array $result)
    {
        if (isset($result['redirect'])) {
            // FIXME: sanitise
            header("Location: ".$result['redirect']);
            die();
        }
    }
    
    public static function output(array $result)
    {
        self::outputHTTP($result);
                
        if (!isset($result['template'])) {
            throw new Exception("No template?");
        }
        
        $base_path = 'templates/'.strtolower($result['controller_name']).'_'.$result['template'];
         
        if (file_exists($base_path.'.xhtml')) {
            self::outputTAL($result,$base_path.'.xhtml');
        } 
        else if (file_exists($base_path.'.php')) {
            self::outputPHP($result,$base_path.'.php');
        }
        else throw new Exception("No template $base_path");
    }
    
    private static function outputPHP(array $_result, $_path)
    {        
        extract($_result, EXTR_SKIP);
        
        require_once $_path;        
    }
    
    
    private static function outputTAL(array $result, $path)
    {
        $phptal = new PHPTAL();
        foreach($result as $k => $v) $phptal->set($k,$v);
        
        $layout = clone $phptal;
        $layout->setTemplate('templates/layout.xhtml');
        $phptal->setTemplate($path);
        $layout->content_phptal = $phptal;
        $layout->echoExecute();
    }
}