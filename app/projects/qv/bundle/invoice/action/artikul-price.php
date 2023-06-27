<?php
$artikul_id = REQUEST::getParam('artikul_id');
$product = Product::find($artikul_id);
if (!$product) {
    $price = 0;
    $product = null; // to be sure
    $return = "error";
    $mssg = "Error: ID is empty";
} else {
    $price = $product['price'];
    $return = "success";
    $mssg = "Success";
}

Json_Response(['price' => $price, 'mssg' => $mssg, 'return' => $return]);