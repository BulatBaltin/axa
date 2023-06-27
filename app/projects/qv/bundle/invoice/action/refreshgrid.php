<?php
$invoice  = REQUEST::getForm();
// dd($invoice);

$task_list  = Tasklist::find($invoice['plus_project_id']);
$user       = User::find($invoice['plus_user_id']);
$position   = $invoice['plus_position'];
$add        = $invoice['add'];

$new_row = [
    'id'            => $invoice['plus_id'],
    'position'      => $position,
    'project_id'    => $invoice['plus_project_id'],
    'project_name'  => $task_list['name'],
    'user_id'       => $invoice['plus_user_id'],
    'user_name'     => $user['name'],
    'tid'           => $invoice['plus_tid'] ? $invoice['plus_tid'] : 'new',
    'task'          => $invoice['plus_task'],
    'tasknl'        => $invoice['plus_tasknl'],
    'price'         => $invoice['plus_price'],
    'total'         => $invoice['plus_total'],
    'artikul_id'    => $invoice['plus_artikul_id'],
    'quantity'      => $invoice['plus_quantity'],
    'quantityplan'  => $invoice['plus_quantityplan'],
    'quantitylost'  => $invoice['plus_quantitylost'], //0,
    'status'        => $invoice['plus_status'] ? $invoice['plus_status'] : '',
    'level'         => $invoice['plus_level'] ? $invoice['plus_level'] : '=',
    'score'         => $invoice['plus_score'] ? $invoice['plus_score'] : 1,
    'tag'           => $invoice['plus_tag'] ? $invoice['plus_tag'] : '',
];
// var_dump($position); die;
if($add == 'update') // update / add
{
    $tr_id = $position - 1;
    $invoice['rows'][$tr_id] = $new_row;
}
else // add new row
{
    $new_row['id'] = null;
    $new_row['quantityplan'] = 0;
    $new_row['quantitylost'] = -$invoice['plus_quantity']; // ?
    $invoice['rows'][] = $new_row;
}

$html_table = module_partial('include/t-edit', [
    'invoice'   => $invoice
], true);

InvoiceRepository::calcGlobTotals($invoice);

Json_Response([
    'html_table' => $html_table,
    'invoice' => $invoice
]);
