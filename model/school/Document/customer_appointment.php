<?php

class Customer_appointment extends Document {
    
    function Structure() {
    
        $stru = [
            Field::Reference('customer'),
            Field::Reference('lesson'),
        ];

        return $this->addstruct($stru, parent::structure());
    }

}