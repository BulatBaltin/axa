<?php

class Student_product extends Register {

    function Structure() {

        $stru = [
            Field::Reference('student'),
            Field::Reference('course'),
            Field::Reference('product'), // can get several treatments from several students; so, there is a roll up into 1 entry later.

            Field::DateTime('date', 'DATE'),
            Field::Decimal('cost'), // ?
            Field::string('status'), // ?

        ];

        return $this->addstruct($stru, parent::structure());
    }

    function get_sql( $sql ) {
        // dd($sql);
    }

}