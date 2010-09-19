<?php

class Challenge extends Model
{
    static $belongs_to = array(
        array('user'),
        array('charity'),
    );
    
    
    public function goal_pounds()
    {
        return to_pounds($this->matching_upper_limit_pence);
    }

    public function match_pounds()
    {
        return to_pounds($this->matching_upper_limit_pence * $this->matching_percentage/100);
    }
    
    public function match_per_pence($value_pence)
    {
        return to_pounds($value_pence*$this->matching_percentage/100);
    }
    
    public function base_donation_pounds()
    {
        return to_pounds($this->base_donation_pence);
    }
}

