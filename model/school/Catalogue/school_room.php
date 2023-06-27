<?php

class School_room extends Catalogue {
    function structure() {
    
        $stru = [
            Field::Reference('school'),
            Field::Int('number'),
            Field::Int('max_capacity'),
        ];
        
        return $this->addstruct($stru, parent::structure());
    }

}