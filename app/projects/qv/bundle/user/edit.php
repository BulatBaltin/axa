<?

// use form\user\CompanyProfileType;
// use form\user\TimetrackingAppType;
// use form\user\AccountingAppType;
// use form\user\TranslationAppType;
// use form\user\PaymentType;
// use form\user\UserType;

$boss = User::GetUser();
$company = User::GetCompany($boss);
if (!$company) {
    return UrlHelper::Redirect('qv.company.new');
}

$user_id = REQUEST::getParam('id');
if($user_id)  {
    $user = User::find($user_id); // edit existing user   
    $is_new = false;
}
else {
    $user = User::GetDefault();   // add new user 
    $is_new = true;
}


// $form = $this->createForm(ClientType::class, $client);
$form = new UserType($user);
$form->upload = true;
$form->form_name= 'user';

$url_name = "user/worker.html.php";
$session = new DataLinkSession();
$roles = $session->roles; //object->getRoles();
if (!$roles) {
    $roles = User::getRoles($user);
    $session->roles = $roles;
    $session->user  = $user;
}
// $new_roles = $this->ajust_roles($roles);
$roles  = User::map_roles($roles);

$accRows    = Accounting::findAll();
$timeRows   = Trackingapp::findBy([], ['pos' => "ASC"]); //All();??? company
$timeRowsData = Trackingmap::findBy([
    'company_id' => $company['id'],
    'objecttype' => 'user',
    'objectid' => $user['id']
]);

$trackData = [];
foreach ($timeRowsData as $tracking) {
    $trackData[$tracking['trackingname']] = $tracking;
}

$transRows = Translation::findAll();  // ??? company

$company_id = $user['company_id'];
$company = Company::find($company_id);

$user['Accrows'] = [];
$user['Acclabels'] = [];
$user['Timerows'] = [];
$user['Transrows'] = [];

