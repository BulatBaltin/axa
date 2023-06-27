<?php

class Schedule_course extends Schedule {
    function Structure() {
    
        $stru = [
            Field::Reference('course'),
            Field::Reference('lesson'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

}