<?php

/**
 * 159.339 Internet Programming Assignment 2
 * Team Student 1: Pei Wang      (15374675)
 * Team Student 2: Shenchuan Gao (16131180)
 * Team Student 3: Yunseong Choi (13135649)
 */

/**
 * Database Connection Class
 * Provides database connection function
 */
class Db
{
    private function __construct()
    {}

    private function __clone()
    {}

    /**
     * Connect Database and Return Database Connection Object
     */
    public static function connect()
    {
        $database_server = "localhost";
        $database_name = "a2";
        $database_user = "a2";
        $database_password = "a2";
        
        // connect database
        $db = new mysqli($database_server, $database_user, $database_password, $database_name);
        $db->autocommit(FALSE);
        return $db;
    }
}


