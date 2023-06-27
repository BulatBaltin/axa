<?php

class Customer extends Catalogue {

    function Structure() {
    
        $stru = [
            Field::Reference('person'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

}