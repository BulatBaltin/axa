<?php

class DlgCustomerType extends dmForm
{
    function __construct($customers)
    {
        $this->add('customer', [
            'type' => 'combo',
            'first_rec' => [0, '- Select -'], // 'Select customer',
            'source' => $customers,
        ])
        ;
    }

}
