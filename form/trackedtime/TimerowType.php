<?php
// InvoicePlanRowType
class TimerowType extends dmForm
{
    function __construct(    
        $timerow 
    )
    {
        $this->fields = [
            'customer_id' => [
                'name'      => 'customer_id',
                'type'      => 'combo',
                'source'    => 'client',
                'first_rec' => [0, '- Select -'],
                // 'label'     => 'Customer',
                // 'class'     => 'custom_select',
                'value'     => $timerow['customer_id']
            ],
            'tasknl' => [
                'value' => $timerow['tasknl'],
                // 'placeholder' => 'enter customer',
                // 'choice_value' => function (Client $entity = null) {
                //     return $entity ? $entity->getId() : '';
                // },
                ],
            'artikul_id' => [
                'name'      => 'artikul_id',
                'label'     => 'Product',
                'type'      => 'combo',
                'source'    => 'product',
                'value'     => $timerow['artikul_id'],
                'presentation' => function ( $product) {
                    return sprintf('%s € %d', $product['name'], $product['price']);
                }
            ],
            'quantitylost' => ['label' => 'Non-billable', 'type' => 'number' ]
        ];
    }
}