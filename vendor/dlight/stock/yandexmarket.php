<?php
class dlYandexMarket{
    
    public $file;
    public $eos="\r\n";

    function __construct(){
       $this->file = fopen(dirname(dirname(dirname(__FILE__))).APP::Config("YM_price_path","/uploads/yandexmarket/market.xml"),"w");
       if(!$this->file){
          echo("Ошибка открытия файла market.xml");
       }  
    }
    
    function Render(){
        $this->BeginWrite();
        $this->RenderCategories();
        $this->RenderProducts();
        $this->EndWrite();
    }
    
    function RenderCategories(){
        fputs( $this->file, '<categories>'.$this->eos);
        //$items = dlModel::Create("dls_products_categories")->getWhere("show","1","order","ASC");
        //$items = dlModel::Create("dls_products_categories")->getAllRecs("order","ASC");
        $items = dlModel::Create("dls_products_categories")->getWhere("in_ym","1","order","ASC");
        while($item = $items->NextElem()){
            if($item['id']){
                $params = 'id="'.$item['id'].'"';
                if($item['parent_category_id']){
                    $params.=' parentId="'.$item['parent_category_id'].'"';
                }
                
                $item_name = $item['name_ym']; 
                if(!$item_name){
                    $item_name = $item['name']; 
                }
                
                $this->WriteTag("category",$item_name,$params);
            }    
        }
        fputs( $this->file, '</categories>'.$this->eos);
        
        
        
        $ym_delivery_cost = params::get_val("ym_delivery_cost");
        $ym_delivery_days = params::get_val("ym_delivery_days"); 
        $ym_delivery_order_before = params::get_val("ym_delivery_order_before"); 
        fputs( $this->file, '<delivery-options>'.$this->eos);
        fputs( $this->file, '<option cost="'.$ym_delivery_cost.'" days="'.$ym_delivery_days.'" order-before="'.$ym_delivery_order_before.'"/>'.$this->eos);
        fputs( $this->file, '</delivery-options>'.$this->eos);
        
    }
    
    function getYMId($item){
        if($item['mod_color']||$item['mod_size']){
            return $item["id"]."mod".$item["mod_id"];
        }
        else{
            return $item["id"];
        } 
    }
    
