<?php

//include_once(getDocumentRoot()."vendor/moysklad/moysklad_routine_library.php");

class MoySkladGatewayJSON{
 
    public $_apiSettings = null;
    public $_curl = null;
 
        function getSettings()
{
    $apiConfig = include(getDocumentRoot()."vendor/moysklad/moysklad_curl_details.php");
    return $apiConfig;
}

function setCurl(&$curlObject, $uri, $method)
{
    curl_setopt($curlObject, CURLOPT_URL, $uri);

    curl_setopt($curlObject, CURLOPT_HTTPGET, true);
    switch ($method) {
        case "GET":
            break;
        case "POST":
            curl_setopt($curlObject, CURLOPT_POST, true);
            break;
        case "PUT":
            //curl_setopt($curlObject, CURLOPT_PUT, true);
            curl_setopt($curlObject, CURLOPT_CUSTOMREQUEST, "PUT");
            break;
    }

    return $curlObject;
}

/**
 * @param $apiSettings
 * @return resource
 */
function setupCurl($apiSettings)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);

    $userName = $apiSettings[MOYSKLAD_USERNAME];
    $userPassword = $apiSettings[MOYSKLAD_PASSWORD];
    curl_setopt($curl, CURLOPT_USERPWD, "$userName:$userPassword");
    curl_setopt($curl, CURLOPT_USERAGENT, $apiSettings[MOYSKLAD_USER_AGENT]);
    return $curl;
}
 
 
    
    public function init(){
        if(!$this->_curl){
           $this->_apiSettings = $this->getSettings();
           $this->_curl = $this->setupCurl($this->_apiSettings);
        }
    }
    
    
     public function curlExec($curlObject)
{
    
    //echo "point13";

    $response = curl_exec($curlObject);
    
    $curlErrorNumber = curl_errno($curlObject);
   
    //echo "point14".$curlErrorNumber;
   
    if ($curlErrorNumber) {
      //  echo "123";
        throw new Exception(curl_error($curlObject));
    }
    //echo "point15";
   
    return $response;
}
    
    

