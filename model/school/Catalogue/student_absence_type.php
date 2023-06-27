<?php

class Student_absence_type extends Catalogue {

    // function Structure() {
    
    //     $stru = [
    //         Field::Decimal('revenue'),
    //         Field::Decimal('cost'),
    //         Field::Int('duration')
    //     ];
    //     return $this->addstruct($stru, parent::structure());
    // }

    function SimulateData() {

        $date = (new DateTime())->format('c');
        Student_absence_type::insert([
            'id' => 1,
            'name' => 'Sickness',

            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Student_absence_type::insert([
            'id' => 2,
            'name' => 'Canceled by student',
            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Student_absence_type::insert([
            'id' => 3,
            'name' => 'Canceled by Admin',
            'sort' => 30,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
       return 'Table data entered';
    }
}