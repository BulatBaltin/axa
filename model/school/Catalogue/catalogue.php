<?php

class Catalogue extends dmModel {

    function __construct()
    {
        $this->db_prefix = self::prefix(); 
    }
    static function prefix() { return 'abc_';}
    function structure() {
        $structure = [
            0 => Field::id(),
            1 => Field::string('name'),

            100 => Field::Int('sort'),
            102 => Field::DateTime('created_at'),
            103 => Field::DateTime('updated_at')
        ];
        return $structure;
    }  
}
