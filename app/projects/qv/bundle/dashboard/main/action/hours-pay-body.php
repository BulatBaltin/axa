<?php
$boss = User::getUser();
$company = User::getCompany($boss);
if (!$company) {
    if (!$company) throw new \Exception('Define company!');
}

$period       = REQUEST::getParam('period');
$customer_id  = REQUEST::getParam('customer');

module_partial('main/include/dash-hours-to-pay-body', [
    'company'   => $company,
    'period'    => $period,
    'customer_id' => $customer_id
]);

exit;
