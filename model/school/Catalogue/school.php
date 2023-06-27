<?php

class School extends Catalogue {
//  Physical address
//  Commercial capacity per room
    private $rooms;       // Collection of Room-s
    private $materials;   // 

    function structure()
    {
        $stru = [
            Field::string('address'),
            Field::string('phone')
        ];
        
        return $this->addstruct($stru, parent::structure());

    }



}