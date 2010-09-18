<?php

require_once APPLICATION_PATH.'twitter/EpiCurl.php';
require_once APPLICATION_PATH.'twitter/EpiOAuth.php';
require_once APPLICATION_PATH.'twitter/EpiTwitter.php';

class Twitter extends EpiTwitter
{
    const CONSUMER_KEY = 'H1xFwXIVtUC6WI6S4WrQrg';
    const CONSUMER_SECRET = 'gB4owMNP3MULWJYtiIgXufKHmMOaKNoVYvdFobOAm4';

    public function __construct()
    {
        return parent::__construct(self::CONSUMER_KEY, self::CONSUMER_SECRET);
    }
}
