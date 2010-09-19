<?php

define("APPLICATION_PATH",dirname(__FILE__)."/");

set_include_path(APPLICATION_PATH."models/" .  PATH_SEPARATOR .
                 APPLICATION_PATH."lib/" . PATH_SEPARATOR . 
                 APPLICATION_PATH."controllers" . PATH_SEPARATOR . 
                 APPLICATION_PATH."paypal/lib/" . PATH_SEPARATOR . 
                 "/usr/lib/php/" . PATH_SEPARATOR . 
                 get_include_path());

spl_autoload_register();

require_once "helpers.php";

$services = NULL;
try {
    $services = new Services();
    Template::output(Controller::run($services,$_SERVER['REQUEST_URI']));
}
catch(Exception $e) {
    Template::output(Controller::run_controller($services,'index','internal_error',array($e)));
}
