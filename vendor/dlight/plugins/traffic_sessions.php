<?php
//APP::addPlugin("dls_traffic_chanels");

class dls_traffic_chanels extends dlModel{
    function __construct() { 
        parent::__construct();
        $this->setTableName("dls_traffic_chanels","Названия каналов");
        $this->SetAddText("Добавить канал");
        $this->AddFields(array(            
            array(new Text("",STRONG,50),"name","Название канала"),
            array(new YesNoComboArray(1,STRONG),"main","Главный канал")
            ));
    }
    
    public function preController(){
        if(!REQUEST::isAjax() && !REQUEST::isSEBot() && $_SERVER['HTTP_ACCEPT'] && strpos( $_SERVER['HTTP_ACCEPT'] , "text/html")!==false){
            dls_traffic_sessions::setCurrentSessionID();
        } 
    }
    
}


 class dls_traffic_chanels_urls extends dlModel{
    function __construct() { 
        parent::__construct();
        $this->setTableName("dls_traffic_chanels_urls","Url каналов");
        $this->SetAddText("Добавить url для канала");
        $this->AddFields(array(            
            array(new ComboTable(1,STRONG,"dls_traffic_chanels","id","name"),"chanel_id","Канал"),
            array(new Text("",STRONG,50),"url","Url канала")
            ));
    }
    
    
    public function findChannelForHost($host,$request_url){
        
        if(REQUEST::getParam("utm_source")=="priceru"){
            return 68; //это прайс ру
        }
        
                 //  http://www.lightloft.ru/?utm_source=yandex&utm_medium=cpc&utm_campaign={campaign_27474200}&utm_content={ad_id}&utm_term={keyword}
         if(strposa($request_url, ["google&utm_medium=cpc&utm_campaign={campaign_s"])){
             // Google adwords обычный поиск  
             return 1000;
         }
          if(strposa($request_url, ["google&utm_medium=cpc&utm_campaign={campaign_d}"])){
             // Google КМС/Ремаркетинг  
             return 1001;
         }
         
         if(strposa($request_url, ["yandex&utm_medium=cpc&utm_campaign={campaign_26373102"])){
             // Яндекс РСЯ  
             return 1003;
         }
         elseif(strposa($request_url, ["source=yandex&utm_medium=cpc&utm_campaign={campaign_27474200"])){
             // Яндекс Ретаргетинг  
             return 1004;
         }
         elseif(strposa($request_url, ["yandex&utm_medium=cpc"])){
             // Яндекс Direct обычный поиск  
             return 1002;
         }
        
        
        $chanel_url = $this->getRecFieldsByField("url",$host);
        if($chanel_url){
            return $chanel_url['chanel_id'];
        }
        else{
            
            if(strpos($request_url, "_openstat")!==false){
                //это яндекс директ
                return 11;
            }
            
            if(strposa($host, ["google","yandex","rambler","bing","mail.ru"])){
                //это seo
                return 2;
            }

            $dls_traffic_chanels_gateway = dlModel::Create("dls_traffic_chanels");
            $dls_traffic_chanels_gateway->Add(["NULL",$host,0]);
            $chanel_id = $dls_traffic_chanels_gateway->lastInsertId();
            $this->Add(["NULL",$chanel_id,$host]);
            return $chanel_id; 
        }
    }
    
    
}


class dls_traffic_sessions extends dlModel{
    function __construct() { 
        parent::__construct();
        $this->setTableName("dls_traffic_sessions","Сессии пользователей");
        $this->SetAddText("Добавить сессию");
        $this->AddFields(array(            
            array(new DateField(NowDate(),STRONG),"date","Дата"),
            array(new Text("",STRONG,50),"ip","IP"),
            array(new ComboTable(1,STRONG,"dls_traffic_chanels","id","name"),"chanel_id","Канал"),
            array(new Text("",STRONG,50),"source_url","Страница источник"),
            array(new Text("",STRONG,50),"destination_url","Страница назначения")
            ));
    }
    
