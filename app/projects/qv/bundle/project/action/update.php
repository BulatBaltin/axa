<?
// use form\ProjectenType;

// $dlf = New DataLinkForm();

$proj_id    = REQUEST::getParam('id');
$projecten  = Project::find($proj_id);
$form       = new ProjectenType; //$this->createForm(ProjectenType::class, $projecten);
$form->redirect = route('qv.project.edit',['id' => $proj_id]);

Project::Flush($form, $projecten);

return UrlHelper::Redirect($form->redirect);
