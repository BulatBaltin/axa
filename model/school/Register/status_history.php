<?php

class Status_history extends Register {

    function Structure() {

        $stru = [

            Field::string('doc_type',64),
            Field::Int('doc_id'),
            Field::string('status',64),

        ];

        return $this->addstruct($stru, parent::structure());
    }

    function get_sql( $sql ) {
        // dd($sql);
    }

}