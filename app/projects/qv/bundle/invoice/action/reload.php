<?php

$id = REQUEST::getParam('invoice_id');
$cache = new SessionInvoiceCache(['id' => $id]);
$cache->remove();

Json_Response(['return' => 'success', 'url' => generateUrl('qv.invoice.edit', ['id' => $id])]);
