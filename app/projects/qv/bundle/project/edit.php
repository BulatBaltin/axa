<?

// use form\ProjectenPointType;
// use form\ProjectenTaskType;
// use form\ProjectenType;

$proj_id    = REQUEST::getParam('id');
$projecten  = Project::find($proj_id);

$form       = new ProjectenType;
$form->SetData($projecten);
$form->action = route('qv.project.update',['id' => $proj_id]);

// $fields = $form->CreateView();
// dd($fields);
// $form->handleRequest($request);

// if ($form->isSubmitted() && $form->isValid()) {
//     $this->getDoctrine()->getManager()->flush();

//     return $this->redirectToRoute('qv.project.index');
// }

// ComboArray();
// $task = new Task;

$task_list  = Task::fetchTasksByCustomer($projecten['customer_id']);
$formTask = new ProjectenTaskType(null, $task_list); //> $formTask->createView(),

// $tasks  = Task::findBy(['projecten' => $projecten], null, null, ['id','tid','task']);

// dd($task_list);
// $formTask = $this->createForm(TaskIdType::class, $task,[
//     'task_list' => $task_list
// ]);
// // $formTask->get('otask')->setData( $task );

// $projectenPoints = $repoPoints->findBy(['projecten' => $projecten]);

// $point = new ProjectenPoints;
// $formPoint = $this->createForm(ProjectenPointType::class, $point);

// // $form->handleRequest($request);

// return $this->render('projecten/edit.html.twig', [

$Title      = 'Edit Projecten';
// $points     = []; //$projectenPoints,
// $project    = $projecten;

$formPoint  = new ProjectenPointType;
