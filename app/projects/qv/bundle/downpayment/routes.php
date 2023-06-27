
<?php
// dd("downpayment ROUTER");
$rout = new ROUTER;
$rout
->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.downpayment') // 3-d parameter -> projects.qv:bundle.t-time@index
        ->Prefix('qv.downpayment') // 1st parameter
        
->Add('',  'qv/downpayment',      'index')
->Add('index',  'qv/downpayment/index', 'index')
->Add('edit',   'qv/downpayment/{id}/edit',  'edit')
->Add('filter', 'qv/downpayment/filter',     'index')
->Add('search', 'qv/downpayment/search',     'index')

->Add('update-basic', 'qv/downpayment/update-1', 'action.update-basic') // path('qv.project.edit',['id'=>$id])

// ->Add('xindex', 'qv/t-time/xindex', 'index')
// ->Add('filter', 'qv/t-time/filter', 'index')
// ->Add('makeinvoices', 'qv/t-time/makeinvoices', 'actions.makeinvoices')

// // ->Add('index-pg', 'qv/t-time/{page}', 'index')
// ->Add('xindex-pg', 'qv/t-time/xindex/{page}', 'index')
// ->Add('index-pg', 'qv/t-time/index/{page}', 'index')

    ;

// qv.company.new
// path('mainland')

