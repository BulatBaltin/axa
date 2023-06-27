<?php

class Lesson_model_treatment extends Doxpart {
    function Structure() {

        $stru = [

            Field::Reference('lesson'),
            Field::Reference('model'),
            Field::Reference('student'),
            Field::Reference('treatment'), // can get several treatments from several students; so, there is a roll up into 1 entry later.
            Field::Decimal('cost'),

            Field::DateTime('date', 'DATE'),
            Field::DateTime('start'),
            Field::DateTime('finish'),
            Field::Integer('duration'), // ?

        ];

        return $this->addstruct($stru, parent::structure());
    }
}