public function request($method,$url,$get_rows = true,$body = null){
    
    //echo "point 10";    
    
    $this->init();
         $this->_curl  = $this->setCurl(
                    $this->_curl ,
                    $this->_apiSettings[MOYSKLAD_API_URL] . $url,
                    $method);
                    
                    
          
                    
         if($body){
             curl_setopt($this->_curl, CURLOPT_POSTFIELDS, $body);
             curl_setopt($this->_curl, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($body))
            );
         }
                    
      //    echo "point 11";           
         //var_dump($this->_curl);
         $response = $this->curlExec($this->_curl);
         
        //     echo "point 12";    
         //echo $this->_apiSettings[MOYSKLAD_API_URL] . $url;
         $data = json_decode($response, true);
         //echo $data;
         if($get_rows){
            return $data['rows'];    
         }
         else{
            return $data;
         }
         
         
}    
    
    
     function getAllProducts(){
         
         
         $result = array();
        $i = 1;
        $per_page = 100;
        do {
            
            $start = $per_page*($i-1); 
            //$body = $this->request("GET", "/exchange/rest/ms/xml/Good/list?showArchived=true&offset={$start}&count={$per_page}");
            $products = $this->request("GET","/entity/product?offset={$start}&limit={$per_page}");
            
            $i++;
            foreach($products as $product){
                $result[] = $product;         
            }
        } while(count($products));
        //echo count($result);
        return $result;
         
 
    } 
    
    
    
     
    
    
    
    
    
    function getProduct($uuid){
        return $this->request("GET",'/entity/product/'.$uuid,false);
    }
    
    function getOrderStates(){
        $body = $this->request("GET", "/entity/customerorder/metadata",false); 
        return $body["states"];
        //return $body;
    }
    
    function getCustomerOrders(){
        //$date = str_replace("-","",NowDateDay(-20));
        $date = NowDateDay(-20);
        $date_filter = urlencode("updated>{$date} 00:00:00");
        
        
        
        
        
        
        
          $result = array();
        $i = 1;
        $per_page = 100;
        do {
            
            $start = $per_page*($i-1); 
            //$body = $this->request("GET", "/exchange/rest/ms/xml/Good/list?showArchived=true&offset={$start}&count={$per_page}");
            $products = $this->request("GET","/entity/customerorder?filter=".$date_filter."&offset={$start}&limit={$per_page}");
            
            $i++;
            foreach($products as $product){
                $result[] = $product;         
            }
        } while(count($products));
        //echo count($result);
        return $result;
        
        
        
        
        
        //return $this->request("GET", "/entity/customerorder?filter=".$date_filter,true);
        //return $body;
    }
    
    function getProductsCategories(){
        
        $result = array();
        $i = 1;
        $per_page = 100;
        do {
            $start = $per_page*($i-1); 
            $products = $this->request("GET","/entity/productfolder?offset={$start}&limit={$per_page}");
            $i++;
            foreach($products as $product){
                $result[] = $product;         
            }
        } while(count($products));
        //echo count($result);
        return $result;
        
        
    }
    
    
    
    
     function updateUUIDProduct(){
         
         //return $this->request("GET","/entity/product");
         
         $items = $this->getAllProducts();
         //$items = $this->request("GET","/entity/product");
         $products_gateway = dlModel::Create("dls_products");
         
         foreach($items as $item){
            
            $old_uuid = str_replace("https://online.moysklad.ru/app/#good/edit?id=","",$item["meta"]["uuidHref"]);
            echo $item["article"]." | OLD:".$old_uuid." | NEW: ".$item["id"]."<br>";
            $product = $products_gateway->getRecFieldsByField("moysklad_uid",$old_uuid,["id"]);
            if($product){
                $products_gateway->UpdateFields($product["id"],["moysklad_uid"],[$item["id"]]);
            } 
         }
     }
    
    function getProductsStockInfo(){
        
        
        //return $this->request("GET","/report/stock/all?stockMode=all");
        
          $result = array();
        $i = 1;
        $per_page = 100;
        do {
            $start = $per_page*($i-1); 
            $products = $this->request("GET","/report/stock/all?stockMode=all&offset={$start}&limit={$per_page}");
            $i++;
            foreach($products as $product){
                $result[] = $product;         
            }
        } while(count($products));
        //echo count($result);
        return $result;
        
    }
    
    
    function getConsignmentList(){
        
        $result = array();
        $i = 1;
        $per_page = 100;
        do {
            $start = $per_page*($i-1); 
            $products = $this->request("GET", "/entity/variant?offset={$start}&limit={$per_page}");
            
            $i++;
            foreach($products as $product){
                $result[] = $product;         
            }
            //echo $product;
            //flush();
        } while(count($products));
        return $result;
        
    }
    
    
    
 
    function addCustomer($name, $address, $phone, $email, $tags=array()){
        $tags_str = "";
        if(count($tags)){
            $tags_str = '"'.implode('", "',$tags).'"';
        }
     /*   $body = '<company companyType="FILI" archived="false" name="'.$name.'" readMode="SELF" changeMode="SELF">
                    <requisite actualAddress="'.$address.'"/>
                    <contact address="" phones="'.$phone.'" faxes="" mobiles="" email="'.$email.'"/>
                    '.$tags_str.'
                </company>';
       */         
       
       /*
       *{
  "name": "ООО Радуга",
  "description": "Сеть стройматериалов Радуга ЭКСПО",
  "code": "rainbowCode",
  "externalCode": "extRainbw",
  "email": "raduga@stroi.ru",
  "phone": "+7 495 331 22 33",
  "fax": "1257752",
  "actualAddress": "г.Москва ул Академика Миля дом 15 к 21",
  "legalTitle": "Общество с ограниченой ответственностью \"Радуга\"",
  "legalAddress": "г.Москва ул Авиастроителей д 93 к 12",
  "inn": "125152124152",
  "kpp": "12155521",
  "ogrn": "1251512",
  "okpo": "201355",
  "tags": [
    "Строители",
    "Радуга",
    "Ремонт"
  ],
  "state": {
    "meta": {
      "href": "https://online.moysklad.ru/api/remap/1.1/entity/counterparty/metadata/states/fb56c504-2e58-11e6-8a84-bae500000069",
      "type": "state",
      "mediaType": "application/json"
    }
  },
  "priceType": "Цена летняя"
} 
       */
       
       
       
                
        $body = '{
  "name": "'.$name.'",
  "email": "'.$email.'",
  "phone": "'.$phone.'",
  "legalTitle": "'.$name.'",
  "actualAddress": "'.$address.'",
  "legalAddress": "'.$address.'",
  "tags": [
    '.$tags_str.'
  ]
}';
       echo "point 5"; 
       echo $body;           
       $customer =  $this->request("POST", "/entity/counterparty", false, $body);
       
       print_r($customer);
       
       return $customer["id"]; 
    }
    
    
    function getServicesList(){
        
         
         
         $products = $this->request("GET", "/entity/service");
         
         return $products;
    }
    
     /*function getCustomersList(){
        
         
         
         $products = $this->request("GET", "/entity/counterparty");
         
         return $products; 
         
         
        $result = array();
        $i = 1;
        $per_page = 100;
        do {
            $start = $per_page*($i-1); 
            $products = $this->request("GET", "/entity/counterparty?offset={$start}&limit={$per_page}");
            
            $i++;
            foreach($products as $product){
                $result[] = $product;         
            }
        } while(count($products));
        return $result;
        
      
    }  */
    
    
    
     function FormatCommentForOrder($comment){
        $comment = str_replace(array("\r\n", "\r", "\n"), '', $comment);
        return TextHelper::ReplaceSpecialcharsXml($comment);
     }
     function addOrder($customer_uuid, $cart_products, $new_order_id, $delivery_price, $comment, $sum_to_pay, $delivery_name, $delivery_id){
        
        $order_name = dls_orders::getOrderId($new_order_id);
        $comment  = $this->FormatCommentForOrder($comment);
        //$time = new DateTime;
       // $datetime = $time->format(DateTime::ATOM);
        $datetime = NowDateTime();
        $customerOrderPosition = "";
        $total_sum = 0;
        
        
        //1. формирование товаров в заказе
        $orderPositions = [];
        foreach($cart_products as $product){
            
            
            $positionQuantity=floatval($product['quantity']);
            
            if($product['modification_uid']){
                $assortment = [
                    "meta"=>[
                        "href"=>"https://online.moysklad.ru/api/remap/1.1/entity/variant/".$product['modification_uid'],
                        "type"=>"variant",
                        "mediaType"=>"application/json"
                    ]
                ];
            }
            else{
                
                $assortment = [
                    "meta"=>[
                        "href"=>"https://online.moysklad.ru/api/remap/1.1/entity/product/".$product['moysklad_uid'],
                        "type"=>"product",
                        "mediaType"=>"application/json"
                    ]
                ];
            }

        $orderPositions[] =
            [
                "quantity" =>$positionQuantity,
                "price"=>floatval($product['product_total_price_one_unit']."00"),
                "discount"=>0,
                "vat"=>0,
                "assortment" => $assortment,
                "reserve"=>0,
            ];
            
            $total_sum+=$product['product_total_price'];
        }
        
        
        //2. доставка как товар
        //if($delivery_price){
            $delivery_product_uuid = $this->addDeliveryAsProduct($order_name,$delivery_price, $delivery_name, $delivery_id);
            
            
            $orderPositions[] =
            [
                "quantity" =>1,
                "price"=>floatval($delivery_price."00"),
                "discount"=>0,
                "vat"=>0,
                "assortment" => [
                    "meta"=>[
                        "href"=>"https://online.moysklad.ru/api/remap/1.1/entity/service/".$delivery_product_uuid,
                        "type"=>"service",
                        "mediaType"=>"application/json"
                    ]
                ],
                "reserve"=>0,
            ];
            
            
          /*  $customerOrderPosition.='
                <customerOrderPosition vat="0" goodUuid="'.$delivery_product_uuid.'" quantity="1.0" discount="0.0">
                    <basePrice sumInCurrency="'.$delivery_price.'00.0" sum="'.$delivery_price.'00.0"/>
                    <price sum="'.$delivery_price.'00.0" sumInCurrency="'.$delivery_price.'00.0"/>
                    <reserve>0.0</reserve>
                </customerOrderPosition>';*/
            $total_sum+=$delivery_price;
        //}
        
        //3. статус заказа
        $new_order_status_uuid = "";
        //if(APP::Constant("ORDER_NEW_STATUS",false)){
            //APP::Constant("ORDER_NEW_STATUS")
            
            
            $order = dlModel::Create("dls_orders")->getRecFieldsById($new_order_id,["status_id"]);
            
            $new_order_status = dlModel::Create("dls_spr_orders_statuses")->getRecById($order["status_id"]);
            if($new_order_status['moysklad_uid']){
                $new_order_status_uuid = ',
  "state": {
    "meta": {
      "href": "https://online.moysklad.ru/api/remap/1.1/entity/customerorder/metadata/states/'.$new_order_status['moysklad_uid'].'",
      "type": "state",
      "mediaType": "application/json"
    }
  }';
            }
        
        
        //}
        
        
         //4. создание заказа
        /*$body = '<?xml version="1.0" encoding="UTF-8"?>                          
            <customerOrder '.$new_order_status_uuid.' 
            vatIncluded="true" 
            applicable="true" 
            sourceStoreUuid="4bb1ebf2-1a1e-47ff-9e2a-e7929519461c" 
            payerVat="true" 
            sourceAgentUuid="'.$customer_uuid.'" 
            targetAgentUuid="a8431582-6a93-4064-a815-b28a4101cf69" 
            moment="'.$datetime.'" 
            name="'.$order_name.'">
                <description>'.$comment.'</description>
                <sum sum="'.$total_sum.'00.0" sumInCurrency="'.$total_sum.'00.0"/>
                '.$customerOrderPosition.'    
            </customerOrder>';*/
            
      //  "applicable": true,      
        $body = '{
  "name": "'.$order_name.'",
  "moment": "'.$datetime.'",
  "applicable": true, 
  "description": "'.$comment.'",
  "vatIncluded": true,
  "sum":"'.$total_sum.'",
   "store": {
        "meta": {
          "href": "https://online.moysklad.ru/api/remap/1.1/entity/store/4bb1ebf2-1a1e-47ff-9e2a-e7929519461c",
          "type": "store",
          "mediaType": "application/json"
        }
      }, 
  "organization": {
    "meta": {
      "href": "https://online.moysklad.ru/api/remap/1.1/entity/organization/a8431582-6a93-4064-a815-b28a4101cf69",
      "type": "organization",
      "mediaType": "application/json"
    }
  },
  "agent": {
    "meta": {
      "href": "https://online.moysklad.ru/api/remap/1.1/entity/counterparty/'.$customer_uuid.'",
      "type": "counterparty",
      "mediaType": "application/json"
    }
  }'.$new_order_status_uuid.'
}';
        
        
        $order_new = $this->request("POST", "/entity/customerorder", false, $body);
            
            /*echo "ORDER<br>";
            var_dump($order_new);*/
            
        //5. Добавляем товары заказа в заказ
        
        $jsonOrderPositions= json_encode($orderPositions);
        /*echo "<br>==============<br>";
            
        echo $jsonOrderPositions;*/
        
        $res = $this->request("POST", "/entity/customerorder/".$order_new["id"]."/positions", false, $jsonOrderPositions);
        /*echo "<br>==============<br>";
            
        echo var_dump($res);*/
                                                 
        
        return $order_new["id"];
    }
    
    
    function addDeliveryAsProduct($order_name, $price, $delivery_name, $delivery_id){
    
        $dl_moysklad_deliveries_prices_gateway = dlModel::Create("dl_moysklad_deliveries_prices");
        $uuid = $dl_moysklad_deliveries_prices_gateway->find($delivery_name,$price);
        if($uuid){
            return $uuid; 
        }
        
       /* $body = '<service minPrice="0.0" salePrice="'.$price.'00.0" archived="false" 
        parentUuid="'.APP::Config("MoySkladDeliveryCategoryUUID").'" 
        productCode="" name="Доставка '.$delivery_name.'" 
        readMode="ALL" changeMode="NONE"></service>';*/


/*  "name": "Доставка '.$delivery_name.'",
  "code": "",
  "archived": false, 
  "minPrice": 0,*/
  if($price){
      $price_str = $price."00";
  }
  else{
    $price_str = "0";
  }
        
        $body = '
        {

  "name": "Доставка '.$delivery_name.'",
  "code": "'.$order_name.'",
  "externalCode": "delCode",
  "description": "",
  "vat": 0,
  "effectiveVat": 0,
  "minPrice": 0,
  "productFolder":{
    "meta": {
          "href": "https://online.moysklad.ru/api/remap/1.1/entity/productfolder/'.APP::Config("MoySkladDeliveryCategoryUUID").'",
          "metadataHref": "https://online.moysklad.ru/api/remap/1.1/entity/productfolder/metadata",
          "type": "productfolder",
          "mediaType": "application/json"
        }
  },
  "salePrices": [
    {
      "value": '.$price_str.',
      "currency": {
        "meta": {
          "href": "https://online.moysklad.ru/api/remap/1.1/entity/currency/b7e93b84-dc34-11e6-a44c-0cc47a342c9a",
          "metadataHref": "https://online.moysklad.ru/api/remap/1.1/entity/currency/metadata",
          "type": "currency",
          "mediaType": "application/json"
        }
      },
      "priceType": "Цена продажи"
    }
   
  ]
}';
           
        $service = $this->request("POST", "/entity/service", false ,$body);
        
        //echo "<br>=============<br>Создание доставки как товара:";
     /*   dlLog::Write("==================");
        dlLog::Write($this->escape_win(json_encode($service)));
        dlLog::Write("-----------");
        dlLog::Write($body);
        dlLog::Write("==================");*/
        //var_dump($service);
        
        
        $dl_moysklad_deliveries_prices_gateway->Add(["NULL",$delivery_name,$price,$service["id"]]);
        return $service["id"];
    }
    
    
    
    function escape_win ($path) { 
$path = strtoupper ($path); 
return strtr($path, array("\U0430"=>"а", "\U0431"=>"б", "\U0432"=>"в", 
"\U0433"=>"г", "\U0434"=>"д", "\U0435"=>"е", "\U0451"=>"ё", "\U0436"=>"ж", "\U0437"=>"з", "\U0438"=>"и", 
"\U0439"=>"й", "\U043A"=>"к", "\U043B"=>"л", "\U043C"=>"м", "\U043D"=>"н", "\U043E"=>"о", "\U043F"=>"п", 
"\U0440"=>"р", "\U0441"=>"с", "\U0442"=>"т", "\U0443"=>"у", "\U0444"=>"ф", "\U0445"=>"х", "\U0446"=>"ц", 
"\U0447"=>"ч", "\U0448"=>"ш", "\U0449"=>"щ", "\U044A"=>"ъ", "\U044B"=>"ы", "\U044C"=>"ь", "\U044D"=>"э", 
"\U044E"=>"ю", "\U044F"=>"я", "\U0410"=>"А", "\U0411"=>"Б", "\U0412"=>"В", "\U0413"=>"Г", "\U0414"=>"Д", 
"\U0415"=>"Е", "\U0401"=>"Ё", "\U0416"=>"Ж", "\U0417"=>"З", "\U0418"=>"И", "\U0419"=>"Й", "\U041A"=>"К", 
"\U041B"=>"Л", "\U041C"=>"М", "\U041D"=>"Н", "\U041E"=>"О", "\U041F"=>"П", "\U0420"=>"Р", "\U0421"=>"С", 
"\U0422"=>"Т", "\U0423"=>"У", "\U0424"=>"Ф", "\U0425"=>"Х", "\U0426"=>"Ц", "\U0427"=>"Ч", "\U0428"=>"Ш", 
"\U0429"=>"Щ", "\U042A"=>"Ъ", "\U042B"=>"Ы", "\U042C"=>"Ь", "\U042D"=>"Э", "\U042E"=>"Ю", "\U042F"=>"Я")); 
}

    
    
    function updateProductPrice($product_uuid,$price){
      //  $product = $this->getProduct($product_uuid);
        //$body = preg_replace('/salePrice=\"[0-9\.]*\"/', 'salePrice="'.$price.'00.0"', $product_str);
        //$body = preg_replace('/\<salePrices\>.*\<\/salePrices\>/', ' ', $body);
      /*  echo var_dump($product);
        echo "<br>==============<br>";
        $product["salePrices"][0]["value"] = floatval($price."00");
        $product["name"] = "Аккумуляторная батарея MB771 для Apple MacBook Pro 13";
        echo var_dump($product);
        echo "<br>==============<br>";
        $body = json_encode($product);
        //echo $body;
        //echo "<br>==============<br>";
                 */
        $body = ' {
         "salePrices": [
            {
              "value": '.$price.'00,
              "currency": {
                "meta": {
                  "href": "https://online.moysklad.ru/api/remap/1.1/entity/currency/b7e93b84-dc34-11e6-a44c-0cc47a342c9a",
                  "metadataHref": "https://online.moysklad.ru/api/remap/1.1/entity/currency/metadata",
                  "type": "currency",
                  "mediaType": "application/json"
                }
              },
              "priceType": "Цена продажи"
            }]
            }
         
        ';

        $product = $this->request("PUT", "/entity/product/".$product_uuid, false , $body);
        return $product;
    }
    
    
  function updateCustomerOrderState($order_uuid,$new_state_uuid){

        $body = '
        {
        "state": {
            "meta": {
              "href": "https://online.moysklad.ru/api/remap/1.1/entity/customerorder/metadata/states/'.$new_state_uuid.'",
              "type": "state",
              "mediaType": "application/json"
            }
          }
        }';   
        $order = $this->request("PUT", "/entity/customerorder/".$order_uuid, false, $body); 
        return $order;
        
    }
      
}


