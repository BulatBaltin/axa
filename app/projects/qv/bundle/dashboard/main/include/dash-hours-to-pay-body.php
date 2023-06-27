<?php
if($customer_id) {
    $customer = Client::find($customer_id);
} else {
    $customer = null;
}
$payhours = InvoiceGood::GetAllHours($company, $customer, $period);        
