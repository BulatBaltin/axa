<?php

class Schedule_payment extends Schedule {
    function Structure() {
    
        $stru = [
            Field::Reference('student'),
            Field::Reference('payment'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

}