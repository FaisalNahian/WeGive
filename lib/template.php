<?php

require_once "phptal/PHPTAL.php";
require_once "phptal/PHPTAL/FileSourceResolver.php";

/**
 * Loads PHP or PHPTAL template for a result
 * 
 * @todo too much static
 */
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
    
    /**
     * Echoes page for the result. Looks for templates/*_*.{php,xhtml}
     * 
     * @param array $result has magic values:
     *  * template
     *  * controller_name
     *  * redirect
     * 
     * The rest is interpreted as variables in template.
     */
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
    
    /**
     * uses PHP file as template
     */
    private static function outputPHP(array $_result, $_path)
    {        
        extract($_result, EXTR_SKIP);
        
        require_once $_path;        
    }
    
    /**
     * Executes PHPTAL template and wraps its result in layout.xhtml
     */
    private static function outputTAL(array $result, $path)
    {
        $phptal = new PHPTAL();
        foreach($result as $k => $v) $phptal->set($k,$v);
        
        $layout = clone $phptal; // lazy hack
        $layout->setTemplate('templates/layout.xhtml');
        $phptal->setTemplate($path);
        $layout->content_phptal = $phptal;
        $layout->echoExecute();
    }
}