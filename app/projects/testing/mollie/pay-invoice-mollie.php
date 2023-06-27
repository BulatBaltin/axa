<?

use Mollie\Api\Exceptions\ApiException;

// $invoice_hash = REQUEST::getParam('hash', '', true);
// $invoice = dlModel::Create('h_invoices')->GetRec( ['hash' => $invoice_hash] );

// // var_dump($invoice);
// // die;

// if(!($invoice and $invoice['status'] == APP::Constant("INVOICE_STATUS_NOT_PAID"))) {
//   return null;
// }
// $result = 'OK';

$invoice = [
  'id' => 1,
  'hash' => 'abc',
  'amount' => 100.25,
];

try {
  $invoice_id   = $invoice['id'];
  $invoice_hash = $invoice['hash'];
  $invoice_id   = $invoice['id'];
  $invoice_hash = $invoice['hash'];
  $str_total    = number_format($invoice['amount'], 2, ".", "");

  $mollie_method = 'ideal';

  $result_url   = GetRawResultPage($invoice_hash);
  $webhook_url  = GetRawWebhook();

  dlLog::WriteDump("Start pay-invoice {$str_total}");
  
  $mollie = new Mollie($result_url, $webhook_url);
  $mollie->payWithMethod($invoice_id, $str_total, $mollie_method);

  if($mollie->CheckoutUrl) UrlHelper::Redirect($mollie->CheckoutUrl);

} catch (ApiException $e) {
  $errors = "API call failed: " . htmlspecialchars($e->getMessage());
  dlLog::Write( $errors . " Invoice {$invoice_id} {$invoice_hash} {$str_total}");
}

// var_dump( $result );
// echo "<br>End test";
exit(); 

function GetRawWebhook() {
  return UrlHelper::getHttpHostUrl().'/qv/dashboard';
}
function GetRawResultPage($hash) {
  return UrlHelper::getHttpHostUrl().'/students/pay-result-page/'.$hash;
}

?>