
<?php
$rout = new ROUTER;
$rout
->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.trackedtime') // 3-d parameter -> projects.qv:bundle.t-time@index
        ->Prefix('qv.t-time') // 1st parameter
        
->Add('index', 'qv/t-time', 'index')
->Add('xindex', 'qv/t-time/xindex', 'index')
->Add('filter', 'qv/t-time/filter', 'index')
->Add('makeinvoices', 'qv/t-time/makeinvoices', 'actions.makeinvoices')
->Add('get-invoices', 'qv/t-time/get-invoices', 'actions.get-invoices')

// ->Add('index-pg', 'qv/t-time/{page}', 'index')
->Add('xindex-pg', 'qv/t-time/xindex/{page}', 'index')
->Add('index-pg', 'qv/t-time/index/{page}', 'index')

    ;

// qv.company.new
// path('mainland')

