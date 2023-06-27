<?php
$id_invoice = REQUEST::get('target');
$id_list    = REQUEST::get('invoices');

$id_list    = chop($id_list, ',');
$a_list     = explode(',', $id_list);
$contents   = ['return' => 'success', 'mssg' => '', 'invoice' => ''];

$isrounded = false;
$planInvoiceItems = []; //$data->getMarkedRows();

try {

    foreach ($a_list as $id) {
        // $invoice = Invoice::find(intval($id));
        $items = InvoiceGood::findBy(['invoice_id' => $id]);
        if(count($items) > 0) {
            foreach($items as $item) {
                if(InvoiceGood::IsInitEntry($item))
                    $planInvoiceItems[] = $item; //$data->getMarkedRows();
            }
        }
    }

    $invoice = null;
                
    $option = 'add-hours';

    if ($option == 'add-hours') {
        if ($id_invoice) {
            $invoice = Invoice::find(intval($id_invoice));
            if($invoice) { // really exists
                $action = "add";
                $status1 = $invoice['status1'];
            } else {
                $action = "create";
                $status1 = 'manual';
            }
        } else {
            $action = "auto";
            $status1 = 'auto';
        }
    } else {
        $action = "create";
        $status1 = 'manual';
    }

    $isrounded = $isrounded === 'true' ? true : false;

    $keepHours = true;

// dd(
//     $a_list,
//     $action,
//     $planInvoiceItems,
//     $invoice
// );

    $contents = InvoiceRepository::invoiceManager(
        $action,
        $boss,
        $contents,
        $planInvoiceItems,
        $isrounded,
        $invoice,
        $status1,
        $keepHours
    );

// dymp('CONTENTS ',$contents);    

    foreach ($a_list as $id) {
        // $invoice = Invoice::find(intval($id));
        Invoice::deleteInvoice($id);
    }

} catch(Exception $e) {
    $contents = ['return' => 'error', 'mssg' => $e->getMessage(), 'invoice' => ''];
}

Json_Response($contents);
