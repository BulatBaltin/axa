
<?php
// dd("rules ROUTER");
$rout = new ROUTER;
$rout
->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.rules') // 3-d parameter -> projects.qv:bundle.t-time@index
        ->Prefix('qv.rules') // 1st parameter
        
->Add('',  'qv/rules',      'index')
->Add('tw',  'qv/rules/tw', 'index-tw')
->Add('index',  'qv/rules/index', 'index')
->Add('index-tw',  'qv/rules/index-tw', 'index-tw')

->Add('edit',   'qv/rules/{id}/edit',  'edit')

->Add('filter', 'qv/rules/filter',     'index')
->Add('search', 'qv/rules/search',     'index')

->Add('update-basic', 'qv/rules/update-1', 'action.update-basic') // path('qv.project.edit',['id'=>$id])

// ->Add('xindex', 'qv/t-time/xindex', 'index')
// ->Add('filter', 'qv/t-time/filter', 'index')
// ->Add('makeinvoices', 'qv/t-time/makeinvoices', 'actions.makeinvoices')

// // ->Add('index-pg', 'qv/t-time/{page}', 'index')
// ->Add('xindex-pg', 'qv/t-time/xindex/{page}', 'index')
// ->Add('index-pg', 'qv/t-time/index/{page}', 'index')

    ;

// qv.company.new
// path('mainland')

