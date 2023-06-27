<?php

class TasklistIndexType extends dmForm
{
    public $rows;

    public function __construct( array $Customers )
    {
        $this->rows = $Customers['rows'];

        $this->fields = [
            'customer' =>[
                'label' => 'Customer',
                'type'=>'Combo',
                'value'=>$Customers['customer_id'],
                'source'=>'Client',
                'placeholder' => 'All customers', // 'Select customer',
                'sort'=>['name'=>'ASC'],
                'first_rec' =>[0, 'All customers']
            ], 
            // EntityType::class, [
            //     'required' => false,
            //     'class' => Client::class
            // ])
            // ->add('rows', CollectionType::class, [
            //     'entry_type' => ProjectCustomerType::class,
            //     'entry_options' => ['label' => false],
        ];
    }

}