foreach ($accRows as $accEntry) {
    if ($accEntry == $company['accountapp_id']) {
        $data = [
            'open'      => true,
            'logofile'  => $accEntry['logofile'], //->getLogofile(),
            'name'      => $accEntry['name'],
            'login'     => $company['accountlogin'],
            'password'  => $company['accountpass'],
            'key1'      => $company['AccountKey1'],
            'key2'      => $company['AccountKey2'],
            'parm1'     => $company['AccountParm1'],
            'parm2'     => $company['AccountParm2']
        ];
    } else {

        $data = [
            'open'  => false,
            'logofile'  => $accEntry['logofile'],
            'name'      => $accEntry['name'],
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
    //$object->getAccrows()->add($accEntry);
    $user['accrows'][] = $data;
    $user['acclabels'][] = $labels;
}
$user_timerows = [];
foreach ($timeRows as $trackApp) {

    $appName = $trackApp['name'];
    if (isset($trackData[$appName])) {
        $trackmap = $trackData[$appName];
        $params = Trackingmap::getKeys($trackmap['params']);
        $data = [
            'open'  => true,
            'logofile'  => $trackApp['logofile'],
            'tracking'  => $trackApp['id'],
            'name'      => $appName,
            'usertoken' => $params[0], //$object->getUsertoken(),
            'companytogglname'  => $params[1], //$company->getName(),
            'togglid'   => $params[2], //$object->getTogglid(),
            'startdate' => $trackmap['startdate'], //$company->getStartdate(),
            'stopdate'   => $trackmap['finishdate'], //$company->getStartdate(),
            'greencheck'   => '1',
        ];
    } else {

        $data = [
            'open'  => false,
            'logofile'  => $trackApp['logofile'],
            'tracking'  => $trackApp['id'],
            'name'      => $appName,
            'companytogglname'  => $company['name'],
            'startdate'   => $company['startdate'],
            'stopdate'   => $company['startdate'],
            'togglid'   => "",
            'usertoken' => "",
            'greencheck'   => '0',
        ];
    }

    // $user['Timerows'][] = $data;
    $user_timerows[] = $data;
}
$user['Timerows'] = $user_timerows;
// dd($user_timerows);
$TimeLabels = [
['name' => 'companytogglname', 'icon' => 'fas fa-eye', 'label' => ll('Tracking Company Name (ID)')],
['name' => 'togglid', 'icon' => 'fas fa-eye', 'label' => ll('User App ID')],
['name' => 'usertoken', 'icon' => 'fas fa-key', 'label' => ll('User App Token')],
['name' => 'startdate', 'icon' => 'fas fa-clock', 'label' => ll('Start Time Tracking at')],
['name' => 'stopdate', 'icon' => 'fas fa-clock', 'label' => ll('Stop Time Tracking at')],
];
foreach ($transRows as $trans) {
    if ($trans == $company['translation_id']) {
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

    $user['Transrows'][] = $data;
}
$TransLabels = [
    ['name' => 'parm1', 'icon' => 'fas fa-eye', 'label' => 'App ID'],
    ['name' => 'parm2', 'icon' => 'fas fa-key', 'label' => 'User Login'],
    ['name' => 'parm3', 'icon' => 'fas fa-key', 'label' => 'User Token'],
];

$collections = [
    'timerows'  => ['form' => 'TimetrackingAppType',    'data'=> $user_timerows ],
    'accrows'   => ['form' => 'AccountingAppType',      'data'=> $accRows],
    'transrows' => ['form' => 'TranslationAppType',     'data'=> $transRows],
];

$form = new UserType($user, $collections);
$formView = $form;

$form_company = new CompanyProfileType($company);

$payment = Payment::findOneBy(['user_id' => $user['id']]);
if ($payment == null) {
    $payment = Payment::GetDefault();
    $payment['user_id'] = $user['id'];
    Payment::Commit($payment, ['user_id']);
}    

$form_payment = new PaymentType($payment);

$page4 = [
    ['label' => 'Time Tracking App',        'name' => 'timetracking'],
    ['label' => 'Time Tracking App ID',     'name' => 'togglid'],
    ['label' => 'Time Tracking User Token', 'name' => 'usertoken'],
];
$page3 = [
    // ['label' => 'Company / Configuration',  'name' => 'company', 'hide' => false],
    ['label' => 'Accounting Login',     'name' => 'accountlogin',   'hide' => 'login'],
    ['label' => 'Accounting Password',  'name' => 'accountpass',    'hide' => 'password'],
    ['label' => 'Accounting Key1',      'name' => 'accountkey1',    'hide' => 'key1'],
    ['label' => 'Accounting Key2',      'name' => 'accountkey2',    'hide' => 'key1'],
    ['label' => 'Accounting Parm1',     'name' => 'accountparm1',   'hide' => 'parm1'],
    ['label' => 'Accounting Parm2',     'name' => 'accountparm2',   'hide' => 'parm1'],
    // ['label' => 'Round Hours', 'name' => 'isrounded', 'hide' => false],
];

$page30 = [
    // ['label' => 'Company / Configuration',  'name' => 'company', 'hide' => false],
    ['icon' => 'fas fa-user-tag',   'name' => 'login'],
    ['icon' => 'fas fa-eye',        'name' => 'password'],
    ['icon' => 'fas fa-key',        'name' => 'key1'],
    ['icon' => 'fas fa-key',        'name' => 'key2'],
    ['icon' => 'fas fa-shield-alt', 'name' => 'parm1'],
    ['icon' => 'fas fa-shield-alt', 'name' => 'parm2'],
];

$finish = count($page3);
// $company = $object->getCompany();
$empty = false;
$accapp_name = "";
if ($company) {
    $accapp = $company['accountapp_id'];
    if ($accapp) {
        $accapp = Accounting::find($accapp);
        $accapp_name = $accapp['name'];
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

$page2 = [
    ['label' => 'Address',      'name' => 'address'],
    ['label' => 'Telephone',    'name' => 'telephone'],
    ['label' => 'E-Mail',       'name' => 'email'],
    ['label' => 'Chat E-Mail',  'name' => 'chatemail'],
    ['label' => 'URL',          'name' => 'url']
];
$allhours = 100;
$tracked = 45;
$ahead = $allhours - $tracked;

$pie = ['allhours' => $allhours, 'trackedhours' => $tracked, 'aheadhours' => $ahead];

$avatarfile = $user['avatarfile'];
if (!$avatarfile) {
    // parameter is taken from yaml...
    $avatarfile = '\images\default_user.png'; //$this->getParameter('logo_folder') . "default_user.png";
}
$profile    = 'User profile';
$root       = 'qv.user';
$accapp     = $accapp_name;
$timelabels = $TimeLabels;
$translabels = $TransLabels;
$isnew = $is_new;
if (!$is_new) {
    $delete = true;
}
