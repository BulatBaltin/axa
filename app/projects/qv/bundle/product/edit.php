<?

$product_id    = REQUEST::getParam('id');
if($product_id == 0) {
    $product       = Product::GetDefault();
} else {
    $product       = Product::find($product_id);
}
$form  = new ProductEditType($product);

$form->action   = route('qv.Product.update',['id' => $product_id]);

$visibility     = chop($product['visibility'] ?? '', ',');
$vis_workers_ids = explode(',', $visibility);

$vis_workers = [];
// dd($vis_workers_ids);
if(count($vis_workers_ids) > 1) {

    foreach ($vis_workers_ids as $worker_id) {
        $worker = User::find($worker_id);
        if ($worker) {
            $vis_workers[] = $worker;
        }
    }
}

$title      = "Edit product/service";
$titleplus  = 'Edit product/service information below';
$isnew      = false;
$delete     = true; // should be defined

$root       = 'qv.product';
$rootindex  = 'qv.product.index';

$object    = $product;
