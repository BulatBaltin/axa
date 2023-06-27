<?php

class Support_ticket extends Register {

    function Structure() {

        $stru = [

            Field::string('source',64), // author
            Field::Int('id_source'),
            Field::Text('content'),
            Field::DateTime('date'),
            Field::Reference('admin'),

        ];

        return $this->addstruct($stru, parent::structure());
    }

    function get_sql( $sql ) {
        // dd($sql);
    }

}