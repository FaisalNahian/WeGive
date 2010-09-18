<?php

require_once APPLICATION_PATH.'php-activerecord/ActiveRecord.php';

class Services
{
    function __construct()
    {                
        ActiveRecord\Config::initialize(function($cfg) {
            $conn = array(
                'development' => Services::ARURL,
            );
            $cfg->set_model_directory('models');
            $cfg->set_connections($conn);
            $cfg->set_default_connection('development');
        });
    }
    
    public function session()
    {
        if (!$this->session) {
            $this->session = new Session();
        }
        return $this->session;
    }
    
//    const DSN = 'pgsql:host=localhost;port=5432;dbname=wegive;user=wegive'; // FIXME
    const ARURL = 'pgsql://wegive@localhost:5432/wegive'; // FIXME
    
    private static function db_connect()  // FIXME: doesn't belong here
    {
        return new MyPDO(self::DSN);
    }
}
