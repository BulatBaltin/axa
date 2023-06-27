<?php

class Material extends Catalogue {

    // Links: program_material 
    function Relation() {
        return ['program_material'];
    }
    function structure()
    {
        $stru = [
            Field::Decimal('cost'),
        ];
        return $this->addstruct($stru, parent::Structure());
    }

}