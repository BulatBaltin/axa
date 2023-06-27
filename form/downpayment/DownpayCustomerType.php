<?php

class DownpayCustomerType extends dmForm
{
    public $rows = [];

    public function __construct( array $options)
    {
        $this
            ->add('customer', [
                'label' => 'Customer',
                'placeholder' => 'All customers', // 'Select customer',
                'type' => 'combo',
                'source' => 'client'
            ])
            ;
    }
}
