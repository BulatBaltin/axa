<?

$period = "";
$project_id = 0; 
$customer_id = 0; 
$page = 1;

$boss       = User::GetUser();
$company    = User::GetCompany($boss);

$mssg       = REQUEST::getParam('mssg');
$page       = REQUEST::getParam('page', 1);
$search     = REQUEST::getParam('search', '');

$root = 'qv.t-time';
$lingo = User::Lingo();
$rootindex = 'qv.t-time.index';
$event = '5';

$routeName = REQUEST::getUri(); //$request->attributes->get('_route');
$session = new DataLinkSession();

if (strpos($routeName, $rootindex) !== false) {
    $uri_old = $session->get('t-time_uri');
    if($uri_old and strpos($uri_old, $root) !== false) {
        $session->remove('t-time_uri');
        return UrlHelper::Redirect( $uri_old );
    } else {
        return UrlHelper::RedirectRoute($root .'.xindex');
    }
}    
$session->set('t-time_uri', REQUEST::getUri());

$timeStart = ToolKit::getTimeStart($event, $company);
$pageLimit = App::Config('PAGE-LIMIT'); //$this->getParameter('page-limit');

$dataCluster = []; //new InvoicetimeCluster;
$params = [];
$search_string = '';
$whereTag = "AND u.invoice_id IS NULL";
$search_o = [];
$orderBy = ['period' => 'DESC'];
$sincedate = '';

// if (strpos($routeName, $root .'.filter') !== false) {
if (strpos($routeName, '/filter') !== false) {

    // dump($routeName);
    // dump("GET", $_GET);
    // dd("POST", $_POST);
    $tag        = REQUEST::getParam('tag');
    $search     = REQUEST::getParam('search');
    $period     = REQUEST::getParam('period');
    $sincedate  = REQUEST::getParam('sincedate');
    $project_id = REQUEST::getParam('project_id');
    $user_id    = REQUEST::getParam('user_id');
    $customer_id = REQUEST::getParam('customer_id');
    $invoice_id = REQUEST::getParam('invoice_id');

    if (!$tag and !$customer_id and !$search and !$period and !$sincedate and !$project_id and !$invoice_id and !$user_id) {
        return UrlHelper::RedirectRoute($root . '.xindex');
    }

    if ($search) {

        $search_o['and'][] = ['fields' => [
            'tasknl' => "%" . $search . "%",
            'task' => "%" . $search . "%",
            'tid' => "%" . $search . "%"
        ], 'operation' => 'LIKE'];

        $search_string = $search;
        $params['search'] = $search; // part of URL parameters
    }    

    if (is_string($tag)) {
        $dataCluster['tag'] = $tag;
        $params['tag'] = $tag;
        $search_o['and'][] = [];

        if($tag == '') {
            $whereTag = "AND (u.level <> '+' OR u.level IS NULL)";
        } elseif($tag == 'C') {
            $whereTag = "AND u.invoice_id IS NULL AND (t.completed = '1')";
        } elseif($tag == 'MR') {
            $whereTag = "AND u.invoice_id IS NULL AND (u.status > '')";
        } elseif($tag == 'S') {
            $whereTag = "AND u.invoice_id IS NOT NULL AND (i.status = 'submitted')";
        } elseif($tag == 'NS') {
            $whereTag = "AND u.invoice_id IS NOT NULL AND (i.status = 'not ready' OR i.status = 'not submitted')";
        } elseif($tag) {
            // $whereTag = " AND u.tag LIKE '%{$tag}%'";
            $whereTag = "AND u.invoice_id IS NOT NULL AND (u.level <> '+' OR u.level IS NULL)";
        }
        // dd($whereTag);
    }
    if ($sincedate) {
        $startdate = DateTime::createFromFormat('d/m/Y', $sincedate);
        $startdate = $startdate ? $startdate->format('Y-m-d') : $sincedate;

        $flds = ['period' => $startdate ];
        $op = '>=';
        $search_o['and'][] = ['fields' => $flds, 'operation' => $op];
        $params['sincedate'] = $startdate;
        $orderBy = ['period' => 'DESC', 'customer' => 'ASC'];

    }
    if ($period) {
        $dataCluster['period'] = $period;
        if($period == 'this-week') {
            $odate = new DateTime();
            $odate1 = ToolKit::firstDayOfWeek($odate);
            $odate2 = ToolKit::lastDayOfWeek($odate);
            $date1 = $odate1->format('Y-m-d');
            $date2 = $odate2->format('Y-m-d');
            $flds = ['period' => [$date1, $date2]];
            $op = 'BETWEEN';
            // $param = $period;

        } elseif ($period == 'last-week'){

            $odate  = new DateTime();
            $odate->modify('-7 days');
            $odate1 = ToolKit::firstDayOfWeek($odate);
            $odate2 = ToolKit::lastDayOfWeek($odate);
            $date1  = $odate1->format('Y-m-d');
            $date2  = $odate2->format('Y-m-d');
            $flds   = ['period' => [$date1, $date2]];
            $op = 'BETWEEN';
            // $param = $period;

        } else {
            $flds   = ['period' => "%" . $period . "%"];
            $op     = 'LIKE';
            // $param = $period;
        }

        $search_o['and'][] = ['fields' => $flds, 'operation' => $op];
        $params['period'] = $period;
    }
    if ($customer_id) {
        // $customer = Client::find($customer_id);
        $dataCluster['customer'] = $customer_id; //$customer['id'];
        $search_o['and'][] = ['fields' => ['customer_id' => $customer_id], 'operation' => '='];
        $params['customer_id'] = $customer_id;
    }
    if ($user_id) {
        // $developer = User::find($user_id);
        // dd($user_id, $developer['name']);
        $dataCluster['user'] = $user_id; //$developer['id'];
        $search_o['and'][] = ['fields' => ['user_id' => $user_id], 'operation' => '='];
        $params['user_id'] = $user_id;
    }
    if ($project_id) {
        // $tasklist = Tasklist::find($project_id);
        $dataCluster['tasklist'] = $project_id;
        $search_o['and'][] = ['fields' => ['project_id' => $project_id], 'operation' => '='];
        $params['project_id'] = $project_id;
    }
    
    $rootpages  = $root . '.filter';
} else {

    // $rootpages = 'zhours.index';
    $rootpages = $root . '.xindex';
    $search_o = null;
    $search = null;
}

