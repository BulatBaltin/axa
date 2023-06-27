<?php

class Model_treatment_type extends Catalogue {
    function Relation()
    {
        return [];
    }

    function structure()
    {
        $stru = [
            Field::Reference('model'),
            Field::Reference('treatment_type'),
        ];
        return $this->addstruct($stru, parent::Structure());
    }


}