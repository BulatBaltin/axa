<?php

$say_month = $reportday->format('F Y');
$monthlyReport = TimeEntryRepository::fetchMonthlyReport($reportday, $company, $developer);
