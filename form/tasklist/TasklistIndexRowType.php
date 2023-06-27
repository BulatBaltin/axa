<?php

class TasklistIndexRowType extends dmForm
{
    public function __construct( array $tasklist )
    {
        $this->fields = [
            'customer' =>[
                'label'         => 'Customer',
                'type'          => 'Combo',
                'value'         => $tasklist['customer_id'],
                'source'        => 'Client',
                // 'placeholder'   => 'All customers', // 'Select customer',
                'sort'          => [ 'name'=>'ASC'],
                'first_rec'     => [ 0, '- Select -']
            ], 
        ];
    }

}
