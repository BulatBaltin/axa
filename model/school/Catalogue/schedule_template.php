<?php

class Schedule_template extends Schedule {
    function Structure() {
    
        $stru = [
            Field::Reference('schedule_type'),
            Field::Int('week_day'),
            Field::DateTime('start_time', 'TIME'),
            Field::DateTime('end_time', 'TIME'),
            Field::Int('duration')
        ];
        return $this->addstruct($stru, parent::structure());
    }

}