<?php

$contents = ['return' => 'success', 'mssg' => '', 'invoice' => ''];
try {

    $option     = REQUEST::getParam('action');
    $id_list    = REQUEST::getParam('id_list');
    $id_invoice = REQUEST::getParam('id_invoice');

    $id_list = chop($id_list, ',');
    $a_list  = explode(',', $id_list);

    $isrounded = $company['isrounded'];

    // 'add-invoices' - create new; 'add-hours' - try to add
    // $isrounded = $request->request->get('isrounded');
    // $createNew = $request->request->get('iscreated');

    $newInvoiceItems = []; //$data->getMarkedRows();

    foreach ($a_list as $id) {
        $entry = InvoiceGood::find(intval($id));
        $newInvoiceItems[] = $entry; //$data->getMarkedRows();
    }

    verifyData($newInvoiceItems);

    $invoice = null;

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

    $contents = InvoiceRepository::invoiceManager(
        $action,
        $boss,
        $contents,
        $newInvoiceItems,
        $isrounded,
        $invoice,
        $status1
    );

// dd($contents);    

} catch(Exception $e) {

    $mssg = Messager::renderError($e->getMessage());
    $contents = ['return' => 'error', 'mssg' => $mssg, 'invoice' => ''];

}

Json_Response($contents);   

function verifyData($newInvoiceItems) {

    $customer = '';
    foreach ($newInvoiceItems as $key => $item) {
        if(empty($item['customer_id'])) {
            throw new Exception('Empty customer. Set a customer for selected time entries');
        }
        if( !$customer) $customer = $item['customer_id'];
        if( $item['customer_id'] !== $customer ) {
            throw new Exception('Different customers. All time entries should have the same customer');
        }

    }
}
