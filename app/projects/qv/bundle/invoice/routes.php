
<?php
$rout = new ROUTER;
$rout
->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.invoice') // 3-d parameter -> projects.qv:bundle.invoice@index
        ->Prefix('qv.invoice') // 1st parameter
        
->Add('delete',         'qv/invoice/delete/{id}',  'action.delete')
->Add('filter',         'qv/invoice/filter',    'index')
->Add('index',          'qv/invoice',           'index')
->Add('create',         'qv/invoice/create/{new}/{customer_id}', 'create')
->Add('edit',           'qv/invoice/edit/{id}', 'edit')
->Add('view',           'qv/invoice/view/{id}', 'view')
->Add('artikul.totals', 'post:qv/invoice/artikul-totals',   'action.artikul-totals')
->Add('artikul.price',  'post:qv/invoice/artikul-price',    'action.artikul-price')
->Add('vatcoeff',       'post:qv/invoice/vatcoeff',     'action.total-vatcoeff')
->Add('delete-item',    'post:qv/invoice/delete-item',  'action.delete-item')
->Add('deletelist',     'post:qv/invoice/deletelist',   'action.delete')
->Add('refreshgrid',    'post:qv/invoice/refreshgrid',  'action.refreshgrid')
->Add('save',           'post:qv/invoice/save',         'action.save')
->Add('reload',         'post:qv/invoice/reload/{id}',  'action.reload')
->Add('merge-invoices', 'post:qv/invoice/merge-invoices', 'action.merge-invoices')
    ;

// qv.company.new
// path('mainland')

