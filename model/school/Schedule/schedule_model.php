<?php

class Schedule_model extends Schedule {
    function Structure() {
    
        $stru = [
            Field::Reference('model'),
        ];
        return $this->addstruct($stru, parent::structure());
    }
}