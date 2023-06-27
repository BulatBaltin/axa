<?php

class Person extends Catalogue {
    function structure()
    {
        $stru = [
            Field::string('surname', 64),
            Field::string('hash', 16),
            Field::string('email'),
            Field::string('phone',32),
            Field::string('address'),

        ];
        return $this->addstruct($stru, parent::structure());
    }
    function SimulateData() {

        $date = (new DateTime())->format('c');
        Person::insert([
            'id' => 1,
            'name' => 'Anna',
            'surname' => 'Burning',
            'hash' => random_str(),
            'phone' => '1-888-123-1406',
            'email' => 'anna.burning@gmail.com',
            'address' => 'Amsterdam',

            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Person::insert([
            'id' => 2,
            'name' => 'Olivia',
            'surname' => 'Trust',
            'hash' => random_str(),
            'phone' => '1-888-321-0102',
            'email' => 'olivia.trust@gmail.com',
            'address' => 'Amsterdam',

            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Person::insert([
            'id' => 3,
            'name' => 'Amelia',
            'surname' => 'Woodland',
            'hash' => random_str(),
            'phone' => '1-888-435-0305',
            'email' => 'amelia.woodland@gmail.com',
            'address' => 'Amsterdam',

            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Person::insert([
            'id' => 4,
            'name' => 'Charlotte',
            'surname' => 'Lightsea',
            'hash' => random_str(),
            'phone' => '1-888-435-1234',
            'email' => 'charlotte.lightsea@gmail.com',
            'address' => 'Amsterdam',

            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Person::insert([
            'id' => 5,
            'name' => 'Emma',
            'surname' => 'Tearless',
            'hash' => random_str(),
            'phone' => '1-888-987-1234',
            'email' => 'emma.tearless@gmail.com',
            'address' => 'Amsterdam',

            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);

    }

}