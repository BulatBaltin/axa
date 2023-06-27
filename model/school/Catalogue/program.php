<?php

class Program extends Catalogue {

    private $units; // array
    private $examin; // Exam 
    private $quali_initial; // Qualification 
    private $quali_target; // Qualification 
    function Structure() {
    
        $stru = [
            Field::Text('description'),
            Field::Reference('program_type'),
            Field::Decimal('cost'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

    function SimulateData() {

        $date = (new DateTime())->format('c');
        Program::insert([
            'id' => 1,
            'name' => 'Knippen damen, kort haar',
            'revenue' => 35,
            'cost' => 40,
            'duration' => 30,
            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Program::insert([
            'id' => 2,
            'name' => 'Knippen damen, kort haar',
            'revenue' => 0,
            'cost' => 40,
            'duration' => 30,
            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        return 'Program data entered';
    }

}