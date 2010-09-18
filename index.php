<?php

define("APPLICATION_PATH",dirname(__FILE__)."/");

set_include_path(APPLICATION_PATH."lib/" . PATH_SEPARATOR . 
                 APPLICATION_PATH."controllers" . PATH_SEPARATOR . 
                 get_include_path());

spl_autoload_register();

$services = NULL;
try {
    $services = new Services();
    $result = Controller::run($services,$_SERVER['REQUEST_URI']);

    $t = new Template();
    $t->output($result);
}
catch(Exception $e)
{
    $t = new Template();
    $t->output(Controller::run_controller($services,'index','internal_error',array($e)));
}
