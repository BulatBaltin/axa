
<?php
$rout = new ROUTER;
$rout
    ->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
        ->Module('bundle.company') // 3-d parameter -> projects.qv:bundle.company@index
        ->Prefix('qv.company') // 1st parameter
        
->Add('profile', 'qv/company/{id}/profile', 'profile')
->Add('general', 'qv/company/general', 'general')
        

->Add('index', 'qv/company', 'index') // qv.project.index, qv/project, projects.qv:bundle.project@index 
->Add('index-pg', 'qv/company/{page}', 'index') // qv.project.index, qv/project, projects.qv:bundle.project@index 
->Add('update', 'post:qv/company/{id}/{part}/update', 'action.update') // 'post'
->Add('upload_avatar', 'post:qv/company/{id}/upload_avatar', 'action.upload_avatar') // разберись с 'post'
// ->Add('tracking', 'post:qv/company/{id}/tracking', 'action.tracking') // 'post'
->Add('tracking', 'post:qv/company/tracking', 'action.tracking') // 'post'
    ;

// qv.company.new
// path('mainland')

