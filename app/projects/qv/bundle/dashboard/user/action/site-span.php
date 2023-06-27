<?php
// dd('I am here');

$boss = User::getUser();
$company = User::getCompany($boss);
if (!$company) {
    if (!$company) throw new \Exception('Define company!');
}

$dev_hash = REQUEST::getParam('id',0,true);
$developer = User::findOneBy(['hash' => $dev_hash]);
if (!$developer) throw new Exception('Developer not found');

$type = REQUEST::getParam('type');
$start_day = REQUEST::getParam('start_day');
if ($start_day)
    $reportday = DateTime::createFromFormat('Y-m-d', $start_day);
else
    $reportday = new DateTime;

$keys = Trackingmap::findCredentials('company', $company, 'Teamwork', $company['id']);
if($keys) {
$site_root = $keys['key1']; //'ibl82';
} else {
$site_root = '';
}
$params = [
    'reportday' => $reportday, 
    'company'   => $company, 
    'developer' => $developer,
    'site_root' => $site_root
];
// dd($params);

switch ( $type ) {
case 'd':
    module_partial('user/include/d-dash-daily-box', $params);
    exit;

case 'w':    
    module_partial('user/include/d-dash-weekly-box', $params);
    exit;

case 'm':    
    $say_month = $reportday->format('F Y');
    $view = module_partial('user/include/d-dash-monthly-box', $params, true);
    Json_Response(['view' => $view, 'say_month' => $say_month ]);

}

