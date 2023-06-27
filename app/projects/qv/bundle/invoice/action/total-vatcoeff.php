<?php

$invoice_id = REQUEST::getParam('invoice_id');
$vatcoeff   = REQUEST::getParam('vatcoeff');

$cache = new SessionInvoiceCache(['id' => $invoice_id]);
$invoice = $cache->get();

$invoice['vatcoeff'] = $vatcoeff;

$cache->set($invoice);

Json_Response([]);
