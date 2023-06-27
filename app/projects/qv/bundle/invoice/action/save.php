<?php
$invoice = REQUEST::getForm();
$invoice_id = $invoice['id'];
if(! $invoice_id) { // new invoice

}
$index_uri = route('qv.invoice.index');

if (REQUEST::GetParam('Save', null) !== null) { // Takes the name Parameters());
    $commit = false;
} elseif (REQUEST::GetParam('SaveSubmit', null) !== null) {
    $commit = true;
}

InvoiceRepository::saveInvoice($invoice, $commit);

UrlHelper::Redirect( $index_uri );

// $fields = [
// 'level'     => 'level',

// 'id'        => 'item_id',
// 'tid'       => 'tid',
// 'project_id'=> 'project_id',
// 'user_id'   => 'user_id',
// 'task'      => 'task',
// 'tasknl'    => 'task_nl',
// 'artikul_id'=> 'artikul_id',
// 'quantity'  => 'quantities',
// 'price'     => 'price',
// 'total'     => 'total',

// 'score'     => 'score',
// 'tag'       => 'tag',

// ];

// $inx = 0;
// do {
//     $row = getParamRow($fields, $inx);
//     if($row) {
//         $invoice['rows'][] = $row;
//     }
//     $inx++;
// } while ($row);

// dd('rows', $invoice['rows']);

// // InvoiceRepository::saveInvoice($invoice, $itemsCache, $repoGoods, $commit);
// InvoiceRepository::saveInvoice($invoice, $commit);

// dd("I AM HERE", $commit);

// function getParamRow($fields, $inx) {
//     $params = REQUEST::getParam('level', false);
//     if(!isset($params[$inx])) {
//         return false;
//     } 
//     $row = [];

//     foreach ($fields as $key => $value) {
//         $params = REQUEST::getParam($value, false);

//         if(!isset($params[$inx])) {
//             $params[$inx] = ''; //dd($value); // artikul_id
//         }
//         $row[$key] = $params[$inx];
//     }
//     return $row;
// }

/*
id
invoice_id
artikul_id
customer_id
project_id
user_id
company_id
position
tid
task
tasknl
quantity
quantityplan
quantitylost
price
total
start
stop
period
created_at
updated_at
status
score
level
source
import
tag
*/