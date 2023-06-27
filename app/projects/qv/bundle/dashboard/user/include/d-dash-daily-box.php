<?php

[$dailyReport, $dueReport] = TimeEntryRepository::fetchDailyReport(
    $reportday, 
    $company, 
    $developer);

$monthlyReport = TimeEntryRepository::fetchMonthlyReport( 
    $reportday, 
    $company, 
    $developer);

$today      = $reportday->format('d/m/Y');

$yesterday  = clone $reportday;
$yesterday->modify('-1 days');
$say_yesterday  = $yesterday->format('l d/m/y');

$due_date = clone $reportday;
$due_date->modify('+1 days');
$due_date = $due_date->format('d/m/Y');

$say_month  = $reportday->format('F Y');

$h1 = '3';
$h2 = '4';
