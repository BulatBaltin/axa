
<?php
// dd("TASKLIST ROUTER");
$rout = new ROUTER;
$rout
->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.tasklist') // 3-d parameter -> projects.qv:bundle.t-time@index
        ->Prefix('qv.tasklist') // 1st parameter
        
->Add('',  'qv/tasklist',      'index')
->Add('index',  'qv/tasklist/index',      'index')
->Add('filter', 'qv/tasklist/filter',     'index')
->Add('search', 'qv/tasklist/search',     'index')
->Add('edit',   'qv/tasklist/{id}/edit',  'edit') // path('qv.project.edit',['id'=>$id])
->Add('map-customer', 'qv/tasklist/{id}/map-customer',  'action.map-customer') // path('qv.project.edit',['id'=>$id])
->Add('update-basic', 'qv/tasklist/update-1', 'action.update-basic') // path('qv.project.edit',['id'=>$id])

// ->Add('xindex', 'qv/t-time/xindex', 'index')
// ->Add('filter', 'qv/t-time/filter', 'index')
// ->Add('makeinvoices', 'qv/t-time/makeinvoices', 'actions.makeinvoices')

// // ->Add('index-pg', 'qv/t-time/{page}', 'index')
// ->Add('xindex-pg', 'qv/t-time/xindex/{page}', 'index')
// ->Add('index-pg', 'qv/t-time/index/{page}', 'index')

    ;

// qv.company.new
// path('mainland')