class MoySkladGateway{
    
  
    
    function getProductsStockInfo(){
        $body = $this->request("GET", "/exchange/rest/stock/xml?stockMode=ALL_STOCK");
        //return $body;                                          //?ALL_STOCK=true                 
        return new SimpleXMLElement($body);
    }
    
     //1
    function getProductsStockInfoAll(){
        
        $result = array();
        $i = 1;
        $per_page = 1000;
        do {
            $start = $per_page*($i-1); 
            $body = $this->request("GET", "/exchange/rest/stock/xml?start={$start}&count={$per_page}");
            $items = new SimpleXMLElement($body);
            $products = $items->stockTO;
            $i++;
            foreach($products as $product){
                $result[] = $product;         
            }
        } while(count($products));
        //echo count($result);
        return $result;
        
    }
    
    
    function getProducts(){
        $body = $this->request("GET", "/exchange/rest/ms/xml/Good/list?showArchived=true"); 
        return new SimpleXMLElement($body);
        //return $body;
    }
    
     //2
    function getAllProducts(){
        $result = array();
        $i = 1;
        $per_page = 1000;
        do {
            $start = $per_page*($i-1); 
            $body = $this->request("GET", "/exchange/rest/ms/xml/Good/list?showArchived=true&start={$start}&count={$per_page}");
            $items = new SimpleXMLElement($body);
            $products = $items->good;
            $i++;
            foreach($products as $product){
                $result[] = $product;         
            }
        } while(count($products));
        //echo count($result);
        return $result;
        
        //return $body;
    }

    
     
