<?php

$invoice_id = REQUEST::get('id');
// echo "DELETE invoice ". $invoice_id;

Invoice::DeleteInvoice($invoice_id);

// die;
UrlHelper::RedirectRoute( 'qv.invoice.index');
// Json_Response(['return' => 'success']);
