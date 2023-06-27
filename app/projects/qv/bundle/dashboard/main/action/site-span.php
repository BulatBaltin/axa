<?php
$boss = User::getUser();
$company = User::getCompany($boss);
if (!$company) {
    if (!$company) throw new \Exception('Define company!');
}

$span       = REQUEST::getParam('span');
$start_day  = REQUEST::getParam('start_day');
if($start_day) 
    $startDate = DateTime::createFromFormat('Y-m-d', $start_day);
else
    $startDate = new DateTime;

module_partial('main/include/dash-table', [
    'startDate' => $startDate, 
    'company' => $company, 
    'span' => $span 
]);

exit;
