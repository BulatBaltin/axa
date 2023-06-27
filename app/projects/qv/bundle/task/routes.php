
<?php
$rout = new ROUTER;
$rout
->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.task') // 3-d parameter -> projects.qv:bundle.task@index
        ->Prefix('qv.task') // 1st parameter
        
->Add('', 'qv/task', 'index')
->Add('index-opened', 'qv/task/index-opened',           'report.index-opened')
->Add('index-not-mapped', 'qv/task/index-not-mapped',   'report.index-not-mapped')
->Add('opened-report', 'qv/task/opened-report',         'action.opened-report')
->Add('not-mapped-report', 'qv/task/not-mapped-report', 'action.not-mapped-report')
->Add('index', 'qv/task/index', 'index')
->Add('filter', 'qv/task/filter', 'index')
->Add('edit', 'qv/task/{id}/edit', 'edit')
->Add('save', 'qv/task/save', 'action.update')
    ;

// qv.company.new
// path('mainland')

