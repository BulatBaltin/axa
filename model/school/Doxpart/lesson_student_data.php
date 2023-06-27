<?php

class Lesson_student_data extends Doxpart {

    function Structure() {

        $stru = [

            Field::Reference('lesson'),
            Field::Reference('unit'),
            Field::Reference('student'),
            Field::Reference('model'),
            Field::Decimal('model_revenue'),
            
            Field::String('student_signature'),
            Field::Bool('student_present'),
            Field::Reference('student_absence_type'),
            Field::Bool('model_present'),
            Field::Reference('model_absence_type'),
            Field::Text('teacher_note'), // private

        ];

        return $this->addstruct($stru, parent::structure());
    }

    function get_sql( $sql ) {
        // dd($sql);
    }

}