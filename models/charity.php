<?php

class Charity extends Model
{
    static $has_many = array(
        array('challenges'),
    );
//    public $name, $description, $missionfish_id, $image_url;
}
