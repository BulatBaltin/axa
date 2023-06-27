<?php
// get form and data
$tasklist   = REQUEST::getForm();
$part       = $tasklist['part'];
$tasklist['company_id'] = $company['id'];

// validation 
$validate = validateForm($tasklist, $part);
if(! ($validate === true) ) Json_Response($validate);

// Save data
Tasklist::Commit( $tasklist );

Json_Response([
    'return'    => 'success',
    'mssg'      => Messager::renderSuccess('Updated'),
]);

// how to validate
function validateForm($tasklist, $part) {
    
    if(empty($tasklist['name'])) {
        $return = 'error';
        $mssg   = Messager::renderError("Error: Tasklist name should not be empty");
        return ['return' => $return, 'mssg' => $mssg]; 
    }

    return true;
}
