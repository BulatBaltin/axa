<?php

class Employee extends Catalogue {

    // auxiliary personnel
    function Structure() {
    
        $stru = [
            Field::Reference('person'),
            Field::Reference('school'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

}