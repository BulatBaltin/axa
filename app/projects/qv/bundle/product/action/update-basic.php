<?php
// get form and data
$product   = REQUEST::getForm();
$part       = $product['part'];
$product['company_id'] = $company['id'];

// validation 
$validate = validateForm($product, $part);
if(! ($validate === true) ) Json_Response($validate);

// Save data
// dd($product);
Product::Commit( $product );

Json_Response([
    'return'    => 'success',
    'mssg'      => Messager::renderSuccess('Updated'),
]);

// how to validate
function validateForm($product, $part) {
    
    if(empty($product['name'])) {
        $return = 'error';
        $mssg   = Messager::renderError("Error: product name should not be empty");
        return ['return' => $return, 'mssg' => $mssg]; 
    }

    return true;
}