    function getProductsArchived(){
        $body = $this->request("GET", "/exchange/rest/ms/xml/Good/list?showArchived=true&filter=archived%3Dtrue"); 
        return new SimpleXMLElement($body);
        //return $body;
    }
    
    //3
    function getModifications(){
        $body = $this->request("GET", "/exchange/rest/ms/xml/Feature/list"); 
        return new SimpleXMLElement($body);
        //return $body;
    }
    
    //4
    function getCustomer($uuid,$string = false){
        $body = $this->request("GET", "/exchange/rest/ms/xml/Company/".$uuid);
        if($string){
            return $body;    
        } 
        else{
            return new SimpleXMLElement($body);  
        }   
    }
    
    
    //5
    function getProduct($uuid,$string = false){
        $body = $this->request("GET", "/exchange/rest/ms/xml/Good/".$uuid);
        if($string){
            return $body;    
        } 
        else{
          return new SimpleXMLElement($body);  
        }    
    } 
    
    //6
    function getCustomerOrder($uuid,$string = false){
        $body = $this->request("GET", "/exchange/rest/ms/xml/CustomerOrder/".$uuid);
        if($string){
            return $body;    
        } 
        else{
          return new SimpleXMLElement($body);  
        }    
    }
    
    //7
    function getService($uuid,$string = false){
        $body = $this->request("GET", "/exchange/rest/ms/xml/Service/".$uuid);
        if($string){
            return $body;    
        } 
        else{
          return new SimpleXMLElement($body);  
        }    
    }
    
    
  
    
    //8
    function getProductsCategories(){
        $body = $this->request("GET", "/exchange/rest/ms/xml/GoodFolder/list"); 
        return new SimpleXMLElement($body);
        //return $body;
    }
    
