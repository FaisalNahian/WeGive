<?php

/**
 * This is starting point of the app. All page requests should go through this file.
 */

define("APPLICATION_PATH",dirname(__FILE__)."/");

/*
 * Classes are loaded via standard PHP autoloader from these directories: 
 */
set_include_path(APPLICATION_PATH."models/" .  PATH_SEPARATOR .
                 APPLICATION_PATH."lib/" . PATH_SEPARATOR . 
                 APPLICATION_PATH."controllers" . PATH_SEPARATOR . 
                 APPLICATION_PATH."paypal/lib/" . PATH_SEPARATOR . 
                 "/usr/lib/php/" . PATH_SEPARATOR . 
                 get_include_path());

spl_autoload_register();

// AKA file for stuff I had no idea where to put
require_once "helpers.php";

$services = NULL;
try {
    // Pretend it's dependency injection
    $services = new Services();
    
    // and this is kinda like MVC
    Template::output(Controller::run($services,$_SERVER['REQUEST_URI']));
}
catch(Exception $e) {
    Template::output(Controller::run_controller($services,'index','internal_error',array($e)));
}
