<?php
$boss = User::GetUser();
$company = User::getCompany($boss);

if (!$company) {
    return UrlHelper::Redirect('qv.dashboard.company.new');
}

$dev_hash   = REQUEST::getParam('id',false, true);
$developer  = User::findOneBy(['hash' => $dev_hash]);
if (!$developer) {
    // throw new Exception('developer not found ID ' . $dev_hash);
    return UrlHelper::Redirect('404');
}
$developer_id   = $developer['id'];
$hash           = $developer['hash'];

// dd($hash, $dev_hash);

$dashData = InvoiceGoodRepository::getInvoicedHoursMonsDevs($company, $developer);

$now = new DateTime();
$start_date = $now; // $dashData['LastUpdate'];
$TimeRefresh = $start_date->format('d-m-Y H:i:s');
$date1 = new DateTime('first day of this month');
$saymonths = [
    $date1->format('F-Y'),
    $date1->modify("-1 month")->format('F-Y'),
    $date1->modify("-1 month")->format('F-Y'),
    $date1->modify("-1 month")->format('F-Y'),
];
foreach ($saymonths as $key => $month) {
    $parts = explode('-', $month);
    $saymonths[$key] = ll($parts[0]) . '-' . $parts[1];
}
$data = [];
$data3 = [];
$maxx = 0;
$total = [];
$totalThisMonth = [
    'q_all'=>0, 
    'q_submitted'=>0, 
    'q_lost'=>0, 
    'q_not_paid'=>0
];
if($dashData) {
    foreach($dashData as $row) {
        if(isset($row['mon'])) {
            $data[$row['mon']] = $row;
        }; 
    }
}

for ($i = 0; $i < 4; $i++) {
    if(!isset($data["$i"])) {
        $total          = 0;
        $not_invoiced   = 0;
        $invoiced_task_done = 0;
        $nonbillable    = 0;
        $invoiced_not_paid = 0;
        // $data3[] = 0;

    } else {

        $oneMonth = $data["$i"];
        $maxx = max( $maxx, $oneMonth['q_all']);
        $total = $oneMonth['q_all'];
        $invoiced_task_done = $oneMonth['q_submitted'];
        $invoiced_not_submitted = $oneMonth['q_not_submitted'];
        $invoiced_not_ready = $oneMonth['q_not_ready'];
        $invoiced_not_paid = $invoiced_not_submitted + $invoiced_not_ready;
        $nonbillable = $oneMonth['q_lost'];
        // $not_invoiced = $oneMonth['q_not_invoiced'];
        $not_invoiced = $total - $invoiced_task_done - $nonbillable ;

        $total = round($total,2);
        $not_invoiced = round($not_invoiced,2);
        $invoiced_task_done = round($invoiced_task_done,2);
        $nonbillable = round($nonbillable,2);
        

    }
    $data3[] = $total;
    $data3[] = $invoiced_task_done;
    $data3[] = $not_invoiced;
    $data3[] = $nonbillable;
    // $data3[] = round($invoiced_not_paid,2);
    if($i == 0) {
        $totalThisMonth = [
            'q_all'=>$total, 
            'q_submitted'=>$invoiced_task_done, 
            'q_lost'=>$nonbillable, 
            'q_not_paid'=>$invoiced_not_paid
        ];
    }
// }
}
$maxx = $maxx == 0 ? 1 : $maxx;
$multy = 270 / $maxx;
$data3_days = [$saymonths[0], $saymonths[1], $saymonths[2], $saymonths[3]]; // ???

$reportday = new DateTime('yesterday');
// $str_reportday = $reportday->format('d/m/Y');
$str_reportday = $reportday->format('Y-m-d');
$due_date = clone $reportday;
$due_date->modify('+1 days');
$say_month      = $reportday->format('F Y');
    
// [$dailyReport, $dueReport] = TimeEntryRepository::fetchDailyReport($yesterday, $company, $developer);
    
// [$weeklyReport, $weeklyTaskReport] = TimeEntryRepository::fetchWeeklyReport( $reportday, $company, $developer);

// $reportMon = new DateTime();
// $monthlyReport = TimeEntryRepository::fetchMonthlyReport($reportday, $company, $developer);      

$date1_month = ToolKit::firstDayOfMonth($now);
$date2_month = ToolKit::lastDayOfMonth($now);

$date1_month = $date1_month->format('d M Y');
$date2_month = $date2_month->format('d M Y');

$canvas_clr = sprintf("#%02x%02x%02x%02x", 255, 180, 0, 0); // yellow rim
$data_colors = [
    "#005942", "#6E3EB7", "#912A5B", "#8B9142", "#FF963F", $canvas_clr
];

$session = new DataLinkSession(); //->set('task_host', REQUEST::getUri());
$session->task_host = REQUEST::getUri();

$keys = Trackingmap::findCredentials('company', $company, 'Teamwork', $company['id']);
if($keys) {
    $site_root = $keys['key1']; //'ibl82';
} else {
    $site_root = '';
}

$title  = ll('Developer Dashboard');
$data = $data3;
$show_total = 0; // Yes, total bar
$series = 3;
$xspace = 35;
$developer_site = true; // just to define it
$dashboard      = true; // just to define it

$payhours_style = 1; // 1-Full version; 2-Brief ([4])
$today = date('d/m/Y');
$importRows = [];
$task_host  = [];

