
<?php
// dd("transaction ROUTER");
$rout = new ROUTER;
$rout
->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.transaction') // 3-d parameter -> projects.qv:bundle.t-time@index
        ->Prefix('qv.transaction') // 1st parameter
        
->Add('',  'qv/transaction',      'index')
->Add('index',  'qv/transaction/index',      'index')
->Add('filter', 'qv/transaction/filter',     'index')
->Add('search', 'qv/transaction/search',     'index')
->Add('edit',   'qv/transaction/{id}/edit',  'edit')

->Add('update-basic', 'qv/transaction/update-1', 'action.update-basic') // path('qv.project.edit',['id'=>$id])

// ->Add('xindex', 'qv/t-time/xindex', 'index')
// ->Add('filter', 'qv/t-time/filter', 'index')
// ->Add('makeinvoices', 'qv/t-time/makeinvoices', 'actions.makeinvoices')

// // ->Add('index-pg', 'qv/t-time/{page}', 'index')
// ->Add('xindex-pg', 'qv/t-time/xindex/{page}', 'index')
// ->Add('index-pg', 'qv/t-time/index/{page}', 'index')

    ;

// qv.company.new
// path('mainland')

