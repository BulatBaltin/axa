<?php
// dd("product ROUTER");
$rout = new ROUTER;
$rout
->Project('projects.rehab') // 3-d parameter -> projects.qv:bundle.project@index
    ->Module('bundle.trans') // 3-d parameter -> projects.qv:bundle.t-time@index
        ->Prefix('rehab.trans') // 1st parameter
        
->Add('', 'rehab/trans', 'index')
->Add('translate-data',  'rehab/trans/translate-data',    'action.translate')
->Add('fill-data',  'rehab/trans/fill-data',    'action.fill-data')
->Add('update',     'rehab/trans/update',       'action.update')
;