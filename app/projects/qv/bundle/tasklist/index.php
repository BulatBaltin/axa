<?php

$routeName  = REQUEST::getUri(); //$request->attributes->get('_route');
$page       = REQUEST::getParam('page', 1);
$search_string = '';
$Customers = []; // new DataClusterCustomer;
$Customers['customer_id'] = 0; // array

$eventcode = '3';

$root = 'qv.tasklist';
$rootindex = 'qv.tasklist.index';

$session = New Session;
$mssg = $session->get('mssg'); 

// $search = '', $page = 1, $mssg = null
// $search = REQUEST::getParam('search'); //$request->query->get('search');

if (strpos($routeName, 'tasklist/search') !== false) {
    $search = REQUEST::getParam('search'); //$request->query->get('search');
    if (empty($search)) {
        return UrlHelper::RedirectRoute('qv.tasklist.index');
    }
    $search_o = ['fields' => ['name'], 'needle' => $search];
    $rootpages  = 'qv.tasklist.search';
    $search_string = $search;

    // dd($routeName, $search);


} elseif (strpos($routeName, 'tasklist/filter') !== false) {

    $search = REQUEST::getParam('search'); //$request->query->get('search');
    if (empty($search)) {
        return UrlHelper::RedirectRoute('qv.tasklist.index');
    }
    $rootpages  = 'qv.tasklist.filter';
    $customer   = Client::find($search); // ???
    $Customers['customer_id'] = $customer['id']; // array
    $search_o = ['fields' => ['customer_id'], 'needle' => $search, 'operation' => '='];
    
} else {
    $rootpages = 'qv.tasklist.index';
    $search_o = null;
    $search = null;
}

$pageLimit  = $pageLimit = App::Config('PAGE-LIMIT');

$layout = ToolKit::paginateExt(
    "Tasklist",
    $company,
    $search_o,
    $pageLimit,
    $page,
    ['name' => 'ASC']
);

$Items = $layout['pageItems'];

$Customers['rows'] = [];

foreach ($Items as $item) {
    $Customers['rows'][] = new TasklistIndexRowType($item);
}

$form = new TasklistIndexType($Customers);

$timeStart = ToolKit::getTimeStart($eventcode, $company);

$Title          = 'Task lists';
$importRoute    = 'qv.tasklist.import';
$Fields = [
    ['label' => 'Task list', 'name' => 'name'],
    ['label' => 'Customer to be mapped to Task list',  'name' => 'customer'],
];
$pagination = $layout['pagination'];
$pages      = $layout['pages'];
$is_company = true;
