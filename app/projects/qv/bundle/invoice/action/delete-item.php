<?php

$invoice = REQUEST::getForm();

$row_index  = $invoice['row_index'];

if($invoice['rows'][$row_index]['level'] == '+') {
    $level = $row_index;
    foreach ($invoice['rows'] as $index => $row) {
        if($row['level'] == $level) deleteRow($invoice, $index);
    }
}

deleteRow($invoice, $row_index);

// $log = new Transactions();
// $log->setEventtime(new DateTime());
// $log->setLogtime(new DateTime());
// $log->setCode('7');
// $log->setObjId($invoice_id);
// $log->setObjType('invoice');
// $log->setName($item->getTask());
// $log->setEvent('Delete item');
// $log->setDescription("Invoice item deleted. Hours {$item->getQuantity()} removed");
// $em->persist($log);
// $em->flush();

$html_table = module_partial('include/t-edit', [
    'invoice'   => $invoice
], true);

InvoiceRepository::calcGlobTotals($invoice);

Json_Response([
    'html_table'    => $html_table,
    'invoice'       => $invoice
]);

//
function deleteRow(&$invoice, $row_index) {
    unset($invoice['rows'][$row_index]);
}

