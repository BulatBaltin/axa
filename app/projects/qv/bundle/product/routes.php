
<?php
// dd("product ROUTER");
$rout = new ROUTER;
$rout
->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.product') // 3-d parameter -> projects.qv:bundle.t-time@index
        ->Prefix('qv.product') // 1st parameter
        
->Add('',  'qv/product',      'index')
->Add('index',  'qv/product/index',      'index')
->Add('filter', 'qv/product/filter',     'index')
->Add('search', 'qv/product/search',     'index')
->Add('edit',   'qv/product/{id}/edit',  'edit')

->Add('update-basic', 'qv/product/update-1', 'action.update-basic') // path('qv.project.edit',['id'=>$id])

// ->Add('xindex', 'qv/t-time/xindex', 'index')
// ->Add('filter', 'qv/t-time/filter', 'index')
// ->Add('makeinvoices', 'qv/t-time/makeinvoices', 'actions.makeinvoices')

// // ->Add('index-pg', 'qv/t-time/{page}', 'index')
// ->Add('xindex-pg', 'qv/t-time/xindex/{page}', 'index')
// ->Add('index-pg', 'qv/t-time/index/{page}', 'index')

    ;

// qv.company.new
// path('mainland')

