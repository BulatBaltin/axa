<?php

class Teacher extends Catalogue {

    function structure()
    {
        $stru = [
            Field::Reference('person'),
            Field::Reference('qualification'),
        ];
        return $this->addstruct($stru, parent::structure());

    }


}