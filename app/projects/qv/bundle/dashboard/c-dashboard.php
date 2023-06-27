<?php
$boss = User::GetUser();
$company = User::getCompany($boss);
if (!$company) {
    return UrlHelper::Redirect('qv.dashboard.company.new');
}

$client_hash = REQUEST::getParam('id',false, true);
$customer = Client::findOneBy(['hash' => $client_hash]);

if (!$customer) throw new Exception('Customer not found ID ' . $client_hash);

$customer_id    = $customer['id'];
$hash           = $customer['hash'];

$dashData = InvoiceGood::getInvoicedHoursMons($company, $customer);

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
    // $saymonths[$key] = $this->lingo->trans($parts[0]) . '-' . $parts[1];
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
        } else {
            $data['total'] = $row;
        }; 
    }
}

for ($i = 0; $i < 5; $i++) {
    if( $i == 4 and isset($data["total"])) {
        $oneMonth = $data["total"];

    } elseif(!isset($data["$i"]) or !isset($data["total"])) {
        $total          = 0;
        $not_invoiced   = 0;
        $invoiced_task_done = 0;
        $nonbillable    = 0;
        $invoiced_not_paid = 0;
        $oneMonth = false;
        
    } else {
        
        $oneMonth = $data["$i"];
        $maxx = max( $maxx, $oneMonth['q_all']);
    }
    if($oneMonth) { // There are data
        $total = $oneMonth['q_all'];
        $invoiced_task_done = $oneMonth['q_submitted'];
        $invoiced_not_submitted = $oneMonth['q_not_submitted'];
        $invoiced_not_ready = $oneMonth['q_not_ready'];
        $invoiced_not_paid = $invoiced_not_submitted + $invoiced_not_ready;
        $nonbillable = $oneMonth['q_lost'];
        $not_invoiced = $total - $invoiced_task_done - $nonbillable ;

        $total = round($total,2);
        $not_invoiced = round($not_invoiced,2);
        $invoiced_task_done = round($invoiced_task_done,2);
        $nonbillable = round($nonbillable,2);
    }

    if($i == 4) {
        $totalThisMonth = [
            'q_all'=>$total, 
            'q_submitted'=>$invoiced_task_done, 
            'q_lost'=>$nonbillable, 
            'q_not_paid'=>$invoiced_not_paid
        ];
    } else {
        
        $data3[] = $total;
        $data3[] = $not_invoiced;
        $data3[] = $invoiced_task_done;
        $data3[] = $nonbillable;
    }
}
$maxx = $maxx == 0 ? 1 : $maxx;
$multy = 270 / $maxx;
$data3_days = [$saymonths[0], $saymonths[1], $saymonths[2], $saymonths[3]];

$canvas_clr = sprintf("#%02x%02x%02x%02x", 255, 180, 0, 0); // yellow rim
$data_colors = [
    "#005942", "#6E3EB7", "#912A5B", "#8B9142", "#FF963F", $canvas_clr
];

[$startDay, $endDay, $say_period] = ToolKit::getPeriodParams( 'all-data' );

$periodReport = TimeEntry::getPeriodReportCustomer($startDay, $endDay, $company, $customer);

$lang = User::Lingo();

$date1_month = ToolKit::firstDayOfMonth($now);
$date2_month = ToolKit::lastDayOfMonth($now);

$date1_month = $date1_month->format('d M Y');
$date2_month = $date2_month->format('d M Y');

$payhours = InvoiceGood::GetAllHours($company, $customer, null );        

$period_form = new CustomerPeriodUnmappedType();

$session = new DataLinkSession();
$session->task_host = REQUEST::getUri();

$title  = ll('Dashboard');
// $hash   = $client_hash; // just to define it
$data = $data3;
$show_total = 1; // No total bar
$series = 2;
$xspace = 75;
$client_site = true; // just to define it
$customerObj = $customer;
$customer    = $customer['name'];
$dashboard   = true; // just to define it
$payhours_style = 1; // 1-Full version; 2-Brief ([4])
$today = date('d/m/Y');
$importRows = [];
$task_host  = [];
