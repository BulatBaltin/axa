<?php

class Program_unit extends Catalogue {

    private $units; // array
    private $examin; // Exam 
    private $quali_initial; // Qualification 
    private $quali_target; // Qualification 
    function Structure() {
    
        $stru = [
            Field::Reference('program'),
            Field::Int('number'),
            Field::Text('description'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

    function SimulateData() {

        $date = (new DateTime())->format('c');
        Program_unit::insert([
            'id' => 1,
            'name' => 'Introduction',
            'description' => 'Introduction to course',
            'program_id' => 1,
            'number' => 1,
            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Program_unit::insert([
            'id' => 2,
            'name' => 'Basics 1',
            'description' => 'Basics 1',
            'program_id' => 1,
            'number' => 2,
            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Program_unit::insert([
            'id' => 3,
            'name' => 'Basics 2',
            'description' => 'Basics 2',
            'program_id' => 1,
            'number' => 3,
            'sort' => 30,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        Program_unit::insert([
            'id' => 4,
            'name' => 'Intermediate',
            'description' => 'Intermediate 1-2',
            'program_id' => 1,
            'number' => 4,
            'sort' => 40,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        Program_unit::insert([
            'id' => 5,
            'name' => 'Advanced',
            'description' => 'Advanced 1-2',
            'program_id' => 1,
            'number' => 5,
            'sort' => 50,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        return 'Program_unit data entered';
    }

}