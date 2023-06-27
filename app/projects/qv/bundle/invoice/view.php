<?
$boss       = User::GetUser();
$company    = User::GetCompany($boss);

$invoice_id = REQUEST::getParam('id', 0);

$invoice    = Invoice::find($invoice_id);
$Items      = InvoiceGoodRepository::getInvoiceItems($invoice);
$invoice['rows'] = $Items;
$count = count($Items);
// dd($Items);
$customer   = Client::find($invoice['customer_id']);
$invoice['customer_name']   = $customer['name'];

$root = 'qv.invoice.view';
$lingo = User::Lingo();

$session = new DataLinkSession();
$index_uri = $session->has('index_uri') ? $session->get('index_uri') : route('qv.invoice.index');
$hours_uri = $session->has('hours_uri') ? $session->get('hours_uri') : '';
$Title = 'View Invoice';
