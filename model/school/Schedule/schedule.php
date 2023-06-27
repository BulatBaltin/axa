<?php

class Schedule extends dmModel {
// time slots
function __construct()
{
    $this->db_prefix = self::prefix(); 
}
static function prefix() { return 'plan_';}
function structure()
{
    $stru = [
        0=> Field::Id(),
        1=> Field::string('type'),
        3=> Field::DateTime('date', 'DATE'),
        4=> Field::DateTime('start'),
        5=> Field::DateTime('finish'),
        6=> Field::Int('duration'),

        100=> Field::DateTime('created_at'),
        101=> Field::DateTime('updated_at'),
    ];
    return $stru;
}


}