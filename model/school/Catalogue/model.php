<?php

class Model extends Catalogue {
    function Relation()
    {
        return ['model_appointment', 'model_registration', 'model_availability', 'model_treatment','model_treatment_type'];
    }

    function structure()
    {
        $stru = [
            Field::Reference('person'),
            Field::Reference('model_rating'),
            Field::Reference('keychain'),
            Field::Int('hair_length'),
            Field::Bool('is_blacklist'),
        ];
        return $this->addstruct($stru, parent::Structure());
    }

    function SimulateData() {

        $date = (new DateTime())->format('c');
        Model::insert([
            'id' => 1,
            'name' => '',

            'person_id' => 1,
            'model_rating_id' => 1,
            'keychain_id' => 1,
            'is_blacklist' => false,

            'sort' => 10,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
        Model::insert([
            'id' => 2,
            'name' => '',

            'person_id' => 2,
            'model_rating_id' => 2,
            'keychain_id' => 1,
            'is_blacklist' => false,

            'sort' => 20,
            'created_at' => $date,
            'updated_at' => $date,
        ]);
    }

}