    //9
    function getCustomerOrders(){
        $date = str_replace("-","",NowDateDay(-20));
        $date_filter = urlencode("updated>{$date}000000");
        $body = $this->request("GET", "/exchange/rest/ms/xml/CustomerOrder/list?filter=".$date_filter);
        return new SimpleXMLElement($body);
        //return $body;
    }
    
     //10
    function getConsignmentList(){
        
        $result = array();
        $i = 1;
        $per_page = 1000;
        do {
            $start = $per_page*($i-1); 
            $body = $this->request("GET", "/exchange/rest/ms/xml/Consignment/list?start={$start}&count={$per_page}");
            $items = new SimpleXMLElement($body);
            $products = $items->consignment;
            $i++;
            foreach($products as $product){
                $result[] = $product;         
            }
            //echo $product;
            //flush();
        } while(count($products));
        return $result;
        
        /*$body = $this->request("GET", "/exchange/rest/ms/xml/Consignment/list"); 
        return new SimpleXMLElement($body);
        return $body;*/
    }
    
    //11
    function getConsignmentsStock(){
        $body = $this->request("GET", "/exchange/rest/stock/xml?showConsignments=true"); 
        return new SimpleXMLElement($body);
    }
    
    //12
    function getOrderStates(){
        $body = $this->request("GET", "/exchange/rest/ms/xml/Workflow/list"); 
        return new SimpleXMLElement($body);
        //return $body;
    }
    
    
     //13
    function updateProductPrice($product_uuid,$price){
        $product_str = $this->getProduct($product_uuid,true);
        $body = preg_replace('/salePrice=\"[0-9\.]*\"/', 'salePrice="'.$price.'00.0"', $product_str);
        $body = preg_replace('/\<salePrices\>.*\<\/salePrices\>/', ' ', $body);
        $body = $this->request("PUT", "/exchange/rest/ms/xml/Good", $body);
        return $body;
    }
    
