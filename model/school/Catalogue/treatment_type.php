<?php

class Treatment_type extends Catalogue {

// Short or long haircuts
    private $units;
    private $quali_initial;
    private $quali_target;
    function Structure() {
    
        $stru = [
            Field::Decimal('revenue'),
            Field::Decimal('cost'),
            Field::Int('duration')
        ];
        return $this->addstruct($stru, parent::structure());
    }

    function SimulateData() {

        $date = (new DateTime())->format('c');
        Treatment_type::insert([
            'id' => 1,
            'name' => 'Knippen damen, kort haar',
            'revenue' => 35,
            'cost' => 40,
            'duration' => 30,
            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Treatment_type::insert([
            'id' => 2,
            'name' => 'Knippen damen, kort haar',
            'revenue' => 0,
            'cost' => 40,
            'duration' => 30,
            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Treatment_type::insert([
            'id' => 3,
            'name' => 'Knippen damen, lang haar',
            'revenue' => 40,
            'cost' => 50,
            'duration' => 40,
            'sort' => 30,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        Treatment_type::insert([
            'id' => 4,
            'name' => 'Knippen damen, lang haar',
            'revenue' => 0,
            'cost' => 50,
            'duration' => 40,
            'sort' => 40,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        Treatment_type::insert([
            'id' => 5,
            'name' => 'Knippen damen, schouderlengte haar',
            'revenue' => 40,
            'cost' => 55,
            'duration' => 45,
            'sort' => 50,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        return 'Treatment data entered';
    }
}