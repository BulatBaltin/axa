<?php

[$employees, $periods] = TimeEntry::getEmployeeTimeData($startDate, $company, $span);

$active = true; //str_replace('-', '', $span);
$today = date('d/m/Y');

// $params = [
//     $active => true,
//     'employees' => $employees,
//     'periods' => $periods,
//     'today' => date('d/m/Y')
// ];
