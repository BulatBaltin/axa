<?
$special_header = true;

$moneybird = new MoneybirdLite();

var_dump("Step-1", $moneybird);

// 1. Create new Client
$contact = [
    'address1' => 'Down Str.',	
    'address2' => '12/34',	
    'zipcode' => '00002',	
    'city' => 'London',	
];
$client = $moneybird->CreateContact('StarSoft Ltd.', $contact);
var_dump("Step-2", $client);

$invoices = $moneybird->ListInvoices();
echo 'invoices';
var_dump("Step-3",$invoices);

if($invoices) {
    $payment = [
'invoice_id' => $invoices[0]['invoice_id'],
'payment_date' => '2022-08-04',
'price' => '300.00',
    ];
    $result = $moneybird->CreateInvoicePayment($invoices[0]['invoice_id'], $payment);
    echo 'PAYMENT';
    var_dump('PAYMENT', $result);
}

var_dump("Step-4");
exit;

// // 2. Update client info
// $clientId = $moneybird->GetInfo($client, 'id');
// $contact = [
//     'address2' => '12/1',	
//     'zipcode' => '00004',	
// ];
// $client = $moneybird->EditContact($clientId, $contact);
// 3. Product Creation 


$product = $moneybird->CreateProduct($contact);


$Contacts = $moneybird->ListContacts();
echo 'Contacts';
var_dump($Contacts);

$client = $moneybird->CreateContact('My best client', [
    'address1' => 'Happy nation',
    'zipcode' => '',	
    'city' => '',	
    'country' => '',	// ISO two-character country code, e.g. NL or DE.

]);

echo 'client';
var_dump($client);


// C:\wamp\www\BulatRules\axa\app\module\tests\Moneybird\bird.php' )	...\app.php:71