    //14
    function updateCustomerOrderState($order_uuid,$new_state_uuid){
        
        $order_str = $this->getCustomerOrder($order_uuid,true);
        $body = preg_replace('/stateUuid=\"[0-9a-zA-Z-]*\"/', 'stateUuid="'.$new_state_uuid.'"', $order_str);   
        $body = $this->request("PUT", "/exchange/rest/ms/xml/CustomerOrder", $body); 
        return $body;
    }
    
     //15
    function addCustomer($name, $address, $phone, $email, $tags=array()){
        $tags_str = "";
        if(count($tags)){
            $tags_str = "<tags>";
            foreach($tags as $tag){
                $tags_str.= "<tag>".$tag."</tag>";
            }
            $tags_str.="</tags>";
        }
        $body = '<company companyType="FILI" archived="false" name="'.$name.'" readMode="SELF" changeMode="SELF">
                    <requisite actualAddress="'.$address.'"/>
                    <contact address="" phones="'.$phone.'" faxes="" mobiles="" email="'.$email.'"/>
                    '.$tags_str.'
                </company>';   
        $body = $this->request("PUT", "/exchange/rest/ms/xml/Company", $body);
        $data = new SimpleXMLElement($body); 
        
        if($data->uuid){
            return $data->uuid;
        }
        else{
            echo htmlspecialchars($body);
            return false;    
        }
        
    }
    
    
     //16
    function addDeliveryAsProduct($order_name, $price, $delivery_name, $delivery_id){
    
        $dl_moysklad_deliveries_prices_gateway = dlModel::Create("dl_moysklad_deliveries_prices");
        $uuid = $dl_moysklad_deliveries_prices_gateway->find($delivery_name,$price);
        if($uuid){
            return $uuid; 
        }
        $body = '<service minPrice="0.0" salePrice="'.$price.'00.0" archived="false" parentUuid="'.APP::Config("MoySkladDeliveryCategoryUUID").'" productCode="" name="Доставка '.$delivery_name.'" readMode="ALL" changeMode="NONE"></service>';   
        $body = $this->request("PUT", "/exchange/rest/ms/xml/Service", $body);
        $data = new SimpleXMLElement($body);
        $dl_moysklad_deliveries_prices_gateway->Add(["NULL",$delivery_name,$price,$data->uuid]);
        return $data->uuid;
    }
    
