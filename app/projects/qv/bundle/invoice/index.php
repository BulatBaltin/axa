<?

$period = "";
$customer_id = 0; 
$page = 1;

$boss       = User::GetUser();
$company    = User::GetCompany($boss);

$mssg       = REQUEST::getParam('mssg');
$page       = REQUEST::getParam('page', 1);
$search     = REQUEST::getParam('search', '');

$root = 'qv.invoice';
$lingo = User::Lingo();
$rootindex = 'qv.invoice.index';
$event = '6';

$routeName = REQUEST::getUri(); //$request->attributes->get('_route');
$session = new DataLinkSession();

if (strpos($routeName, $rootindex) !== false) {
    $uri_old = $session->get('invoice_index_uri');
    if($uri_old and strpos($uri_old, $root) !== false) {
        $session->remove('invoice_index_uri');
        return UrlHelper::Redirect( $uri_old );
    } else {
        return UrlHelper::RedirectRoute($rootindex);
    }
}    
$session->set('invoice_index_uri', REQUEST::getUri());

$params = [];
$dataCluster = []; //new InvoiceCluster;
$search_string = '';
$whereTag = ''; // "AND (u.tag = '' OR u.tag IS NULL)";
$search_o = [];
$orderBy = ['period' => 'DESC'];
$sincedate = '';

$timeStart = ToolKit::getTimeStart($event, $company);
$pageLimit = App::Config('PAGE-LIMIT'); //$this->getParameter('page-limit');

// if (strpos($routeName, $root .'.filter') !== false) {
if (strpos($routeName, '/filter') !== false) {

    $tag        = REQUEST::getParam('tag');
    $search     = REQUEST::getParam('search');
    $period     = REQUEST::getParam('period');
    $customer_id = REQUEST::getParam('customer_id');
    $status = REQUEST::getParam('status');

    if (!$customer_id and !$status and !$period  and !$search and !$tag) {
        return UrlHelper::RedirectRoute($rootindex);
    }

    if ($search) {

        $search_o['and'][] = ['fields' => [
            'id' => "%" . $search . "%",
            'doc_number' => "%" . $search . "%",
            'factuurnummer' => "%" . $search . "%",
        ], 'operation' => 'LIKE'];

        $search_string = $search;
        $params['search'] = $search; // part of URL parameters
    }    
    // if (is_string($tag)) {
    if ($tag) {
        $dataCluster['tag'] = $tag;
        $params['tag'] = $tag;
        if($tag == 'LL') {
            $whereTag = "";
        } else {
            $whereTag = "AND u.tag LIKE '%{$tag}%'";
        }

    }
    if ($period) {
        $dataCluster['period'] = $period;
        $flds = ['period' => "%" . $period . "%"];
        $op = 'LIKE';
        // $param = $period;
        $search_o['and'][] = ['fields' => $flds, 'operation' => $op];
        $params['period'] = $period;
    }
    if ($status) {
        $dataCluster['status'] = $status;
        if(strpos($status,' or ')) {
            $astatus = explode(' or ', $status);
        } else {
            $astatus = [$status];
        }
        $search_o['and'][] = ['fields' => ['status' => $astatus], 'operation' => 'IN'];
        $params['status'] = $status;
    }
    if ($customer_id) {
        // $customer = Client::find($customer_id);
        $dataCluster['customer'] = $customer_id; //$customer['id'];
        $search_o['and'][] = ['fields' => ['customer_id' => $customer_id], 'operation' => '='];
        $params['customer_id'] = $customer_id;
    }

    $rootpages  = $root . '.filter';
} else {

    $rootpages = $rootindex;
    $search_o = null;
    $search = null;
}
$layout = ToolKit::paginateExt(
    "Invoice",
    [
        'where' => "u.company_id = :company_id {$whereTag}",
        'params' => ['company_id' => $company['id']],
        'join' => [
            ['table' => 'client', 'alias' => 'c', 'on' => 'u.customer_id = c.id', 'select' => 'c.name as customer_name, c.hash as customer_hash' ]
        ]
    ],
    $search_o,
    $pageLimit,
    $page,
    ['doc_date' => 'DESC']
);

// dd(DataBase::$sql);

$invoices   = $layout['pageItems'];
$timeInvoice = Invoice::getTime($invoices);
$dataCluster['rows'] = $invoices;

$customers = InvoiceRepository::findWithInvoices($company);

$form = new InvoiceCommandType($dataCluster, $customers, 'POST');

$Title      = "Invoices";
$pagination = $layout['pagination'];
$pages      = $layout['pages'];
$invoice_tag = true;
