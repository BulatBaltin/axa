<?php

class Student_request extends Register {
    function Structure() {

        $stru = [
            Field::Reference('person'),
            Field::Reference('course'),

            Field::DateTime('date'),
            Field::string('status'), // ?

        ];

        return $this->addstruct($stru, parent::structure());
    }

}