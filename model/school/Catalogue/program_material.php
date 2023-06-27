<?php

class Program_material extends Catalogue {

    private $units; // array
    private $examin; // Exam 
    private $quali_initial; // Qualification 
    private $quali_target; // Qualification 
    function Structure() {
    
        $stru = [
            Field::Reference('program'),
            Field::Reference('material'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

    function SimulateData() {

        $date = (new DateTime())->format('c');
        Program_material::insert([
            'id' => 1,
            'name' => 'Material name',
            'program_id' => 1,
            'material_id' => 1,
            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Program_material::insert([
            'id' => 2,
            'name' => 'Material name',
            'program_id' => 1,
            'material_id' => 3,
            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Program_material::insert([
            'id' => 3,
            'name' => 'Material name',
            'program_id' => 1,
            'material_id' => 5,
            'sort' => 30,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        Program_material::insert([
            'id' => 4,
            'name' => 'Material name',
            'program_id' => 2,
            'material_id' => 3,
            'sort' => 40,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        Program_material::insert([
            'id' => 5,
            'name' => 'Material name',
            'program_id' => 2,
            'material_id' => 4,
            'sort' => 50,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        return 'Program_material data entered';
    }

}