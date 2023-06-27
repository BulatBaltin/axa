<?

$boss = User::GetUser();
$company = User::GetCompany($boss);

$mssg       = REQUEST::getParam('mssg');
$page       = REQUEST::getParam('page', 1);
$search     = REQUEST::getParam('search', '');
$routeName  = REQUEST::getUri(); //$request->attributes->get('_route');

$root = 'qv.customer';

$search_string = '';

if (strpos($routeName, 'qv.customer.search') !== false) {
    $search = REQUEST::getParam('search');
    if (empty($search)) {
        return UrlHelper::RedirectRoute('qv.customer.index');
    }
    $search_o = ['fields' => ['name'], 'needle' => $search];
    $rootpages  = 'qv.customer.search';
    $search_string = $search;
} else {
    // $rootpages = 'qv.customer.index';
    $rootpages = 'qv.customer.index-pg';
    $search_o = null;
    $search = null;
}

$pageLimit = App::Config('PAGE-LIMIT'); //aP20; //$this->getParameter('page-limit');

$layout = ToolKit::paginateExt(
    "Client",
    $company,
    $search_o,
    $pageLimit,
    $page,
    ['name' => 'ASC']
);

$Title = 'Customers';
$company = true;
$pagination = $layout['pagination'];
$Items      = $layout['pageItems'];
$pages      = $layout['pages'];
$Fields     = Client::__GetFieldsClients();

