
<?php
$rout = new ROUTER;
$rout
    ->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
        ->Module('bundle.project') // 3-d parameter -> projects.qv:bundle.project@index
        ->Prefix('qv.project') // 1st parameter
        
->Add('index', 'qv/project', 'index') // qv.project.index, qv/project, projects.qv:bundle.project@index 
->Add('edit', 'qv/project/{id}/edit', 'edit') // path('qv.project.edit',['id'=>$id])
->Add('update', 'post:qv/project/{id}/update', 'action.update') // разберись с 'post'
->Add('find-task', 'post:qv/project/{tid}/find-task', 'action.find-task') // разберись с 'post'
->Add('add-task', 'post:qv/project/{id}/{tid}/add-task', 'action.add-task')
->Add('delete-task', 'post:qv/project/{id}/{tid}/delete-task', 'action.delete-task')
->Add('add-point', 'post:qv/project/{id}/add-point', 'action.add-point')
->Add('delete-point','post:qv/project/{id}/{pid}/delete-point', 'action.delete-point')
    ;

// qv.company.new
// path('mainland')

