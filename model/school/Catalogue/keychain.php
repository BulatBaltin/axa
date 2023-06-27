<?php

class Keychain extends Catalogue {

    function Structure() {
    
        $stru = [
            Field::Text('property'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

}