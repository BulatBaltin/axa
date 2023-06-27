<?

$tasklist_id    = REQUEST::getParam('id');
if($tasklist_id == 0) {
    $tasklist       = Tasklist::GetDefault();
} else {
    $tasklist       = Tasklist::find($tasklist_id);
}
$form           = new TasklistEditType($tasklist);

$form->action   = route('qv.tasklist.update',['id' => $tasklist_id]);

$visibility     = chop($tasklist['visibility'] ?? '', ',');
$vis_workers_ids = explode(',', $visibility);

$vis_workers = [];
// dd($vis_workers_ids);
if(count($vis_workers_ids) > 1) {

    foreach ($vis_workers_ids as $worker_id) {
        $worker = User::find($worker_id);
        if ($worker) {
            $vis_workers[] = $worker;
        }
    }
}
// dd($form);

$title      = "Edit Task list";
$titleplus  = 'Edit project information below';
$isnew      = false;
$delete     = true; // should be defined

$root = 'qv.tasklist';
$rootindex = 'qv.tasklist.index';

$object    = $tasklist;
