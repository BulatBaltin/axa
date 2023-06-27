<?
// They are set in <proj> __construct.php
// $boss       = User::GetUser();
// $company    = User::GetCompany($boss);

$mssg       = REQUEST::getParam('mssg','');
$page       = REQUEST::getParam('page', 1, true);
$search     = REQUEST::getParam('search', '');
$routeName  = REQUEST::getUri(); //$request->attributes->get('_route');

$root = 'qv.user';

$search_string = '';

if (strpos($routeName, 'qv.user.search') !== false) {
    $search = REQUEST::getParam('search');
    if (empty($search)) {
        return UrlHelper::RedirectRoute('qv.user.index');
    }
    $search_o = ['fields' => ['name', 'sirname', 'role'], 'needle' => $search];
    $rootpages  = 'qv.user.search';
    $search_string = $search;
} else {
    $rootpages = 'qv.user.index-pg';
    $search_o = null;
    $search = null;
}

$pageLimit = 20; //$this->getParameter('page-limit');

$filter = [
    'where' => "u.company_id = :company_id AND NOT (u.role LIKE '%CUSTOMER%')",
    'params' => ['company_id' => $company['id']],
];

$layout = ToolKit::paginateExt(
    "User",
    $filter,
    $search_o,
    $pageLimit,
    $page,
    ['name' => 'ASC']
);

$Title = 'Employees';
$company = true;
$pagination = $layout['pagination'];
$Items      = $layout['pageItems'];
$pages      = $layout['pages'];
$Fields     = User::__GetFieldsEmloyees();
$root       = 'qv.user'; // worker

$roles = User::getRoleName();



