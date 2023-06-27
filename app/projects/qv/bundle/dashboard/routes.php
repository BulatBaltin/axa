
<?php
$rout = new ROUTER;
$rout
    ->Project('projects.qv') // 3-d parameter -> projects.qv:bundle.dashboard@main
        ->Module('bundle.dashboard') // 3-d parameter -> projects.qv:bundle.dashboard@main
            ->Prefix('qv.dashboard')
->Add('', 'qv/dashboard', 'main') // qv.dashboard.main, qv/dashboard, projects.qv:bundle.dashboard@main 
->Add('main', 'qv/dashboard', 'main') // qv.dashboard.main, qv/dashboard, projects.qv:bundle.dashboard@main

// qv.dashboard.period-body
->Add('period-body', 'post:qv/dashboard/period-body', 'main.action.bal-period-body') 
->Add('site-span', 'post:qv/dashboard/site-span', 'main.action.site-span') 
->Add('hours-pay-body', 'post:qv/dashboard/hours-pay-body', 'main.action.hours-pay-body') 
->Add('fx-hours-body', 'post:qv/dashboard/fx-hours-body', 'main.action.fx-hours-body') 
->Add('import', 'post:qv/dashboard/import', 'main.action.import') 

            ->Prefix('qv.dash-customer')
->Add('', 'qv/dash-customer/{id}', 'c-dashboard') // qv.dashboard.main, qv/dashboard, projects.qv:bundle.dashboard@main 
->Add('site', 'qv/dash-customer/{id}', 'c-dashboard') // qv.dashboard.main, qv/dashboard, projects.qv:bundle.dashboard@main 

// qv.dashboard.period-body
->Add('period-body', 'post:qv/dash-customer/{id}/period-body', 'customer.action.task-period-body') 
->Add('site-span', 'post:qv/dash-customer/{id}/site-span', 'customer.action.site-span') 
->Add('hours-pay-body', 'post:qv/dash-customer/{id}/hours-pay-body', 'customer.action.hours-pay-body') 
->Add('fx-hours-body', 'post:qv/dash-customer/{id}/fx-hours-body', 'customer.action.fx-hours-body') 

            ->Prefix('qv.dash-dev')
->Add('',           'qv/dash-dev/{id}',                 'd-dashboard')
->Add('site',       'qv/dash-dev/{id}',                 'd-dashboard')
->Add('site-span',  'post:qv/dash-dev/{id}/site-span',  'user.action.site-span')


            ->Prefix('qv.home')
->Add('', 'qv', 'main') 
->Add('company.new', 'qv/dashboard/new-company', 'main') //BANG!
        
    ;

// qv.company.new
// path('mainland')

