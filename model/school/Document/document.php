<?php

class Document extends dmModel {
    function __construct()
    {
        $this->db_prefix = self::prefix(); 
    }
    static function prefix() { return 'doc_';}
    function structure()
    {
        $stru = [
            0=> Field::Id(),
            1=> Field::String('type', 64),
            2=> Field::String('doc_number', 64),
            3=> Field::DateTime('doc_date'),
            4=> Field::String('status', 64),

            100=> Field::DateTime('created_at'),
            102=> Field::Int('user_created'),
            104=> Field::DateTime('updated_at'),
            106=> Field::Int('user_updated'),
        ];
        return $stru;
    }
}