<?php

class Payment extends Catalogue {
    function Structure() {
    
        $stru = [
            Field::Int('payments'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

}