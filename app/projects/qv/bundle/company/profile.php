<?php

$boss           = User::GetUser();
$boss_company   = User::GetCompany($boss);

$user_com_admin_id   = REQUEST::getParam('id');
// $user_com        = User::findOneBy(['hash' => $user_com_hash]);
$user_com  = User::find($user_com_admin_id);
if(!$user_com) {
    return UrlHelper::Redirect('404');
}

$root = 'qv.company.profile';
$company_id = $user_com ['company_id'];
$company = Company::find($company_id);

$session = new DataLinkSession();
$roles = $session->get('roles'); //object['Roles();

if (!$roles) {
    $roles = User::getRoles($user_com);
    $session->set('roles', $roles);
    $session->set('user', $user_com);
}
// $new_roles = $this->ajust_roles($roles);
$new_roles = User::map_roles($user_com, $roles);
// $em = $this['Doctrine()['Manager();
// if ($is_new) {
//     // It helped with managed state ...
//     $user_com = $em->merge($user_com);
// }

$accRows        = Accounting::findAll();
$timeRows       = Trackingapp::findBy([], ['pos' => "ASC"]); //All();
$timeRowsData   = Trackingmap::findBy([
    'company' => $company,
    'objecttype' => 'company',
    'objectid' => $company['id'],
]);
$trackData = [];
foreach ($timeRowsData as $tracking) {
    $trackData[$tracking['trackingname']] = $tracking;
}
$transRows = Translation::findAll();

$user_com['accrows'] = [];
$user_com['acclabels'] = [];
$user_com['timerows'] = [];
$user_com['transrows'] = [];

foreach ($accRows as $accEntry) {
    if ($accEntry['id'] == $company['accountapp_id']) {
        $data = [
            'open'  => true,
            'logofile'  => $accEntry['logofile'],
            'name'      => $accEntry['name'],
            'login'     => $company['accountlogin'],
            'password'  => $company['accountpass'],
            'key1'      => $company['accountkey1'],
            'key2'      => $company['accountkey2'],
            'parm1'     => $company['accountparm1'],
            'parm2'     => $company['accountparm2'],
        ];
    } else {

        $data = [
            'open'  => false,
            'logofile'  => $accEntry['logofile'],
            'name'  => $accEntry['name'],
            'login'     => "",
            'password'  => "",
            'key1'      => "",
            'key2'      => "",
            'parm1'     => "",
            'parm2'     => "",
        ];
    }

    $labels = [
        'open'  => "",
        'logofile'  => "Logo-file (image)",
        'name'  => "App Name",
        'login'     => $accEntry['login'],
        'password'  => $accEntry['password'],
        'key1'      => $accEntry['key1'],
        'key2'      => $accEntry['key2'],
        'parm1'     => $accEntry['parm1'],
        'parm2'     => $accEntry['parm2'],
        'accounting' => $accEntry['id'],
    ];
    //$user_com['Accrows']->add($accEntry);
    $user_com['accrows'][] = $data;
    $user_com['acclabels'][] = $labels;
}

// Tracking systems
foreach ($timeRows as $trackApp) {
    // if ($track == $company['Trackingapp()) {
    $appName = $trackApp['name'];
    if (isset($trackData[$appName])) {
        $trackmap = $trackData[$appName];
        $params = Trackingmap::getKeys($trackmap['params']); // $trackmap['keys'];
        $data = [
            'open'  => true,
            'logofile'  => $trackApp['logofile'],
            'tracking'  => $trackApp['id'],
            'name'  => $appName,
            'usertoken' => $params[0], //$user_com['Usertoken'],
            'companytogglname'  => $params[1], //$company['Name'],
            'togglid'   => $params[2], //$user_com['Togglid'],
            'startdate'   => max(
                $company['startdate'],
                $trackmap['startdate']
            ),
            'greencheck'   => '1',
        ];
    } else {

        $data = [
            'open'  => false,
            'logofile'  => $trackApp['logofile'],
            'tracking'  => $trackApp['id'],
            'name'  => $appName,
            'usertoken' => "",
            'companytogglname'  => $company['name'],
            'togglid'   => "",
            'startdate'   => $company['startdate'],
            'greencheck'   => '0',
        ];
    }

    $user_com['timerows'][] = $data;
}
$timelabels = [
    ['name' => 'companytogglname', 'icon' => 'fas fa-eye', 'label' => 'Tracking Company Name (ID)'],
    ['name' => 'togglid', 'icon' => 'fas fa-eye', 'label' => 'User App ID'],
    ['name' => 'usertoken', 'icon' => 'fas fa-key', 'label' => 'User App Token'],
    ['name' => 'startdate', 'icon' => 'fas fa-clock', 'label' => 'Start Time Trackin at'],
];
foreach ($transRows as $trans) {
    if ($trans['id'] == $company['translation_id']) {
        $data = [
            'open'  => true,
            'logofile'  => $trans['logofile'],
            'translation'  => $trans['id'],
            'name'  => $trans['name'],
            'parm1' => $company['transparm1'],
            'parm2' => $company['transparm2'],
            'parm3' => $company['transparm3'],
        ];
    } else {

        $data = [
            'open'  => false,
            'logofile'  => $trans['logofile'],
            'translation'  => $trans['id'],
            'name'  => $trans['name'],
            'parm1' => "",
            'parm2' => "",
            'parm3' => "",
        ];
    }

    $user_com['transrows'][] = $data;
}
$translabels = [
    ['name' => 'parm1', 'icon' => 'fas fa-key', 'label' => 'Api key'],
    ['name' => 'parm2', 'icon' => 'fas fa-eye', 'label' => 'Test phrase'],
    // ['name' => 'parm3', 'icon' => 'fas fa-key', 'label' => 'User Token'],
];

