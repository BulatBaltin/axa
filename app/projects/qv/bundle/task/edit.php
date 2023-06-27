<?

$task_id    = REQUEST::getParam('id');
if($task_id == 0) {
    $task       = Task::GetDefault();
    $is_new = true;
} else {
    $task       = Task::find($task_id);
    $is_new = false;
}

$form           = new TaskEditType($task);

$form->action   = route('qv.task.update',['id' => $task_id]);
$title = $is_new ? 'Create task' : "Edit task";
$session = new DataLinkSession;
$task_host = $session->has('task_host') ? $session->get('task_host') : 
ROUTER::get_url('qv.task.index');

$pg11_list      = ['task','source', 'tid'];
$pg11_list_2    = ['projecten', 'project', 'completed'];
$pg12_list      = ['projectname','projectid', 'billable'];
$pg2_list_1 = ['planstart', 'planstop', 'estimated'];
$pg2_list_2 = ['planduration', 'planquantity' ];
$pg3_list_1 = ['start', 'stop', 'duedate'];
$pg3_list_2 = ['duration', 'quantity'];

$root = 'qv.task';
$rootindex = $root . '.index';
$rootpages = $root . '.index';
$event = '5';

$tag_name = 'open tasks';
$rule_list = 'rule-list';
$email_list = 'email-list';
$default_limit = 10000;

$tasks_uri = $session->has('tasks_uri') ? $session->get('tasks_uri') : '';

$keys = Trackingmap::findCredentials('company', $company, 'Teamwork', $company['id']);
if($keys) {
    $site_root = $keys['key1']; //'ibl82';
} else {
    $site_root = '';
}

$titleplus  = '';
$delete     = true;
$object     = $task;
