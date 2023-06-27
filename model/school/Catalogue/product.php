<?php

class Product extends Catalogue {

    function structure()
    {
        $stru = [
            Field::Decimal('cost'),
        ];
        return $this->addstruct($stru, parent::Structure());
    }

}