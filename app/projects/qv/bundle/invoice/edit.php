<?

// $hash = MD5('123456789'); // password_hash('123456789',PASSWORD_DEFAULT, []);
// dd($hash);

$boss       = User::GetUser();
$company    = User::GetCompany($boss);

$invoice_id = REQUEST::getParam('id', 0);

$invoice    = Invoice::find($invoice_id);
$customer   = Client::find($invoice['customer_id']);
$invoice['customer_name']   = $customer['name'];

$root = 'qv.invoice.edit';
$lingo = User::Lingo();

if ($invoice['status'] === 'submitted') {
    return UrlHelper::RedirectRoute('qv.invoice.view', ['id' => $invoice['id']]);
}

if ($invoice['status'] == 'New') {
    $next_url = route('qv.invoice.create');
} else {
    $next_url = route('qv.invoice.update', ['id' => $invoice['id']] );
}
$session = new DataLinkSession();
$index_uri = $session->has('index_uri') ? $session->get('index_uri') : route('qv.invoice.index');
$hours_uri = $session->has('hours_uri') ? $session->get('hours_uri') : '';
$Title = 'Edit Invoice';

// ----------------]
include_once('include/table-data.html.php');

// return $this->render("invoice/zedit.html.twig", [
