<?php

class Model extends ActiveRecord\Model
{
    public static function db()
    {
        return static::table()->conn->connection;
    }
}
