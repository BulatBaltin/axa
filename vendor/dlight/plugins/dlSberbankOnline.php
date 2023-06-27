<?php
  class dlSberbankOnline {
      public static function getAuthData(){
        return [urlencode(APP::Config("SB_login")),urlencode(APP::Config("SB_pass"))];
      }
      public static function RegisterOrder($order_id,$price){
        list($SB_login, $SB_pass) = dlSberbankOnline::getAuthData();
        $order_num = dls_orders::getOrderId($order_id); 
        $price = $price."00";
        $returnUrl = get_url("order-success-id",array("order_id"=>$order_id),true); 
        $failUrl = get_url("payment-fail",[],true);
        
        
         
        $cart_str = dlSberbankOnline::formOrderCart($order_id); 
        
        //$params_str = dlSberbankOnline::formOrderParams($order_id);
        
        $cart_str = str_replace(" ","%20",$cart_str);
        
        $url = 'https://'.APP::Config("SB_server").'/payment/rest/register.do?amount='.$price.'&orderNumber='.$order_id.'&password='.$SB_pass.'&returnUrl='.$returnUrl.'&failUrl='.$failUrl.'&userName='.$SB_login.'&'.$cart_str;
       // echo $url;
       // exit();  
       //$url = 'https://'.APP::Config("SB_server").'/payment/rest/register.do?amount='.$price.'&orderNumber='.$order_id.'&password='.$SB_pass.'&returnUrl='.$returnUrl.'&failUrl='.$failUrl.'&userName='.$SB_login;
       //$encodedUrl = urlencode($url);
       //$fixedEncodedUrl = str_replace(['%2F', '%3A'], ['/', ':'], $encodedUrl);
       $arr = json_decode( file_get_contents($url) , true );
        
        //print_r($arr);
        
        
        if(isset($arr["orderId"])){
      
          //echo 1;
          //exit;
            return ["success"=>true,"orderId"=>$arr["orderId"],"formUrl"=>$arr["formUrl"]];
        }
        else{
            
            
          //echo 2;
          //exit;
            return ["success"=>false,"errorCode"=>$arr["errorCode"],"errorMessage"=>$arr["errorMessage"]];
        }
        //echo $url;
        //https://3dsec.sberbank.ru/payment/rest/register.do                  currency=840&
        //{"orderId":"92635c74-cb4c-48cc-8719-1840ecadd6b3","formUrl":"https://3dsec.sberbank.ru/payment/merchants/buygadget/payment_ru.html?mdOrder=92635c74-cb4c-48cc-8719-1840ecadd6b3"}
        //{"errorCode":"1","errorMessage":"Заказ с таким номером уже обработан"}
        //echo htmlspecialchars( $result );
      }
      
      
      public static function formOrderCart($order_id){
                   
            list($order,$order_products) = dlModel::Create("dls_orders")->getOrderInfo(false,$order_id);
            $phone = str_replace([" ","-","(",")","+"],["","","","",""],$order["delivery_phone"]);
            $text = 'orderBundle={"customerDetails":{"email":"'.$order["delivery_email"].'","phone":"'.$phone.'"}, "cartItems": { "items": [';
            $products = [];
            foreach($order_products as $product){
                $product_price = $product["price"] / $product["quantity"];
                $product_name = str_replace("\"","",$product["name"]);
                $products[] = '{"positionId": "'.$product["id"].'", "name": "'.$product_name.' ('.$product["articul"].')", "quantity": { "value": '.$product["quantity"].', "measure": "шт"},"itemAmount": '.$product["price"].'00, "itemPrice":'.$product_price.'00, "itemCode": "'.$product["product_id"].'", "tax":{"taxType":0}}';
            }
            if($order["delivery_price"] > 0){
                $product_price = $order["delivery_price"];
                $products[] = '{"positionId": "1", "name": "Доставка", "quantity": { "value": 1, "measure": "шт"},"itemAmount": '.$product_price.'00, "itemPrice":'.$product_price.'00, "itemCode": "1", "tax":{"taxType":0}}';
            }
            $text = $text . implode(",",$products) . ']}}';                            
            return $text;         
      }
      
      /*public static function formOrderParams($order_id){
            $order = dlModel::Create("dls_orders")->getRecById($order_id);
            $email = trim($order["delivery_email"]);
            $text = 'params={"email": "'.$email.'"}';
            
            return $text;         
      } */
      
  }
?>