$layout = ToolKit::paginateExt(
    "InvoiceGood",
    [
        'where' => "u.company_id = :company_id {$whereTag}",
        'params' => ['company_id' => $company['id']],
        'join' => [
            ['table' => 'client', 'alias'=>'c', 'on' => 'u.customer_id = c.id', 'select'=>'c.name as customer_name'],
            ['table' => 'user', 'alias'=>'s', 'on' => 'u.user_id = s.id', 'select'=>'s.name as user_name, s.sirname'],
            ['table' => 'project', 'alias'=>'p', 'on' => 'u.project_id = p.id', 'select'=>'p.name as tasklist'],
            ['table' => 'tasks', 'alias'=>'t', 'on' => 'u.tid = t.tid', 'select'=>'t.completed as completed'],
            ['table' => 'invoice', 'alias'=>'i', 'on' => 'u.invoice_id = i.id', 'select'=>'i.status as invoice_status'],
            ]
    ],
    $search_o,
    $pageLimit,
    $page,
    $orderBy //['customer' => 'ASC','period' => 'DESC']
    // true
);

$listInvoices   = $layout['pageItems'];

$dataCluster['rows'] = [];
foreach ($listInvoices as $key => $invoiceItem) {
    $dataCluster['rows'][]      = $invoiceItem;  //->getRows()->add($invoiceItem);
}
// dd($listInvoices);

$invoices = Invoice::findBy(['company_id'=> $company['id'], 
'status'=>  [
    'OR'=>['not ready', 'not submitted']
            ]
],['id'=>'DESC']);

$tasklists = Tasklist::findBy(
    [
    'company_id' => $company['id'] 
    ],
['name'=>'ASC']);

$dataCluster['isrounded'] = true; 
// ASSIGN USER PARAMETER

$form_view = new TrackedtimeType( 
    $dataCluster, 
    $tasklists,
    $invoices
);

$keys = Trackingmap::findCredentials('company', $company, 'Teamwork', $company['id']);
if($keys) {
    $site_root = $keys['key1']; //'ibl82';
} else {
    $site_root = '';
}

$Title = 'Import hours';
$unbillable    = 0;
$hours_tag     = true;
$timeStart     = date('d-m-Y H:i:s', $timeStart);
$pagination    = $layout['pagination'];
$pages         = $layout['pages'];
