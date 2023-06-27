<?php

class Schedule_type extends Catalogue {

// Short or long haircuts
    private $units;
    private $quali_initial;
    private $quali_target;
    function Structure() {
    
        $stru = [
            Field::Int('days'),
            Field::Int('hours'),
            Field::Int('mins'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

    function SimulateData() {

        $date = (new DateTime())->format('c');
        Schedule_type::insert([
            'id' => 1,
            'name' => 'All days',
            'days' => 5,
            'hours' => 10,
            'mins' => 600,

            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Schedule_type::insert([
            'id' => 2,
            'name' => 'Mn-Wd-Fr',
            'days' => 3,
            'hours' => 9,
            'mins' => 540,
            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Schedule_type::insert([
            'id' => 3,
            'name' => 'Td-Th-Fr',
            'days' => 3,
            'hours' => 9,
            'mins' => 540,
           'sort' => 30,
            'created_at' => $date,
            'updated_at' => $date,

        ]);
        return 'Schedule data entered';
    }
}