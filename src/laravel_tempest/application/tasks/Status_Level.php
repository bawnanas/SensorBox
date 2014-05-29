<?php

// some kind of enumeration class
class Status_Level
{

    /** @const but can't a const an array in php, kinda silly*/
    private static $enum = array(
        0 => "OK", 
        1 => "C_N_C",
        2 => "WARNING",
        3 => "ALERT",
        4 => "CRITICAL"
    );

    public function as_number($name) 
    {
        try
        {
            return array_search($name, self::$enum);
        }
        catch( Exception $e )
        {
            Logger::get_instance()->log('ERROR: not found ' . $e->getMessage());
            throw $e;
        }
    }

    public function as_string($num) 
    {
        try
        {
            return self::$enum[$num];
        }
        catch( Exception $e )
        {
            Logger::get_instance()->log('ERROR: not found ' . $e->getMessage());
            throw $e;
        }
    }
}