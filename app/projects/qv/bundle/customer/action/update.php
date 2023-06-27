<?php
// use form\customer\ClientType;

try {
    $boss       = User::getUser();
    $company    = User::getCompany($boss);

    $client_id  = REQUEST::getParam('id');
    $form_part  = REQUEST::getParam('part');
    $form_data  = REQUEST::getForm(); // _POST
    
    $return = "success";
    $mssg   = Messager::renderSuccess();
    
    if (!$client_id) { // New customer - client, when multiple updates
        $client_id  = $form_data['id'];
    }
    if(!$client_id) { // New customer - client
        $customer = Client::getDefault();
    } else {
        $customer = Client::find($client_id);
    }
    $customer['company_id'] = $company['id'];
// -----------------------------

    $fld_list = false;
    $form = new ClientType();
    switch ($form_part) {
        case '1':
            $fld_list = ['name', 'address', 'person', 'telephone', 'toggl_id', 'group_id'];
            break;
        case '2':
            $fld_list = ['pilot', 'plustaskid', 'plustaskdate', 'linktrack' ];
            break;
        case '3':
            $fld_list = ['password', 'email' ];
            break;
        case '4':
            $fld_list = ['list'];
            $customer['visibility'] = chop($form_data['list'], ','); 
            break;
                
        default:
            # code...
            break;
    }
    if($fld_list) {
        $form->FillByName($customer, $form_data, $fld_list);
    }
    if ($customer['hash'] == "") {
        $guid = uniqid();
        $customer['hash'] = $guid; 
    }

    $errors = ValidateData($customer, $form_data, $fld_list);
    if($errors) {
        $return = 'error';
        $mssg   = Messager::renderError( '<b>Errors:</b><br>' . $errors );
    } elseif ($return == 'success') {
        $client_id = Client::Commit($customer);        
    }
} catch (Exception $e) {
    $return = 'error';
    $mssg   = Messager::renderError("System Error: " . $e->getMessage());
}

$content = [
    "return" => $return,
    'mssg' => $mssg,
    'client_id' => $client_id,
];
// dd($content);
Json_Response($content);

function ValidateData($customer, $form_data, $fld_list) {
    $errors = '';
    foreach($fld_list as $field_name) {
        $mssg   = '';
        if(!ValidateField($mssg, $field_name, $customer, $form_data)) {
            $errors .= '<br>'.$mssg;
        }
    }
    return $errors;
}
function ValidateField(&$mssg, $field_name, $customer, $form_data) {
    $prefix = '&diams; ';
    switch ($field_name) {
        case 'name':
            if (empty($form_data['name'])) {
                $mssg = $prefix . ll("Business name should not be empty");
                return false;
            }
            break;
        case 'password':
            if (!empty($form_data['password']) and ($form_data['password'] !== $form_data['password0'] or $form_data['password'] < 4)) {
                $mssg = $prefix . ll("Incorrect password. Both should be equal and have more than 3 characters");
                return false;
            }
            break;
        case 'email':
            if (empty($form_data['email'])) {
                $mssg = $prefix . ll("Email should not be empty");
                return false;
            }
            if(!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
                $mssg = $prefix . ll("Invalid email format");
                return false;
            }
            break;
        
        default:
            break;
    }
    return true;
}
