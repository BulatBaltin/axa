<?php

class Course extends Catalogue {

    private $units; // array
    private $examin; // Exam 
    private $quali_initial; // Qualification 
    private $quali_target; // Qualification 

    function Structure() {
    
        $stru = [
            Field::Reference('program'),
            Field::DateTime('start'),
            Field::Reference('school'),
            Field::Reference('teacher'),
            Field::Reference('exam'),
            Field::Int('max_capacity'),
            Field::Int('max_times_pause'),
            Field::Int('max_payment_terms'),
            Field::Decimal('cost'),
            // Field::Int('duration')
            Field::Reference('duration')
        ];
        return $this->addstruct($stru, parent::structure());
    }

    function SimulateData() {

        $date = (new DateTime())->format('c');
        Course::insert([
            'id' => 1,
            'name' => '',
            'program_id' => 1,
            'start' => date('c', mktime(10,0,0,  8,7,2021 )),
            'school_id' => 1,
            'teacher_id' => 1,
            'exam_id' => 1,
            'max_capacity' => 10,
            'max_times_pause' => 2,
            'max_payment_terms' => 2,

            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Course::insert([
            'id' => 2,
            'name' => '',
            'program_id' => 2,
            'start' => date('c', mktime(10,0,0,  8,15,2021 )),
            'school_id' => 1,
            'teacher_id' => 2,
            'exam_id' => 1,
            'max_capacity' => 12,
            'max_times_pause' => 3,
            'max_payment_terms' => 2,

            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }
}