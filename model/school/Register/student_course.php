<?php

class Student_course extends Register {

    function Structure() {

        $stru = [
            Field::Reference('student'),
            Field::Reference('program'),
            Field::DateTime('start_date','DATE'),
            Field::Bool('material_package'),
            Field::Reference('payment'),

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