    //17
    function addOrder($customer_uuid, $cart_products, $new_order_id, $delivery_price, $comment, $sum_to_pay, $delivery_name, $delivery_id){
        
        $order_name = dls_orders::getOrderId($new_order_id);
        $comment  = TextHelper::ReplaceSpecialcharsXml($comment);
        $time = new DateTime;
        $datetime = $time->format(DateTime::ATOM);
        $customerOrderPosition = "";
        $total_sum = 0;
        foreach($cart_products as $product){
            $consignmentUuid_str='';
            if($product['modification_uid']){
                $consignmentUuid_str='consignmentUuid="'.$product['modification_uid'].'"';
            }    
            $customerOrderPosition.='
                <customerOrderPosition vat="0" goodUuid="'.$product['moysklad_uid'].'" '.$consignmentUuid_str.' quantity="'.$product['quantity'].'.0" discount="0.0">
                    <basePrice sumInCurrency="'.$product['product_total_price_one_unit'].'00.0" sum="'.$product['product_total_price_one_unit'].'00.0"/>
                    <price sum="'.$product['product_total_price_one_unit'].'00.0" sumInCurrency="'.$product['product_total_price_one_unit'].'00.0"/>
                    <reserve>0.0</reserve>
                </customerOrderPosition>';
            $total_sum+=$product['product_total_price'];
        }
        
        //if($delivery_price){
            $delivery_product_uuid = $this->addDeliveryAsProduct($order_name,$delivery_price, $delivery_name, $delivery_id);
            $customerOrderPosition.='
                <customerOrderPosition vat="0" goodUuid="'.$delivery_product_uuid.'" quantity="1.0" discount="0.0">
                    <basePrice sumInCurrency="'.$delivery_price.'00.0" sum="'.$delivery_price.'00.0"/>
                    <price sum="'.$delivery_price.'00.0" sumInCurrency="'.$delivery_price.'00.0"/>
                    <reserve>0.0</reserve>
                </customerOrderPosition>';
            $total_sum+=$delivery_price;
        //}
        
        $new_order_status_uuid = "";
        if(APP::Constant("ORDER_NEW_STATUS",false)){
            $new_order_status = dlModel::Create("dls_spr_orders_statuses")->getRecById(APP::Constant("ORDER_NEW_STATUS"));
            if($new_order_status['moysklad_uid']){
                $new_order_status_uuid = 'stateUuid="'.$new_order_status['moysklad_uid'].'"';
            }
        }
        $body = '<?xml version="1.0" encoding="UTF-8"?>                          
            <customerOrder '.$new_order_status_uuid.' vatIncluded="true" applicable="true" sourceStoreUuid="4bb1ebf2-1a1e-47ff-9e2a-e7929519461c" payerVat="true" sourceAgentUuid="'.$customer_uuid.'" targetAgentUuid="a8431582-6a93-4064-a815-b28a4101cf69" moment="'.$datetime.'" name="'.$order_name.'">
                <description>'.$comment.'</description>
                <sum sum="'.$total_sum.'00.0" sumInCurrency="'.$total_sum.'00.0"/>
                '.$customerOrderPosition.'    
            </customerOrder>';
                    
        //dlModel::Create("dls_spr_units")->AddDirect(array("NULL",$body));
                   
                   
        //echo htmlspecialchars($body)."<br><br><br>";
                                                             
        $body = $this->request("PUT", "/exchange/rest/ms/xml/CustomerOrder", $body);
        
        //dlModel::Create("dls_spr_units")->AddDirect(array("NULL",$body));
        
        //return new SimpleXMLElement($body);
        
        $data = new SimpleXMLElement($body);
        if($data->uuid){
            return $data->uuid;
        }
        else{
            echo htmlspecialchars($body);
            return false;    
        }
    }
    
    
     
    
    
    function request($method, $url, $body=""){
        $sock = fsockopen("ssl://online.moysklad.ru", 443, $errno, $errstr, 30);
         
        if (!$sock) die("$errstr ($errno)\n");
         
        fputs($sock, "{$method} {$url} HTTP/1.0\r\n");
        fputs($sock, "Host: online.moysklad.ru\r\n");
        fputs($sock, "Authorization: Basic " . base64_encode("admin@buygadget:77d537c2a14f") . "\r\n");
        fputs($sock, "Content-Type: application/xml \r\n");
        fputs($sock, "Accept: */*\r\n");
        fputs($sock, "Content-Length: ".strlen($body)."\r\n");
        fputs($sock, "Connection: close\r\n\r\n");
        if($body){
            fputs($sock, "$body");
        }
         
        while ($str = trim(fgets($sock, 4096)));
         
        $body = "";
         
        while (!feof($sock))
            $body.= fgets($sock, 4096);
         
        fclose($sock);
        
        return $body;
    }
    
}

abstract class dlPaymentSystem{
    protected $_payment_name;
    
    public static function ApplyCommision($order){
       $payment_method = dlModel::Create("dls_payment_methods")->getRecById($order['payment_method_id']);
       
       
       if($payment_method && $payment_method['online_commission']){
           return dls_payment_methods::applyCommision($order['price_to_pay'],$payment_method['online_commission']);
       }
       else{
            return $order['price_to_pay'];
       }
    }
    
    public function getPaymentName(){ return $this->_payment_name;}
    public function renderForm($order,$order_products){}
}
class dlRBKMoney extends dlPaymentSystem{
    
    function __construct(){
        $this->_payment_name = "RBK Money";
    }
    
     private function getHashPart($str){
        return strlen($str).$str;
    }
        
    public function getHash($data){
        $pieces = array();
        //$pieces[] = ;
        $input = implode("::",$pieces);
        return md5($input); 
    }
    
    public function getOrderName($order,$order_products){
        return "Заказ №".$order['id']." на ".APP::Config("PROJECT_NAME");
    }
    
