<?php

class Lesson extends Document {

    function Structure() {
    
        $stru = [
            // Field::Id(),
            // Field::string('name'), // 
            
            Field::Reference('course'),
            Field::Reference('teacher'), // ?
            Field::Reference('location'),

            Field::DateTime('date', 'DATE'),
            Field::DateTime('start'),
            Field::DateTime('finish'),
            Field::Integer('duration'), // ?
            Field::Text('description'), // ?
            Field::Text('teacher_note'),
            
        ];

        return $this->addstruct($stru, parent::structure());
    }

    function get_sql( $sql ) {
        // dd($sql);
    }

}