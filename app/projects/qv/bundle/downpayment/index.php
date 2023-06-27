<?php

$routeName  = REQUEST::getUri(); //$request->attributes->get('_route');
$page       = REQUEST::getParam('page', 1);
$search     = REQUEST::getParam('search', '');

$session    = New DataLinkSession();
$mssg       = $session->get('mssg'); 

$search_string = '';
$Customers = []; // new DataClusterCustomer;
$Customers['rows'] = [];

if (strpos($routeName, 'downpayment/search') !== false) {
    $search = $request->query->get('search');
    if (empty($search)) {
        return UrlHelper::RedirectRoute('qv.downpayment.index');
    }
    $search_o = ['fields' => ['name'], 'needle' => $search];
    $rootpages  = 'qv.downpayment.search';
    $search_string = $search;
} elseif (strpos($routeName, 'downpayment/filter') !== false) {

    if (empty($search)) {
        return UrlHelper::RedirectRoute('qv.downpayment.index');
    }
    $rootpages  = 'qv.downpayment.filter';
    $customer = Client::find($search);
    $Customers['customer_id'] = $customer['id'];
    $search_o = ['fields' => ['customer'], 'needle' => $search, 'operation' => '='];
} else {
    $rootpages = 'qv.downpayment.index';
    $search_o = null;
    $search = null;
}

$pageLimit = App::Config('PAGE-LIMIT'); //$this->getParameter('page-limit');
$layout = ToolKit::paginateExt(
    "Downpayment",
    [
        'where' => "u.company_id = :company_id",
        'params' => ['company_id' => $company['id']],
        'join' => [
            ['table' => 'client', 'alias' => 'c', 'on' => 'u.customer_id = c.id', 'select' => 'c.name as customer_name, c.hash as customer_hash' ]
        ]
    ],
    $search_o,
    $pageLimit,
    $page
    // ['id' => 'DESC']
);

$Items = $layout['pageItems'];

foreach ($Items as $item) {
    $Customers['rows'][] = $item;
}

$form = new DownpayCustomerType($Customers);

$timeStart = strtotime('2022-10-26');
// ToolKit::getTimeStart($em, $this->eventcode, $company);
$Title = 'Downpayments';
$timeStart  = date('d-m-Y H:i:s', $timeStart);
$is_company = true;
$pagination = $layout['pagination'];
$pages      = $layout['pages'];
$root       = 'qv.downpayment';

// return $this->render('downpayment/index.html.twig', $parms);