    public function renderForm($order,$order_products){
       
        
    //$price_to_pay = $this->ApplyCommision($order);
        
       
        
    echo '<form action="https://rbkmoney.ru/acceptpurchase.aspx" name="pay" method="POST">
            <input type="hidden" name="eshopId" value="'.APP::Config("RBKSellerCode").'">
            <input type="hidden" name="orderId" value="'.$order['number'].'">
            <input type="hidden" name="serviceName" value="'.$this->getOrderName($order,$order_products).'">
            <input type="hidden" name="recipientAmount" value="'.$order['price_to_pay'].'">
            <input type="hidden" name="recipientCurrency" value="RUR">
            <input type="hidden" name="user_email" value="'.$order['delivery_email'].'">
            <input type="hidden" name="successUrl" value="'.get_url("payment-result",array("payment_method"=>"rbk"),true).'?result=0">
            <input type="hidden" name="failUrl" value="'.get_url("payment-result",array("payment_method"=>"rbk"),true).'?result=1">
            <button class="dark-but" type="submit" name="submit">Оплатить</button>
            </form>';

    }
    
}

class dlPayU extends dlPaymentSystem {
    
    function __construct(){
        $this->_payment_name = "PayU";
    }
    
    private function getHashPart($str){
        return strlen($str).$str;
    }
        
    public function getHash($order,$order_products){
        $input = "";
        $input.=$this->getHashPart(APP::Config("PayUSellerCode","demo2")); 
        $input.=$this->getHashPart($order['number']);
        $input.=$this->getHashPart($order['datetime']);
        $input.=$this->getHashPart($this->getOrderName($order,$order_products));
        $input.=$this->getHashPart($order['number']);
        $input.=$this->getHashPart($order['price_to_pay']);
        $input.=$this->getHashPart(1);
        $input.=$this->getHashPart(0);
        $input.=$this->getHashPart("RUB");
        return hash_hmac('md5', $input, APP::Config("PayUSecretKey")); 
    }
    
    public function getOrderName($order,$order_products){
        return "Заказ №".$order['id']." на ".APP::Config("PROJECT_NAME");
    }
    
    
    public function renderForm($order,$order_products){
          
        
        //$price_to_pay = $this->ApplyCommision($order);
        
          $order['delivery_phone'] = str_replace(array("+"," ","-"),array("","",""),$order['delivery_phone']);
           
          echo '<form name="live_update" method="POST" action="https://secure.payu.ru/order/lu.php" target="_blank">
          
            <input name="MERCHANT" type="hidden" value="'.APP::Config("PayUSellerCode","demo2").'" id="MERCHANT">
            <input name="ORDER_REF" type="hidden" value="'.$order['number'].'" id="ORDER_REF">
            <input name="ORDER_DATE" type="hidden" value="'.$order['datetime'].'" id="ORDER_DATE">';
            
            /*$i=0;
            foreach($order_products as $product){
                echo '<input name="ORDER_PNAME[]" type="hidden" value="'.$product['name'].'" id="ORDER_PNAME'.$i.'">
                <input name="ORDER_PCODE[]" type="hidden" value="'.$product['product_id'].'" id="ORDER_PCODE'.$i.'">
                <input name="ORDER_PRICE[]" type="hidden" value="'.$product['price'].'" id="ORDER_PRICE'.$i.'">
                <input name="ORDER_QTY[]" type="hidden" value="'.$product['quantity'].'" id="ORDER_QTY'.$i.'">
                <input name="ORDER_VAT[]" type="hidden" value="0" id="ORDER_VAT'.$i.'">';
                $i++;
            } */
            
            echo '<input name="ORDER_PNAME[]" type="hidden" value="'.$this->getOrderName($order,$order_products).'" id="ORDER_PNAME0">
                <input name="ORDER_PCODE[]" type="hidden" value="'.$order['number'].'" id="ORDER_PCODE0">
                <input name="ORDER_PRICE[]" type="hidden" value="'.$order['price_to_pay'].'" id="ORDER_PRICE0">
                <input name="ORDER_QTY[]" type="hidden" value="1" id="ORDER_QTY0">
                <input name="ORDER_VAT[]" type="hidden" value="0" id="ORDER_VAT0">';
            
            echo '
                <input name="PRICES_CURRENCY" type="hidden" value="RUB" id="PRICES_CURRENCY">
                <input name="ORDER_HASH" type="hidden" value="'.$this->getHash($order,$order_products).'" id="ORDER_HASH">
                <input name="BACK_REF" value="'.get_url("payment-result",array("payment_method"=>"payu"),true).'" type="hidden">
                <input name="DEBUG" type="hidden" value="0" id="DEBUG">
                <input name="BILL_FNAME" type="hidden" value="'.$order['delivery_name'].'" id="BILL_FNAME">
                <input name="BILL_BANKACCOUNT" type="hidden" value="" id="BILL_BANKACCOUNT">
                <input name="BILL_EMAIL" type="hidden" value="'.$order['delivery_email'].'" id="BILL_EMAIL">
                <input name="BILL_PHONE" type="hidden" value="'.$order['delivery_phone'].'" id="BILL_PHONE">
                
                <input name="LANGUAGE" type="hidden" value="ru" id="LANGUAGE">
                <button class="dark-but" type="submit" name="submit">Оплатить</button>
                </form>';
            
      }
  }
?>
