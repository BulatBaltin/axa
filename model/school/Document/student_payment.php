<?php
class Student_payment extends Document {
    static function peep() {
        return 'Payment'; 
    }
    function Structure() {

    $stru = [
        Field::Text('description'), // ?
        Field::Reference('student'),
        Field::Reference('course'),
        Field::DateTime('due_date', 'DATE'),
    ];

    return $this->addstruct($stru, parent::structure());
    }
}