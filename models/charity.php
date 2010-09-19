<?php

class Charity extends Model
{
    static $has_many = array(
        array('challenges'),
    );

    public function missionfish_invoice_id()
    {
        return "|>".$this->missionfish_id."<| Donation to ".$this->name." via We Give and Mission Fish";
    }

}
