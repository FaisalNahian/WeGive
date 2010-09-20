<?php

/**
 * This is not really a model, but PHP ActiveRecord doesn't implement many-to-many. Ugh.
 */
class Follow extends Model
{
    static $belongs_to = array(
        array('user'),
        array('follower', 'class_name'=>'User'),
    );
    
}
