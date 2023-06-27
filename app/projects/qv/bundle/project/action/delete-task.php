<?

$tid        = REQUEST::getParam('tid');
$proj_id    = REQUEST::getParam('id');
try {
    $task = Task::findOneBy(['tid' => (int)$tid]);
    if($task) {

        $task['projecten_id'] = null;
        Task::Commit($task, ['projecten_id']);

        // dd(DataBase::$sql);
        // UPDATE tasks SET projecten_id = '0' WHERE tasks.id =382
        $projecten  = Project::find($proj_id);
        $htmlTasks = module_partial('include/_tasks-table', [
            'project' => $projecten
        ], true);
        $contents = [
            'return' => 'success', 
            'htmlTasks' => $htmlTasks
        ];

    } else {
        $contents = [
            'return' => 'success', 
            'htmlTasks' => 'Task not found '. $tid];
    }
} catch(Exception $e) {
    $contents = ['return' => 'error', 'mssg' => $e->getMessage()];
}

Json_Response($contents);
