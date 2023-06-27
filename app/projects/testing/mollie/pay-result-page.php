<?php
// Change to hash
// http://bookingsystem/de/pay-result-page/12

Session::unsetAll();

$invoice_hash = $_GET["hash"];

$invoice = dlModel::Create('h_invoices')->GetRec(['hash' => $invoice_hash]);

// var_dump($invoice_hash, $invoice);
// die;

if (!$invoice) {
    UrlHelper::Redirect404();
}

SEO::setSEOHead(ll('Payment info'), '', '');

$invoice_id = $invoice['id'];
$total      = $invoice['amount'];
$status_id  = $invoice['status'];

$payment_status  = $invoice['payment_status'];
$arr  = explode('#',$payment_status);
$status_name  = isset($arr[0]) ? $arr[0] : '';

// Start here 09-052020
if ($total <= 0) {
    $title = ll('Your invoice was successful accepted!');
    $total_zero = ll("We will be waiting for you on our board!");
} elseif ($status_name == APP::Constant('MOLLIE_STATUS_PAID')) {
    $title = ll('Your payment was successful!');
    $template = ll('Invoice #%s date: %s Total: %d was successfully paid. Thank you'); 
    $success = sprintf($template, $invoice_id, $invoice['date_created'], $total);

} elseif ($status_name == APP::Constant('MOLLIE_STATUS_FAILED')) {
    $title = ll('Payment status');
    $errors = ll("Unfortunately your payment failed");
} 
// elseif ($status_id == APP::Constant('ORDER_CANCELED_ADMIN')) {
//     $title = ll('Payment status');
//     $errors = ll("Your payment was canceled by Admin");
// } elseif ($status_id == APP::Constant('ORDER_CANCELED_AUTO')) {
//     $title = ll('Payment status');
//     $errors = ll("Your payment was auto canceled after 15 minutes");
// } 
else
// if (
//     $status_name == APP::Constant('MOLLIE_STATUS_OPEN') or
//     $status_name == APP::Constant('MOLLIE_STATUS_PENDING') or
//     $status_name == APP::Constant('MOLLIE_STATUS_EXPIRED') or
//     $status_name == APP::Constant('MOLLIE_STATUS_CANCELED')
// ) 
{
    $title = ll('Payment status');
    $warning = ll("Your payment status is") . " " . $payment_status;
}

$warning .= "Hallo there!";
// var_dump($title);
// die;
