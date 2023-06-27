<?php

class Schedule_student extends Schedule {
    function Structure() {
    
        $stru = [
            Field::Reference('student'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

}