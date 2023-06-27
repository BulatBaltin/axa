<?php
$contents = ['return' => 'success', 'mssg' => '', 'invoice' => ''];

$customer_id    = REQUEST::get('customer_id');
$only_list      = REQUEST::get('only_list');

try {

    $customer       = $customer_id ? Client::find($customer_id) : null;

    if (!$customer) {
                
        $id_list    = REQUEST::get('id_list');
        $id_list    = chop($id_list, ',');
        $a_list     = explode(',', $id_list);
        $customer = null;
        foreach ($a_list as $id) {
            $entry = InvoiceGood::find(intval($id));
            if($entry and $entry['customer_id']) {
                $customer = Client::find($entry['customer_id']); //$entry->getCustomer();
                break;
            }
        }
    }

    if(!$customer) {
        $invoices = Invoice::findBy(
            ['status' => ['not submitted', 'not ready']],
            ['customer_id' => 'ASC','doc_date'=>'DESC']
        );
        $customers = [];
        foreach($invoices as $invoice) {
            $client = Client::find($invoice['customer_id']); //$invoice->getCustomer();
            $customers[$client['id']] = $client['name'];
        }
        usort($customers, function($a, $b) {
            if($a > $b) return 1;
            return 0;
        });
        $dlg_form = new DlgCustomerType($customers);

    } else {

        $customer_id = $customer['id'];
        $invoices = Invoice::findBy([
            'status' => [
                'OR' => ['not submitted', 'not ready']
            ], 
            'customer_id'=> $customer_id
        ]);

        $dlg_form = new DlgCustomerType([]);
        $customer_name  = $customer['name'];
        $customer       = $customer['name'];

    }

    
    $template = $only_list ? 'invoices-customer.html.php' : 'invoices-all.html.php';

    $result = [];
    foreach($invoices as $invoice) {
        // dump($invoice);
        // echo 'to string =', Invoice::toString($invoice), '<br>';
        $result[] = ['id' =>$invoice['id'], 'invoice' => Invoice::toString($invoice) ] ;
    }
    $html = module_partial('include/' . $template, [ 
        'invoices' => $result, 
        'dlg_form' => $dlg_form, 
        'customer' => $customer, 
    ], true);

    $contents = ['return' => 'success', 'invoices' => $result, 'html' => $html];

} catch(Exception $e) {

    $contents = ['return' => 'error', 'mssg' => $e->getMessage(), 'invoices' => []];
}

Json_Response($contents);
