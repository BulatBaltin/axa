<?php

try {

    $tasklist_id = REQUEST::getParam('tasklist_id');
    $customer_id = REQUEST::getParam('customer_id');
    $tasklist = Tasklist::find($tasklist_id);

    if($tasklist and !empty($tasklist['grouppa'])) { // multi customer

        $mssg   = Messager::renderError("Multi customer tasklist cannot be mapped to a single customer. To do it, make 'tasklist group' empty for " . $tasklist, null, 'margin-bottom: 1rem');

        $result = 'error';

    } else {
    // For "" result null        
        $customer = Client::find($customer_id);
        $tasklist['customer_id'] = $customer_id;

        Tasklist::Commit($tasklist);

        $mssg   = Messager::renderSuccess( "Customer '" . $customer['name'] . "' mapped to tasklist '" . $tasklist['name'] . "'", null, 'margin-bottom: 1rem');
        $result = 'success';
    }
} catch(Exception $e) {
    $mssg   = Messager::renderError("Error: " . $e->getMessage());
    $result = 'error';
}

Json_Response([
    "return" => $result,
    'mssg' => $mssg
]);