    public function getChanelOrdersStatistics($date_begin, $date_end, $chanel_id, $status){
        
        
        $status_str="";
        if($status){
            $status_str=" AND `status_id`='{$status}'";    
        }
        
        $items = $this->Query("
            SELECT
                `dls_orders`.`id`,
                `dls_orders`.`delivery_name`,
                `dls_orders`.`delivery_city`,
                `dls_orders`.`products`,
                `dls_orders`.`price_to_pay`
            FROM
                `dls_orders`
            WHERE
                `dls_orders`.`datetime` BETWEEN STR_TO_DATE('{$date_begin} 00:00:00', '%Y-%m-%d %T') 
                    AND STR_TO_DATE('{$date_end} 23:59:59', '%Y-%m-%d %T')
                AND `dls_orders`.`chanel_id`='{$chanel_id}' {$status_str} 
            
        ");
        
        $result_temp = $items->getArray();
        
        foreach($result_temp as $key=>$item){
            
            $ids = explode(";",$item['products']);
            $products = dlModel::Create("dls_orders_products")->getProductInfo($ids);
            //$order_products = $products->getArray(); 
            
            $result_temp[$key]['products'] = $products;
        }
        
        return $result_temp;
        
    }
    
    
    public function getStatistics($date_begin, $date_end){
        
        $visits_stat = $this->Query("
            SELECT
                COUNT(`dls_traffic_sessions`.`id`) as 'visits_num',
                `dls_traffic_chanels`.`name` as 'chanel_name',
                `dls_traffic_sessions`.`chanel_id`
            FROM
                `dls_traffic_sessions` INNER JOIN `dls_traffic_chanels` ON `dls_traffic_sessions`.`chanel_id` = `dls_traffic_chanels`.`id`
            WHERE
                `dls_traffic_sessions`.`date` BETWEEN STR_TO_DATE('{$date_begin}', '%Y-%m-%d') 
                    AND STR_TO_DATE('{$date_end}', '%Y-%m-%d')
            GROUP BY
                `dls_traffic_sessions`.`chanel_id`
            ORDER BY
                COUNT(`dls_traffic_sessions`.`id`) DESC
        ");
        
        
        $result_temp = $visits_stat->getArray();
        $result = [];
        foreach($result_temp as $stat){
            $result[$stat['chanel_id']] = ["chanel_name"=>$stat['chanel_name'],"visits"=>$stat['visits_num'],"orders_num"=>0,"orders_completed_num"=>0];    
        }
        
        
        $orders_stat = $this->Query("
            SELECT
                COUNT(`dls_orders`.`id`) as 'orders_num',
                `dls_traffic_chanels`.`name` as 'chanel_name',
                `dls_orders`.`chanel_id`
            FROM
                `dls_orders`   
                 INNER JOIN `dls_traffic_chanels` ON `dls_orders`.`chanel_id` = `dls_traffic_chanels`.`id`
            WHERE
                `dls_orders`.`datetime` BETWEEN STR_TO_DATE('{$date_begin} 00:00:00', '%Y-%m-%d %T') 
                    AND STR_TO_DATE('{$date_end} 23:59:59', '%Y-%m-%d %T')
            GROUP BY
                `dls_orders`.`chanel_id`
        ");
        
        while($stat = $orders_stat->NextElem()){
            if($result[$stat['chanel_id']]){
                $result[$stat['chanel_id']]["orders_num"] = $stat['orders_num'];
            }
            else{
                
                $result[$stat['chanel_id']] = ["chanel_name"=>$stat['chanel_name'],"visits"=>0,"orders_num"=>$stat['orders_num'],"orders_completed_num"=>0];
            }
        }
        
        $orders_completed_stat = $this->Query("
            SELECT
                COUNT(`dls_orders`.`id`) as 'orders_num',
                `dls_traffic_chanels`.`name` as 'chanel_name',
                `dls_orders`.`chanel_id`
            FROM
                `dls_orders`   
                 INNER JOIN `dls_traffic_chanels` ON `dls_orders`.`chanel_id` = `dls_traffic_chanels`.`id`
            WHERE
                (`dls_orders`.`datetime` BETWEEN STR_TO_DATE('{$date_begin} 00:00:00', '%Y-%m-%d %T') 
                    AND STR_TO_DATE('{$date_end} 23:59:59', '%Y-%m-%d %T')) AND `dls_orders`.`status_id`='".APP::Constant("ORDER_SUCCESS_STATUS")."' 
            GROUP BY
                `dls_orders`.`chanel_id`
        ");
        
        while($stat = $orders_completed_stat->NextElem()){
            $result[$stat['chanel_id']]["orders_completed_num"] = $stat['orders_num'];
        }
        return $result;
        
    }
    
    
    public static function getCurrentSessionChanel(){
        $CurrentSessionID = dls_traffic_sessions::getCurrentSessionID();
        $session = dlModel::Create("dls_traffic_sessions")->getRecFieldsById($CurrentSessionID,["chanel_id"]);
        return $session["chanel_id"];
    }
    
    public static function getCurrentSessionID(){
        if(!isset($_SESSION['dls_traffic_sessions_id'])){
            dls_traffic_sessions::setCurrentSessionID(); 
        }
        return $_SESSION['dls_traffic_sessions_id'];
    }
    
    public function sessionExists($date,$ip){
        $recs = $this->getWhereExt("`date`='{$date}' AND `ip`='{$ip}'",['id']);
        if($recs->hasElems()){
            $rec = $recs->NextElem();     
            return $rec['id'];    
        }
        else{
            return false;
        }
    }
    
    public function SaveCSV($data,$date_begin, $date_end){
        $folder = "/uploads/temp/";
        $file_name = "ch_stat_{$date_begin}_to_{$date_end}.csv";
        $file_path = getDocumentRoot(false).$folder.$file_name;
        
        $file = fopen($file_path,"w");
        if(!$file){
           return "";   
        }
            
        
        fputcsv($file,["Статистика каналов продаж с {$date_begin} по {$date_end}"]);  
        fputcsv($file,["#","Канал трафика","Уникальные посетители","Заказы","Заказы (отгружено)"]);   
        
        $counter = 1;
        foreach($data as $chanel_id=>$elem){    
             fputcsv($file,[$counter++,$elem['chanel_name'],$elem['visits'],$elem['orders_num'],$elem['orders_completed_num']]);   
        }     
        fclose($file);
        
        return $folder.$file_name;
    }
    
    public static function setCurrentSessionID(){
        if(!isset($_SESSION['dls_traffic_sessions_id'])){
            
            
            $request_url = REQUEST::request_url();
            
            $dls_traffic_sessions_gateway = dlModel::Create("dls_traffic_sessions");
            
            //тут нужно еще проверить может запись с NowDate(),REQUEST::GetIp() уже есть в dls_traffic_sessions
            //NowDate()
            $session_id = $dls_traffic_sessions_gateway->sessionExists(NowDate(),REQUEST::GetIp());
            
            if($session_id){
                $_SESSION['dls_traffic_sessions_id'] = $session_id;
                return;
            }
            
            if(isset($_SERVER['HTTP_REFERER'])){        
                $HTTP_REFERER = $_SERVER['HTTP_REFERER'];
                    
                //echo "HTTP_REFERER: ".$HTTP_REFERER;
                $url = parse_url($HTTP_REFERER);
                //$url: Array ( [scheme] => http [host] => www.google.com.ru [path] => /search [query] => hl=ru&ie=UTF-8&oe=UTF-8&q=softtime&lr= )
                $host = $url['host'];
                if($host != UrlHelper::getHostUrl()){
                    //переход с внешнего сайта
                    
                    //ищем $host в dls_traffic_chanels_urls
                    $chanel_id = dlModel::Create("dls_traffic_chanels_urls")->findChannelForHost($host,$request_url);
                     
                    
                }
                else{
                    $chanel_id = 1;
                    $HTTP_REFERER = "";//"пусто|".$HTTP_REFERER."|".$host."|".UrlHelper::getHostUrl();
                }
            }
            else{
                //это прямой трафик
                $chanel_id = 1;
                $HTTP_REFERER = "";
                //echo "HTTP_REFERER: не установлен";
                    
            }
            
            if($chanel_id){
                $dls_traffic_sessions_gateway->Add(["NULL",FormatDateForView(NowDate()),REQUEST::GetIp(),$chanel_id,$HTTP_REFERER,$request_url]);
                $_SESSION['dls_traffic_sessions_id'] = $dls_traffic_sessions_gateway->lastInsertId();
            }
            
        }
    }
}

?>