    function RenderProduct($item,$item_name_postfix = "", $id = false){
        
        $dls_spr_ym_pay_texts_gateway = new dls_spr_ym_pay_texts();
        
        
            //если есть модификация то наличие берется из модификации
            if($item['mod_color']||$item['mod_size']){
                $item['in_stock'] = $item["mod_in_stock"];
            }
        
            
            if(dls_products::productInStock($item['in_stock'],$item["not_in_stock"])){
                $available="true";
            }
            else{
                $available="false";
            }
            
            //если стоит галочка в лист ожидания и товара нет, то не добавляем его в ЯМ.
            if($item["in_waiting_list"] && $available=="false"){
                return;
            }
            
            
            
            
            
            //$id_str = $id;
            $id_str = $this->getYMId($item);
            $name_suffix = dls_products::getNameSuffix($item['mod_color'],$item['mod_size']);
            $color_name_for_url = dls_products::getUrlColor($item['mod_color']);
            $size_for_url = dls_products::getUrlFormattedSize($item['mod_size']);
            
            
        
            fputs( $this->file, '<offer available="'.$available.'" id="'.$id_str.'">'.$this->eos);
            $this->WriteTag("url",dls_products::get_url($item['id'],$item['name'],$item['slug'],true,$item['mod_color'],$item['mod_size']));
            $this->WriteTag("price",$item['price'].".0");
            
            
            $oldprice = dls_products::getOldPrice($item['price'], $item['discount']);
            if($oldprice){
                $this->WriteTag("oldprice",$oldprice.".0");
            }
            
            $this->WriteTag("categoryId",$item['category_id']);
            $this->WriteTag("currencyId","RUR");
            
            $photo_mod = false;
            if($item['mod_color']){
                $photo_mod = dls_products_colors_photos::getPhotoForProductColor($item['id'], $item['mod_color']);    
            }
            
            if(!$photo_mod){ 
                $photos = dls_products::getPhotos($item['images']);
                $counter = 0;
                foreach($photos as $photo){
                    if( $photo['full']!="/img/frontend/nopic.png" && $counter<10 ){
                        $this->WriteTag("picture",UrlHelper::Protocol()."://".APP::Config("DOMAIN").$photo['full']);
                        $counter++;
                    }
                }
            }
            else{
                $this->WriteTag("picture",UrlHelper::Protocol()."://".APP::Config("DOMAIN").$photo_mod);
            }
            $this->WriteTag("delivery","true");
            $this->WriteTag("store","false");
            $this->WriteTag("pickup","true");
            
            
            $item_name_ym = $item['name_ym'];
            if(!$item_name_ym){
                $item_name_ym = $item['name'];
            }
            $item_name_ym =$item_name_ym.$name_suffix;
            
            
            $this->WriteTag("name",$item_name_ym." ".$item_name_postfix);
            if($item['brend']){
                $this->WriteTag("vendor",$item['brend']);    
            }
            
            $description = str_replace( ["\n\r","\n"],["",""], substr ( strip_tags($item['description']),0,3000) ); 
            
            if($description){
                $this->WriteTag("description",$description,"",true);
            }
            if($item['ym_pay_text_id']){
                $rec = $dls_spr_ym_pay_texts_gateway->getRecById($item['ym_pay_text_id']);
                $ym_sales_note = $rec['name']; 
            }
            else{
                if(!$item['ym_sales_note']){
                    $ym_sales_note = "Оплата: нал/безнал, банковские карты"; 
                }
                else{
                    //$ym_sales_note = $item['ym_sales_note'];
                    $rec = $dls_spr_ym_pay_texts_gateway->getRecById($item['ym_sales_note']);
                    $ym_sales_note = $rec['name'];
                }
            }
            
            $this->WriteTag("sales_notes", $ym_sales_note);
            
            /*
            $item['mod_color'] - цвет
            size - размер имеет приорите над $item['mod_size']
            $item['mod_size'] - размер
            - volume   - объем
            weight - вес в кг
            
            
            $this->WriteTag("param",$product_characteristic['value'],'name="'.$product_characteristic['name'].'"');
              */
             
          /*   
            if($item["weight"]){
                $this->WriteTag("param",$item["weight"],'name="Вес" unit="кг"');
            }
            
            if($item["size"]){
                $this->WriteTag("param",$item["size"],'name="Размер"');
            }elseif($item['mod_size']){
                $this->WriteTag("param",$item['mod_size'],'name="Размер"');
            }*/
              
            if($item['mod_color']){
                $this->WriteTag("param",$item['mod_color'],'name="Цвет"');
                if($item["add_extra_colorparams_ym"]){
                    $this->WriteTag("param",$item['mod_color'],'name="Цвет плафона / абажура"');
                    $this->WriteTag("param",$item['mod_color'],'name="Цвет арматуры"');
                }
            }
            
            
            $product_characteristics = dlModel::Create("dls_products_characteristics")->getProductCharacteristics($item['id']);
            if($product_characteristics->hasElems()){
                while($product_characteristic = $product_characteristics->NextElem()){
                    $param_name = $product_characteristic['name'];
                    $param_unit_str = "";
                    if(strpos($param_name,"(")!==false){
                        list($param_name, $param_unit) = explode("(",$param_name);
                        $param_name = trim($param_name);
                        $param_unit = str_replace(")","",$param_unit);
                        $param_unit_str = ' unit="'.$param_unit.'"';
                    }
                    $this->WriteTag("param",$product_characteristic['value'],'name="'.$param_name.'"'.$param_unit_str);
                }
            }
            
            
            
            $ym_delivery_cost = $item["ym_delivery_cost"];
            if(!$item["ym_delivery_cost"]){
                $ym_delivery_cost = params::get_val("ym_delivery_cost");    
            }
            
            $ym_delivery_days = $item["ym_delivery_days"];
            if(!$item["ym_delivery_days"]){
                $ym_delivery_days = params::get_val("ym_delivery_days");    
            }
            
            $ym_delivery_order_before = $item["ym_delivery_order_before"];
            if(!$item["ym_delivery_order_before"]){
                $ym_delivery_order_before = params::get_val("ym_delivery_order_before");    
            }
            
            if($item["ym_delivery_cost"] || $item["ym_delivery_days"] || $item["ym_delivery_order_before"]){
                fputs( $this->file, '<delivery-options>'.$this->eos);
                fputs( $this->file, '<option cost="'.$ym_delivery_cost.'" days="'.$ym_delivery_days.'" order-before="'.$ym_delivery_order_before.'"/>'.$this->eos);
                fputs( $this->file, '</delivery-options>'.$this->eos);
            }
            
            fputs( $this->file, '</offer>'.$this->eos);
        
    }
    
    function RenderProducts(){
        //$this->WriteTag("local_delivery_cost",299);
        
        
        
        
        fputs( $this->file, '<offers>'.$this->eos);
        $items = dlModel::Create("dls_products")->getProductsForYM();
        
        
        $id = 1;
        
        while($item = $items->NextElem()){
            if($item['in_ym']==0||$item['hidden']==1||$item['category_id']==0){
                continue;
            }
            $this->RenderProduct($item,"",$id++);
        }
        
        fputs( $this->file, '</offers>'.$this->eos);
    }
    
    function BeginWrite(){
        $datetime = NowDateTime();
        fputs( $this->file, "<?xml version=\"1.0\" encoding=\"UTF-8\"?>".$this->eos);
        fputs( $this->file, '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">'.$this->eos);
        fputs( $this->file, '<yml_catalog date="'.$datetime.'">'.$this->eos);
        fputs( $this->file, '<shop>'.$this->eos);
        $this->WriteTag("name",APP::Config("PROJECT_NAME"));
        $this->WriteTag("company",APP::Config("PROJECT_NAME"));
        $this->WriteTag("url",UrlHelper::Protocol()."://".APP::Config("DOMAIN"));
        $this->WriteTag("platform","DLightShop");
        fputs( $this->file, '<currencies>'.$this->eos);
        fputs( $this->file, '<currency id="RUR" rate="1.0"/>'.$this->eos);
        fputs( $this->file, '</currencies>'.$this->eos);
    }

    function EndWrite(){
        fputs( $this->file, "</shop>".$this->eos);
        fputs( $this->file, "</yml_catalog>");
        fclose($this->file);
    }
    
    function WriteTag($tag,$val,$params="",$form_text = false){
        if($form_text){
            $val = strip_tags($val);
            $val = str_replace(array("\r\n", "\r", "\n"), ' ', $val);
        }
        $value = htmlspecialchars($val);
        if($params){
            $params=" ".$params;
        }
        fputs( $this->file, "<".$tag.$params.">".$value."</".$tag.">".$this->eos);   
    }
    
}

?>
