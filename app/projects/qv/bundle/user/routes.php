
<?php
$rout = new ROUTER;
$rout
    ->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
        ->Module('bundle.user') // 3-d parameter -> projects.qv:bundle.user@index
        ->Prefix('qv.user') // 1st parameter
        
->Add('index', 'qv/user', 'index') // qv.project.index, qv/project, projects.qv:bundle.project@index 
->Add('login-enter','post:qv/user/log-in', 'login.login')
->Add('login',      'qv/user/login',       'login.a-login')
->Add('logout',     'qv/user/logout',      'login.logout')
->Add('index-pg',   'qv/user/{page}',   'index') // qv.project.index, qv/project, projects.qv:bundle.project@index 
->Add('edit', 'qv/user/{id}/edit', 'edit') // path('qv.project.edit',['id'=>$id])
->Add('update', 'post:qv/user/{id}/{part}/update', 'action.update') // 'post'
->Add('upload_avatar', 'post:qv/user/{id}/upload_avatar', 'action.upload_avatar') // разберись с 'post'
// ->Add('tracking', 'post:qv/user/{id}/tracking', 'action.tracking') // 'post'
->Add('tracking',   'post:qv/user/tracking',    'action.tracking')

->Add('find-task', 'post:qv/user/{tid}/find-task', 'action.find-task') // разберись с 'post'
->Add('add-task', 'post:qv/user/{id}/{tid}/add-task', 'action.add-task')
->Add('delete-task', 'post:qv/user/{id}/{tid}/delete-task', 'action.delete-task')
->Add('add-point', 'post:qv/user/{id}/add-point', 'action.add-point')
->Add('delete-point','post:qv/user/{id}/{pid}/delete-point', 'action.delete-point')
    ;

// qv.company.new
// path('mainland')