$form = new UserType($user_com);
$formView = $form;
$form_company = new CompanyProfileType( $company );

$payment = Payment::findOneBy(['user_id' => $user_com['id']]);
if ($payment == null) {
    $payment = Payment::GetDefault();
    $payment['user_id'] = $user_com['id'];
    Payment::Commit($payment);

    // $em->persist($payment);
    // $em->flush();
}
$form_payment = new PaymentType( $payment );

$page4 = [
    ['label' => 'Time Tracking App',        'name' => 'timetracking'],
    ['label' => 'Time Tracking App ID', 'name' => 'togglid'],
    ['label' => 'Time Tracking User Token', 'name' => 'usertoken'],
];
$page3 = [
    // ['label' => 'Company / Configuration',  'name' => 'company', 'hide' => false],
    ['label' => 'Accounting Login',         'name' => 'accountlogin', 'hide' => 'login'],
    ['label' => 'Accounting Password',         'name' => 'accountpass', 'hide' => 'password'],
    ['label' => 'Accounting Key1', 'name' => 'accountkey1', 'hide' => 'key1'],
    ['label' => 'Accounting Key2', 'name' => 'accountkey2', 'hide' => 'key1'],
    ['label' => 'Accounting Parm1', 'name' => 'accountparm1', 'hide' => 'parm1'],
    ['label' => 'Accounting Parm2', 'name' => 'accountparm2', 'hide' => 'parm1'],
    // ['label' => 'Round Hours', 'name' => 'isrounded', 'hide' => false],
];

$page30 = [
    // ['label' => 'Company / Configuration',  'name' => 'company', 'hide' => false],
    ['icon' => 'fas fa-user-tag', 'name' => 'login'],
    ['icon' => 'fas fa-eye',  'name' => 'password'],
    ['icon' => 'fas fa-key', 'name' => 'key1'],
    ['icon' => 'fas fa-key', 'name' => 'key2'],
    ['icon' => 'fas fa-shield-alt', 'name' => 'parm1'],
    ['icon' => 'fas fa-shield-alt', 'name' => 'parm2'],
];
$page2 = [
    ['label' => 'Address',  'name' => 'address'],
    ['label' => 'Telephone',  'name' => 'telephone'],
    ['label' => 'E-Mail',     'name' => 'email'],
    ['label' => 'Chat E-Mail', 'name' => 'chatemail'],
    ['label' => 'URL',     'name' => 'url']
];
$allhours = 100;
$tracked = 45;
$ahead = $allhours - $tracked;

$finish = count($page3);
$empty = false;
$accapp_name = "";
if ($company) {
    $accapp = Accounting::find($company['accountapp_id']);
    // $accapp = $company['accountapp'];
    if ($accapp) {
        $accapp_name = $accapp['name'];
        // for ($ix = 1; $ix < $finish; $ix++) {
        for ($ix = 0; $ix < $finish; $ix++) {
            $val = $accapp[$page3[$ix]['hide']];
            if ($val) {
                $page3[$ix]['label'] = $val;
                $page3[$ix]['hide'] = false;
            } else $page3[$ix]['hide'] = true;
        }
    } else $empty = true;
} else $empty = true;

if ($empty) {
    for ($ix = 1; $ix < $finish; $ix++) {
        $page3[$ix]['hide'] = true;
    }
}
$pie = ['allhours' => $allhours, 'trackedhours' => $tracked, 'aheadhours' => $ahead];

$logofile = $company['logofile'];
if (!$logofile) {
    // parameter is taken from yaml...
    $logofile = App::Config('logo_folder') . "empty_logo.png";
}
$fileAvatar = $user_com['avatarfile'];
if (!$fileAvatar) {
    // parameter is taken from yaml...
    $fileAvatar = App::Config('logo_folder') . "default_user.png";
}

$is_new = false;
$Title      = $is_new ? 'Create New User' : 'Edit User';
// $root'      => $this->root,
$accapp     = $accapp_name;
$roles      = $new_roles;
$avatarfile = $fileAvatar;
$object     = $user_com;
$company_tag = true;

// 'formPass'  => $form_passView,

if (!$is_new) {
    $delete = true;
}
// die;