<?php

$boss = User::getUser();
$company = User::getCompany($boss);
if (!$company) {
    if (!$company) throw new \Exception('Define company!');
}
$period = REQUEST::getParam('period');
$client_hash = REQUEST::getParam('id',false, true);
$customer = Client::findOneBy(['hash' => $client_hash]);

// dd($customer);

if (!$customer) throw new Exception('Customer not found ID ' . $client_hash);

[$startDay, $endDay, $say_period] = ToolKit::getPeriodParams($period);

$t_body = module_partial('customer/include/c-period-body',
[
    'startDay'  =>$startDay, 
    'endDay'    =>$endDay, 
    'company'   =>$company, 
    'customer'  =>$customer,
    'lang' => 'en'
], true 
);

$contents = ['t_body' => $t_body, 'say_period' => $say_period ];

Json_Response($contents);

