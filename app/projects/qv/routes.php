
<?php

// Projects modules
ROUTER::ModuleRoute('qv.home',      'qv',               'projects.qv:bundle.dashboard');
ROUTER::ModuleRoute('qv.dashboard', 'qv/dashboard',     'projects.qv:bundle.dashboard');
ROUTER::ModuleRoute('qv.dash-customer', 'qv/dash-customer', 'projects.qv:bundle.dashboard');
ROUTER::ModuleRoute('qv.dash-dev',  'qv/dash-dev',      'projects.qv:bundle.dashboard');
ROUTER::ModuleRoute('qv.t-time',    'qv/t-time',        'projects.qv:bundle.trackedtime');
ROUTER::ModuleRoute('qv.invoice',   'qv/invoice',       'projects.qv:bundle.invoice');
ROUTER::ModuleRoute('qv.company',   'qv/company',       'projects.qv:bundle.company');

ROUTER::ModuleRoute('qv.project',   'qv/project',   'projects.qv:bundle.project');
ROUTER::ModuleRoute('qv.task',      'qv/task',      'projects.qv:bundle.task');
ROUTER::ModuleRoute('qv.rules',      'qv/rules',      'projects.qv:bundle.rules');
ROUTER::ModuleRoute('qv.downpayment',      'qv/downpayment',      'projects.qv:bundle.downpayment');
ROUTER::ModuleRoute('qv.tasklist',  'qv/tasklist',  'projects.qv:bundle.tasklist');
ROUTER::ModuleRoute('qv.product',   'qv/product',   'projects.qv:bundle.product');
ROUTER::ModuleRoute('qv.transaction',   'qv/transaction',   'projects.qv:bundle.transaction');
ROUTER::ModuleRoute('qv.language',  'qv/language',  'projects.qv:bundle.language');
ROUTER::ModuleRoute('qv.customer',  'qv/customer',  'projects.qv:bundle.customer');
ROUTER::ModuleRoute('qv.client',    'qv/client',    'projects.qv:bundle.customer');
ROUTER::ModuleRoute('qv.user',      'qv/user',      'projects.qv:bundle.user');

// ROUTER::Route('qv.dashboard.period-body', 'post:qv/dashboard/period-body', 'projects.qv:bundle.dashboard@main.action.bal-period-body');




