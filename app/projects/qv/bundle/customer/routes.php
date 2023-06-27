
<?php
$rout = new ROUTER;
$rout
    ->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
        ->Module('bundle.customer') // 3-d parameter -> projects.qv:bundle.customer@index
        ->Prefix('qv.customer') // 1st parameter
        
->Add('index', 'qv/customer', 'index') // qv.project.index, qv/project, projects.qv:bundle.project@index 
->Add('index-pg', 'qv/customer/{page}', 'index') // qv.project.index, qv/project, projects.qv:bundle.project@index 
->Add('edit', 'qv/customer/{id}/edit', 'edit') // path('qv.project.edit',['id'=>$id])
->Add('update', 'post:qv/customer/{id}/{part}/update', 'action.update') // разберись с 'post'

->Add('find-task', 'post:qv/customer/{tid}/find-task', 'action.find-task') // разберись с 'post'
->Add('add-task', 'post:qv/customer/{id}/{tid}/add-task', 'action.add-task')
->Add('delete-task', 'post:qv/customer/{id}/{tid}/delete-task', 'action.delete-task')
->Add('add-point', 'post:qv/customer/{id}/add-point', 'action.add-point')
->Add('delete-point','post:qv/customer/{id}/{pid}/delete-point', 'action.delete-point')
    ;

// qv.company.new
// path('mainland')

