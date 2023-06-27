<?php
$routeName  = REQUEST::getUri(); //$request->attributes->get('_route');
$page       = REQUEST::getParam('page', 1);
$search_string = '';

$is_company = true;
$Title      = 'Products';
$root       = 'qv.product';
$rootindex  = 'qv.product.index';

if (strpos($routeName, 'product/search') !== false) {
    $search = REQUEST::getParam('search','');
    if (empty($search)) {
        return UrlHelper::RedirectRoute($rootindex);
    }
    $search_o = ['fields' => ['name'], 'needle' => $search];
    $rootpages  = 'qv.product.search';
    $search_string = $search;
} else {
    $rootpages = $rootindex;
    $search_o = null;
    $search = null;
}

$pageLimit  = $pageLimit = App::Config('PAGE-LIMIT');

$Fields     = [
    ['label' => 'Name',         'name' => 'name'],
    ['label' => 'Category',     'name' => 'group_id'],
];

$session = New Session;
$mssg = $session->get('mssg'); 

$layout = ToolKit::paginateExt(
    "Product",
    $company,
    $search_o,
    $pageLimit,
    $page,
    ['name' => 'ASC']
);

$Items      = $layout['pageItems'];
$pagination = $layout['pagination'];
$pages      = $layout['pages'];
