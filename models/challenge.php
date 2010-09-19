<?php

class Challenge extends Model
{
    static $belongs_to = array(
        array('user'),
        array('charity'),
    );
    
    public function to_pounds($pence)
    {
        return '£'.round($pence/100,2);
    }
    
    public function goal_pounds()
    {
        return $this->to_pounds($this->matching_upper_limit_pence);
    }

    public function match_pounds()
    {
        return $this->to_pounds($this->matching_upper_limit_pence * $this->matching_percentage/100);
    }
    
    public function match_per_pence($value_pence)
    {
        return $this->to_pounds($value_pence*$this->matching_percentage/100);
    }
    
}

