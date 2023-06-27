<?
// dd('Module mollie');

$routes = new ROUTER;
$routes->
    Project('projects.testing') // 3-d parameter
        ->Module('mollie') // 3-d parameter
            ->Prefix('test.mollie') // 1-st parameter, adds 'test.'
    ->Add('pay', 'test/mollie/pay',     'pay-invoice-mollie')
    ; 
