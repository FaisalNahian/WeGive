<?php

class MyPDO extends PDO
{
    function q(/*varargs */)
    {
        $args = func_get_args();
        $q = array_shift($args);
        
        $st = $this->prepare($q);
        if (!$st->execute($args)) throw new Exception("Query failed: $q\n".implode("\n",$this->errorInfo()));
        return $st;
    }   
}
