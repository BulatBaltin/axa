<?
// use form\ProjectenTaskType;
// $dlf = New DataLinkForm();
$tid    = REQUEST::getParam('tid');

try {
    $task = Task::findOneBy(['tid' => $tid]);
    if($task) {

        $task_list = Task::fetchTasksByCustomer($task['customer_id']);
        $formTask = New ProjectenTaskType( $task, $task_list ); 
        $formHtml = module_partial('include/_form_add_task.html.php', [
            'formTask' => $formTask 
        ], true);
        $contents = [
            'return' => 'success', 
            'taskHtml' => $formHtml 
            ];
    } else {
        $contents = [
            'return' => 'success', 
            'taskHtml' => 'Task not found '. $tid
            ];
    }

} catch(Exception $e) {
    $contents = ['return' => 'error', 'mssg' => $e->getMessage()];
}

Json_Response($contents);
