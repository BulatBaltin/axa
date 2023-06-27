<?

$mssg       = REQUEST::getParam('mssg');
$page       = REQUEST::getParam('page', 1);
$search     = REQUEST::getParam('search', '');
$mssg       = REQUEST::getParam('mssg', '');

$root       = 'qv.task';
$routeName  = REQUEST::getUri(); //$request->attributes->get('_route');
$session = new DataLinkSession();

if (strpos($routeName, 'tasks/index') !== false) {
    $uri_old = $session->get('task_host');
    if($uri_old and strpos($uri_old, 'task') !== false) {
        $session->remove('task_host');
        return UrlHelper::Redirect( $uri_old );
    } else {
        return UrlHelper::RedirectRoute('qv.task.index');
    }
}    

$session->set('task_host', REQUEST::getUri());

$pageLimit = App::Config('PAGE-LIMIT'); //$this->getParameter('page-limit');
$params = [];
$search_string = '';
$search_o = [];

$status = '';
$tasklist_id = 0;
$customer_id = 0;

$taskCluster = []; //new TaskListCluster;

if (strpos($routeName, 'task/filter') !== false) {

    $search         = REQUEST::getParam('search');
    $tasklist_id    = REQUEST::getParam('tasklist_id');
    $projecten_id   = REQUEST::getParam('projecten_id');
    $user_id        = REQUEST::getParam('user_id');
    $customer_id    = REQUEST::getParam('customer_id');
    $status         = REQUEST::getParam('status');

    if (!$customer_id and !$search and !$tasklist_id and !$user_id and $status == '') {
        return UrlHelper::RedirectRoute('qv.task.index');
    }

    if ($search) {
        $search_o['and'][] = ['fields' => [
            'task'  => "%" . $search . "%",
            'tid'   => "%" . $search . "%"
        ], 'operation' => 'LIKE'];

        $search_string = $search;
        $params['search'] = $search; // part of URL parameters
    }    

    if ($status) {
        $taskCluster['status'] = $status;
        $status = $status == 1;
        $search_o['and'][] = ['fields' => ['completed' => $status], 'operation' => '='];
        $params['status'] = $status;
    }
    if ($customer_id) {
        // $customer = Client::find($customer_id);
        $taskCluster['customer_id'] = $customer_id; //$customer['id'];
        $search_o['and'][] = ['fields' => ['customer_id' => $customer_id], 'operation' => '='];
        $params['customer_id'] = $customer_id;
    }
    // if ($user_id) {
    //     // $developer = User::find($user_id);
    //     // dd($user_id, $developer['name']);
    //     $taskCluster['user'] = $user_id; //$developer['id'];
    //     $search_o['and'][] = ['fields' => ['user_id' => $user_id], 'operation' => '='];
    //     $params['user_id'] = $user_id;
    // }
    if ($tasklist_id) {
        // $tasklist = Tasklist::find($tasklist_id);
        $taskCluster['tasklist_id'] = $tasklist_id;
        $search_o['and'][] = ['fields' => ['project_id' => $tasklist_id], 'operation' => '='];
        $params['tasklist_id'] = $tasklist_id;
    }
    if ($projecten_id) {
        $taskCluster['projecten_id'] = $projecten_id;
        $search_o['and'][] = ['fields' => ['projecten_id' => $projecten_id], 'operation' => '='];
        $params['projecten_id'] = $projecten_id;
    }
    $rootpages  = $root . '.filter';
} else {

    $rootpages = $root . '.index';
    $search_o = null;
    $search = null;
}

try {
    //code...

$layout = ToolKit::paginateExt(
    "Task",
    [
        'where' => "u.company_id = :company",
        'params' => ['company' => $company['id']],
        'join' => [
            ['table' => 'client', 'alias'=>'c', 'on' => 'u.customer_id = c.id', 'select'=>'c.name as customer_name'],
            ['table' => 'project', 'alias'=>'p', 'on' => 'u.project_id = p.id', 'select'=>'p.name as tasklist_name'],
            ['table' => 'projecten', 'alias'=>'n', 'on' => 'u.projecten_id = n.id', 'select'=>'n.name as projecten_name'],
            ]
    ],
    $search_o,
    $pageLimit,
    $page,
    ['stop'=>'DESC']
);

} catch (Exception $e) {
    echo DataBase::$sql;
    dd($e->getMessage());
} 

$keys = Trackingmap::findCredentials('company', $company, 'Teamwork', $company['id']);
if($keys) {
    $site_root = $keys['key1']; //'ibl82';
} else {
    $site_root = '';
}

$form = new TaskIndexType( $taskCluster);
$Title = 'Tasks';

$pagination = $layout['pagination'];
$pages      = $layout['pages'];
$Items      = $layout['pageItems'];

$Fields     =
[
    // ['label' => 'Task',      'name' => 'task'],
    ['label' => 'Project',      'name' => 'projecten_name'],
    ['label' => 'Task lists',   'name' => 'tasklist_name'],
    ['label' => 'Customer',     'name' => 'customer_name'],
    // ['label' => 'Parent Task', 'name' => 'parentTid'],
    ['label' => 'Hours',        'name' => 'quantity'],
    ['label' => 'Estimated Hours',  'name' => 'planquantity'],
    ['label' => 'Time Start',   'name' => 'start',  'date' => true],
    ['label' => 'Time Stop',    'name' => 'stop',   'date' => true],
];


    //     $parms = [
    //         'params'     => $params,
    //         'site_root'  => $site_root,
    //         'search'     => $search,
    //         'search_string'=> $search_string,
    //         'root'       => $this->root
    //     ];
    //     if ($mssg) {
    //         $parms['mssg'] = $mssg;
    //     }

    //     return $this->render('tasks/index.html.twig', $parms);
    // }

