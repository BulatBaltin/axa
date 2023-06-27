<?php

use Google\Service\Compute\Reference;

class Doxpart extends dmModel {
    function __construct()
    {
        $this->db_prefix = self::prefix(); 
    }
    static function prefix() { return 'dox_';}
    function structure()
    {
        $stru = [
            0=> Field::Id(),

            100=> Field::DateTime('created_at'),
            101=> Field::DateTime('updated_at'),
        ];
        return $stru;
    }
    
}