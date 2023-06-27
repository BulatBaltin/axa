<?php

class Schedule_lesson extends Schedule {
    function Structure() {
    
        $stru = [
            Field::Reference('lesson'),
        ];
        return $this->addstruct($stru, parent::structure());
    }

}