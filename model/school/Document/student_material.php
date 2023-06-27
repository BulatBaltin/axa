<?php

class Student_material extends Document {

    function Structure() {

        $stru = [
            Field::Id(),
            // Field::string('name', 64), // change
            Field::Reference('student'),
            Field::Reference('course'),
            Field::Reference('teacher'),
            Field::Reference('material'), // can get several treatments from several students; so, there is a roll up into 1 entry later.

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