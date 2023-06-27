<?php

class Model_appointment extends Document {
    
    function Structure() {
    
        $stru = [
            Field::Reference('model'),
            Field::Reference('lesson'),
        ];

        return $this->addstruct($stru, parent::structure());
    }

}