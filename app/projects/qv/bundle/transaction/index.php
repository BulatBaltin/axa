<?php

// /**
//      * @Route("/index", name="index", methods={"GET","POST"})
//      * @Route("/mssg/{mssg}", name="index-mssg", methods={"GET","POST"})
//      */
//     public function indexParts(TransactionsRepository $transactionsRepo, $mssg = null): Response
//     {
//         $boss = $this->getUser();
//         $company = $boss->getCompany();
//         $Items = $transactionsRepo->findBy(['company' => $company], ['logtime' => 'DESC']);
//         // $Items5 = $transactionsRepo->findBy(['code' => ['5'], 'company' => $company], ['logtime' => 'DESC']); // Import Catalogues
//         // $Items6 = $transactionsRepo->findBy(['code' => ['6'], 'company' => $company], ['logtime' => 'DESC']); // Import Catalogues

//         $ItemsHCH = $transactionsRepo->findBy(['code' => '7', 'company' => $company], ['logtime' => 'DESC']); // Change Hours
//         $ItemsElse = $transactionsRepo->findBy(['code' => ['1', '2', '3', '4', '5', '6'], 'company' => $company], ['logtime' => 'DESC']); // Import Catalogues

//         $parms = [
//             'Title'     => 'Transactions',
//             'ItemsHCH'  => $ItemsHCH,
//             'ItemsElse' => $ItemsElse,
//             'Items'     => $Items,
//             // 'Items5'    => $Items5,
//             // 'Items6'    => $Items6,
//             'Fields'    => $this->Fields,
//             'FieldsEx'    => $this->FieldsEx,
//             'root'      => $this->root
//         ];

//         if ($mssg) {
//             $parms['mssg'] = $mssg;
//         }
//         // return $this->render('transactions/index.html.twig', $parms);
//         return $this->render('transactions/transactions.html.twig', $parms);
//     }

$routeName  = REQUEST::getUri(); //$request->attributes->get('_route');
$page       = REQUEST::getParam('page', 1);
$page2      = REQUEST::getParam('page2', 1);
$page3      = REQUEST::getParam('page3', 1);
$search_string = '';

$FieldsEx = 
[
    ['label' => 'ID',           'name' => 'id'],
    ['label' => 'Date',         'name' => 'logtime'],
    ['label' => 'Description',  'name' => 'description'],
    ['label' => 'User',         'name' => 'user_id'],
    ['label' => 'Code',         'name' => 'code'],
    ['label' => 'Event',        'name' => 'name'],
    // ['label' => 'Brief',       'name' => 'event'],
    // ['label' => 'Time stamp',  'name' => 'eventtime']
];

$Fields = 
[
    ['label' => 'ID',    'name' => 'id'],
    ['label' => 'Date',    'name' => 'logtime'],
    ['label' => 'Description', 'name' => 'description'],
    ['label' => 'User',        'name' => 'user_id'],
    // ['label' => 'Code',        'name' => 'code'],
    // ['label' => 'Event',        'name' => 'name'],
    // ['label' => 'Brief',       'name' => 'event'],
    // ['label' => 'Time stamp',  'name' => 'eventtime']
];


$is_company = true;
$Title      = 'Transaction';
$root       = 'qv.transaction';
$rootindex  = 'qv.transaction.index';
$rootindex  = 'qv.transaction.index';
$rootpages2 = 'qv.transaction.index';
$rootpages3 = 'qv.transaction.index';
$search2 = '';
$search3 = '';

if (strpos($routeName, 'transaction/search') !== false) {
    $search = REQUEST::getParam('search','');
    if (empty($search)) {
        return UrlHelper::RedirectRoute($rootindex);
    }
    $search_o = ['fields' => ['name'], 'needle' => $search];
    $rootpages  = 'qv.transaction.search';
    $search_string = $search;
} else {
    $rootpages = $rootindex;
    $search_o = null;
    $search = null;
}

$pageLimit  = $pageLimit = App::Config('PAGE-LIMIT');

$session = New Session;
$mssg = $session->get('mssg'); 

$filter3 = [
'where' => 'u.company_id = :company AND u.code = 7',
'params' => ['company' => $company['id']],
];

try {


$layout3 = ToolKit::paginateExt(
    "transaction",
    $filter3, //$company,
    $search_o,
    $pageLimit,
    $page,
    ['name' => 'ASC']
);

} catch(Exception $e) {

    echo DataBase::$sql;
    dd($e->getMessage());
}
$ItemsHCH       = $layout3['pageItems']; // 'code' => ['1', '2', '3', '4', '5', '6']
$pagination3    = $layout3['pagination'];
$pages3         = $layout3['pages'];
$params3 = null;


$filter2 = [
    'where' => 'u.company_id = :company AND u.code IN (1,2,3,4,5,6)',
    'params' => ['company' => $company['id']],
    ];
    
    try {
    
    
    $layout2 = ToolKit::paginateExt(
        "transaction",
        $filter2, //$company,
        $search_o,
        $pageLimit,
        $page,
        ['name' => 'ASC']
    );
    
    } catch(Exception $e) {
    
        echo DataBase::$sql;
        dd($e->getMessage());
    }
$ItemsElse      = $layout2['pageItems']; // 'code' => ['1', '2', '3', '4', '5', '6']
$pagination2    = $layout2['pagination'];
$pages2         = $layout2['pages'];
$params2 = null;

$layout = ToolKit::paginateExt(
    "transaction",
    $company,
    $search_o,
    $pageLimit,
    $page,
    ['name' => 'ASC']
);

$Items      = $layout['pageItems'];
$pagination = $layout['pagination'];
$pages      = $layout['pages'];
$params     = null;
