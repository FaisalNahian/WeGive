<?php

class Services
{
    protected $db;
    
    public function db()
    {
        if (!$this->db) {
            $this->db = $this->db_connect();
        }
        return $this->db;
    }
    
    public function session()
    {
        if (!$this->session) {
            $this->session = new Session();
        }
        return $this->session;
    }
    
    const DSN = 'pgsql:host=localhost;port=5432;dbname=wegive;user=wegive'; // FIXME
    
    private static function db_connect()  // FIXME: doesn't belong here
    {
        return new MyPDO(self::DSN);
    }
}