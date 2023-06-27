<?php

class Student extends Catalogue {
    function structure()
    {
        $stru = [
            Field::Reference('person'),
            Field::Reference('student_request'),
            Field::Reference('course'),
            Field::string('status'),
            Field::Text('info'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

}