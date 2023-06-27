<?php
  class googleEcommerceDLS{
      public static function render($order_id){
          
          
            list($order,$orders_products) = dlModel::Create("dls_orders")->getOrderInfo(null,$order_id);
            if(!$order){
                return false;
            }
          
               // \$(document).ready(function(){
             echo "<script>";
                 
             echo "document.addEventListener('DOMContentLoaded', function(){";
            echo "ga('require', 'ecommerce');";
            
            echo "ga('ecommerce:addTransaction', {
            'id': '{$order['id']}',                     // Transaction ID. Required.
            'affiliation': '".APP::Config("PROJECT_NAME")."',   // Affiliation or store name.
            'revenue': '{$order['price']}',               // Grand Total.
            'shipping': '{$order['delivery_price']}',                  // Shipping.
            'tax': '0'                     // Tax.
            });
            
            ";
            
            foreach($orders_products as $orders_product){
                
                $product_categories = dlModel::Create("dls_products_categories")->getProductCategories($orders_product['product_id']);
                $cats = array();
                while($product_category = $product_categories->NextElem()){
                    $cats[] = $product_category['name'];
                }

                
                $unit_price = $orders_product['price']/$orders_product['quantity'];
                echo "ga('ecommerce:addItem', {
                  'id': '{$order['id']}',                     // Transaction ID. Required.
                  'name': '{$orders_product['name']} ({$orders_product['articul']})',    // Product name. Required.
                  'sku': '{$orders_product['product_id']}',                 // SKU/code.
                  'category': '".implode(" -> ",$cats)."',         // Category or variation.
                  'price': '{$unit_price}',                 // Unit price.
                  'quantity': '{$orders_product['quantity']}'                   // Quantity.
                });
                ";
            }
            
            echo "ga('ecommerce:send');
            });
            </script>
            ";
           //}); 
            return true;
          }
          
          
          
           public static function renderYandexOrder($order_id){
          
          
            list($order,$orders_products) = dlModel::Create("dls_orders")->getOrderInfo(null,$order_id);
            if(!$order){
                return false;
            }
          
               
             echo "<script>";
             echo "document.addEventListener('DOMContentLoaded', function(){";
             
             echo 'window.dataLayer.push({
    "ecommerce": {
        "purchase": {
            "actionField": {
                "id" : "'.$order['id'].'"
            },
            "products": [';

               foreach($orders_products as $key=>$orders_product){
                
                $product_categories = dlModel::Create("dls_products_categories")->getProductCategories($orders_product['product_id']);
                $cats = array();
                while($product_category = $product_categories->NextElem()){
                    $cats[] = $product_category['name'];
                }
                $unit_price = $orders_product['price']/$orders_product['quantity'];
                
                
                $comma="";
                if($key!=count($orders_products)-1){
                    $comma=",";
                }
                
                
                echo '{
                    "id": "'.$orders_product['product_id'].'",
                    "name": "'.$orders_product['name'].' ('.$orders_product['articul'].')",
                    "price": '.$unit_price.',
                    "quantity": '.$orders_product['quantity'].',
                    "category": "'.implode("/",$cats).'"
                }'.$comma;
                
               }
            
            echo ']
        }
    }
});

});';
             
             
           
            
         
            
            echo "</script>";
           //}); 
            return true;
          }
          
          
      }
?>
