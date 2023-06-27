
<?php
// dd("language ROUTER");
$rout = new ROUTER;
$rout
->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.language') // 3-d parameter -> projects.qv:bundle.t-time@index
        ->Prefix('qv.language') // 1st parameter
        
->Add('',  'qv/language',      'index')
->Add('index',  'qv/language/index',      'index')
->Add('edit',   'qv/language/{id}/edit',  'edit')

->Add('update-basic', 'qv/language/update-1', 'action.update-basic')
->Add('filter', 'qv/language/filter',     'index')
->Add('search', 'qv/language/search',     'index')

// ->Add('xindex', 'qv/t-time/xindex', 'index')
// ->Add('filter', 'qv/t-time/filter', 'index')
// ->Add('makeinvoices', 'qv/t-time/makeinvoices', 'actions.makeinvoices')

// // ->Add('index-pg', 'qv/t-time/{page}', 'index')
// ->Add('xindex-pg', 'qv/t-time/xindex/{page}', 'index')
// ->Add('index-pg', 'qv/t-time/index/{page}', 'index')

    ;

// qv.company.new
// path('mainland')

