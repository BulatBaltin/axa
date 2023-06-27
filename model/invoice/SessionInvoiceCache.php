<?php

class SessionInvoiceCache extends SessionObject {
    // public $invoice;
    // public $rows;

    function __construct($invoice)
    {
        $this->object_name  = 'invoice_' . (isset($invoice['id']) ? $invoice['id'] : 'new');
        // $this->invoice      = $invoice;
        // parent::__construct('itemsCache');
    }
}