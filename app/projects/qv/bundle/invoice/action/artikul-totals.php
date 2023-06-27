<?php
// 'qv.invoice.artikul.totals', 'post:qv/invoice/artikul-totals'

$invoice = REQUEST::getForm(); // just _POST
$invoice_id = $invoice['id'];
$row_index  = $invoice['row_index'];

$row   = $invoice['rows'][$row_index];

$artikul_id = $row['artikul_id'];
$hours      = floatval($row['quantity']);
$product    = Product::find($artikul_id);

$mssg = "Success";
if (!$product) {
    $rate = 0;
    $total = 0;
    $product = null; // to be sure
} else {

    $rate = $product['price'];
    $total = round($hours * $rate, 2);
}

$invoice['rows'][$row_index]['price'] = $rate;
$invoice['rows'][$row_index]['total'] = $total;

InvoiceRepository::calcSubTotal($invoice, $row_index);

$invoice['total']     = $total;
$invoice['price']     = $rate;
$invoice['return']    = 'success';

// dymp($invoice);

Json_Response($invoice);
