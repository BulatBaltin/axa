<?php

class InvoiceRowType extends dmForm
{
    function __construct($invoiceCluster)
    {
        //dd($options);
    $this->fields = [
        'tasknl' => [
            'label' => 'Task (NL)',
            'value' => $invoiceCluster['tasknl'] ?? ''
        ],
        'artikul' => [
            'type'      => 'combo',
            'source'    => 'product',
            'label'     => 'Product',
            'presentation' => function ($product) {
                return sprintf("%s € %d", $product['name'], $product['price']);
            },
            'value' => $invoiceCluster['artikul'] ?? ''
        ],
        'quantity' => [
            'type'  => 'number',
            'value' => $invoiceCluster['quantity'] ?? 0
        ]
    ];
    }
}
