<?

$boss       = User::GetUser();
$user       = $boss;
$company    = User::GetCompany($boss);

$app_user_avatarfile    = $boss['avatarfile'];

// dd($boss);

$app_user_name          = $boss['username'];

// lingoQty()
$lingoQty   = 3;    // GetLingoQty();
$getLingoes = '';   // getLingoes
$noticeQty  = 5;

// dump('(2)dashboard = ' . $dashboard);
// dd($boss);