<?php

class Follow extends Model
{
    static $belongs_to = array(
        array('user'),
        array('follower', 'class_name'=>'User'),
    );
    
}
