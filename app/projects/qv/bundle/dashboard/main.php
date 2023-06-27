<?
$boss = User::GetUser();
$company = User::getCompany($boss);
if (!$company) {
    return UrlHelper::Redirect('qv.company.new');
}

$importRows = Transactions::getImportLayout($company);

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

$dashData = InvoiceGood::getInvoicedHoursMons($company);

$now = new DateTime();
$start_date = $now; // $dashData['LastUpdate'];
$TimeRefresh = $start_date->format('d-m-Y H:i:s');

$data = [];
$data3 = [];
$maxx = 0;

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
        // $not_invoiced = $oneMonth['q_not_invoiced'];
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
        $data3[] = $invoiced_task_done;
        $data3[] = $not_invoiced;
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

include(ROUTER::ModulePath().'assets/patch/fx-hours-controller.php');

$session = new DataLinkSession(); //->set('task_host', REQUEST::getUri());
$session->task_host = REQUEST::getUri();

$nowYear    = (new DateTime())->format('Y');
$date1_p    = new DateTime($nowYear . "-01-01");
$date1_b    = new DateTime($nowYear . "-01-01");
$date_now   = new DateTime();
$date1_pie  = $date1_p->format('d M Y');
$date2_pie  = $date_now->format('d M Y');
$date1_bars = $date1_b->format('d M Y');
$date2_bars = $date_now->format('d M Y');

$dinvoices = InvoiceRepository::readInvoiceData($date1_b, $date_now, $company);

[ $_date1, $_date2, $say_period ] = ToolKit::getPeriodParams( 'this-month' );
$this_month = (new DateTime())->format('Y-m');
$disbalance = InvoiceGood::doTimeInvoiceMatch($company, $this_month);

$fx_form            = new CustomerDashUnmappedType;
$bal_period_form    = new BalancePeriodUnmappedType;
$hours_form         = new CustomerPeriodHoursType;

$title      = 'Dashboard';
$dashboard_tag  = true; // to draw a border around 'Dashboard'
$data       = $data3;
$series     = 4;
$show_total = 0; // Yes, total bar
$xspace     = 25;
$today      = date('d/m/Y');
$str_today  = date('Y-m-d');

// dump('main: tagline ? ' . isset($tagline));
// dump('dashboard = ' . $dashboard);
// die;