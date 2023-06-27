<?php

class Model_cancel_student extends Register {

    // ModelCanceledLesson
    function Structure() {
    
        $stru = [
            Field::Reference('model'),
            Field::Reference('lesson'),
            Field::Reference('student'),
            Field::DateTime('action_date'),
        ];
        return $this->addstruct($stru, parent::structure());
    }


}