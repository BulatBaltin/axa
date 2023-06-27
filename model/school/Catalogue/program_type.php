<?php

class Program_type extends Catalogue {
    function Structure() {
    
        $stru = [
            Field::string('model_service'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

    function SimulateData() {

        $date = (new DateTime())->format('c');
        Program_type::insert([
            'id' => 1,
            'name' => 'Barber',
            'model_service' => 'School responsibility',
            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Program_type::insert([
            'id' => 2,
            'name' => 'Salon',
            'model_service' => 'Default',
            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
       ]);
       Program_type::insert([
            'id' => 3,
            'name' => 'Visagie',
            'model_service' => 'Default',
            'sort' => 30,
            'created_at' => $date,
            'updated_at' => $date,
       ]);
    }
}