<?php

class Model_rating extends Catalogue {

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
        Model_rating::insert([
            'id' => 1,
            'name' => 'Black',

            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Model_rating::insert([
            'id' => 2,
            'name' => 'Red',
            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Model_rating::insert([
            'id' => 3,
            'name' => 'Blue',
            'sort' => 30,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
       return 'Table data entered';
    }
}