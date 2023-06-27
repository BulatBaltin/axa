<?php

class InvoiceType extends dmForm
{
    public $curritem;
    public $rows;

    function __construct($invoice, $options)
    {
        //dd($options);
        $items      = $invoice['rows'];
        $this->curritem = [];
        foreach ($items as $key => $item) {
            $this->curritem[]   = new InvoiceItemsType($item, $options);
            $this->rows[]       = new InvoiceItemsType($item, $options);
        }

        $this->fields = [
            'row_index' => ['id'=>'row_position' ], // 0..n
            'markAll'=>[
                'type' => 'checkbox',
            ],
            'id'    => ['value' => $invoice['id']], // hidden
            'invoice_id'    => ['value' => $invoice['id']], // hidden
            'customer_id'   => ['value' => $invoice['customer_id']], // hidden
            'customer'=> [
                'type'  => 'combo',
                'source'=> 'client',
                'label' => 'Customer',
                'first_rec' => [0, 'Select customer'],
                'placeholder' => 'Select customer',
                'value' => $invoice['customer_id']
            ], 
            'currency_code' => [
                'value' => $invoice['currency_code']
            ],
            'quantity'=>[
                'type' => 'number',
                'label' => 'Total hours',
                'value' => $invoice['quantity']
            ],
            'total'=>[
                'type' => 'number',
                'label' => 'Total Exc.VAT',
                'value' => $invoice['total']
            ],
            'vatcoeff'=>[
                'type' => 'number',
                'label' => 'VAT %',
                'value' => $invoice['vatcoeff']
            ],
            'vatsum'=>[
                'type'  => 'number',
                'label' => 'VAT Sum',
                'value' => $invoice['vatsum']
            ],
            'totalvat'=>[
                'type'  => 'number',
                'label' => 'Total Inc.VAT',
                'value' => $invoice['totalvat']

            ],
            'doc_number' => [
                'data'  => 'auto',
                'value' => $invoice['doc_number']
            ],
            'doc_date' => [
                'type' => 'datetime',
                'value' => $invoice['doc_date']
            ]

        ];
    }

}
