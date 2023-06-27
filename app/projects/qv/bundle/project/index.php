<?

$boss       = User::GetUser();
$company    = User::GetCompany($boss);

$data = Project::findBy([ 'company_id' => $company['id'] ], ['id'=>'ASC'], ['customer_id'=>'client']);

$projs = [];
foreach($data as $projecten) {

///COME-BACK !!!            
    $tasks = Task::findBy(['projecten' => $projecten]);

// dd($tasks);    
    // array of ids
    $tasks_ext = Task::GetTasksWithSubtasks($tasks, $company);
    $tasks_total = InvoiceGood::GetProjectenTasksData($tasks_ext, $company, $projecten['budget']); 

    $projs[] = [
        'projecten' => $projecten,
        'percent' => $tasks_total['percent'],
        'hours' => $tasks_total['q_all'],
        'hoursleft' => $tasks_total['q_not_invoiced']
    ];

///COME-BACK !!!            
}
$search_string = "";
$Title = "Projecten list";
$projectens = $projs;
