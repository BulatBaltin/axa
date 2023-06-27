<?php
  

class dlPriceGenerator{

    
public static function getLink($profile_level=false){
    
    if($profile_level===false){
        if(AuthUser::isAuthorized()){
            $user = dlModel::Create("dls_users")->getRecFieldsById(AuthUser::getID(),["level_id"]);
            $profile_level = $user["level_id"];  
        }
        else{
           $profile_level = 0; 
        }
        
       
            
    }
    
     return "/uploads/prices/".APP::Config("PROJECT_NAME")."_PriceList_Type_".$profile_level.".xls";
    
    
 
}

public static function generateAll(){
    
    $users_levels = dlModel::Create("dls_users_levels")->getAllRecs("id","ASC");
    while($users_level = $users_levels->NextElem()){
        dlPriceGenerator::generate($users_level["id"]);
    }
 
}


public static function setContentCellStyle($cell_style,$bold=true, $font_size = 11, $bg_color = "ffffff"){
      
    if($bg_color!="ffffff"){
       $cell_style->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
       $cell_style->getFill()->getStartColor()->setRGB($bg_color);
    }
   $cell_style->getAlignment()->setWrapText(true);
    $cell_style->getAlignment()->setShrinkToFit(false);
    $cell_style->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $cell_style->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
    $cell_style->applyFromArray([
        "font"=> array(
            'name'          => 'Arial',
            'size'         => $font_size,
            'bold'          => $bold,
            'italic'        => true,
           // 'underline'     => PHPExcel_Style_Font::UNDERLINE_DOUBLE,
            'strike'        => false,
            'superScript'     => false,
            'subScript'     => false,
            'color'         => array(
                'rgb' => '000000'
            )
       ),  
       "borders" => array(
            'top'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array(
                'rgb' => '000000'
                )
            ),
            'bottom'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array(
                'rgb' => '000000'
                )
            ),
            'right'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array(
                'rgb' => '000000'
                )
            ),
            'left'     => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN,
                'color' => array(
                'rgb' => '000000'
                )
            )
          
       )        
    ]); 
            
    
}

    
public static function getPrice($price){
    $price = dls_products::get_price($price);
    return $price." ".APP::Constant("currency_in_price");
}
    
public static function generate($profile_level){

    
    list($price_head_param,$price_head_roznica,$price_head_opt1,$price_head_opt2,$price_head_opt3,$price_head_nakaz) = params::val(["price_head_param","price_head_roznica","price_head_opt1","price_head_opt2","price_head_opt3","price_head_nakaz"]);
    $order_discounts = params::val("order_discounts");
    
    $koef = 7;
    $header_photo = params::get_val("pricelist_header");
    $img = get_img("params","pricelist_header",$header_photo);
    $root_categories = dlModel::Create("dls_products_categories")->getMainCategories(); 
    $header_line = 2;
    $colors = [
        "category_bg_color"=>"6e6b68",
        "price_roznica"=>"cac9c8",
        "price_opt_1"=>"cac9c8",
        "price_opt_2"=>"e1e1e1",
        "price_opt_3"=>"f7f7f7",
        "menu_bg_color"=>"383633",
        "content_borders"=>"000000",
        "menu_borders"=>"ffffff",
        "content_text"=>"000000",
        "menu_text"=>"ffffff",
        "nazakaz"=>"f7f7f7",
        "category_text"=>"ffffff"
    ];
    
    /*if($profile_level>0){*/
        
        $user_level = dlModel::Create("dls_users_levels")->getRecFieldsById($profile_level,["discount","name","add_discount"]);
        $user_discount = $user_level["discount"];//dlModel::Create("dls_users_levels")->getDiscount($profile_level);
        
       $last_column = "J";
         $columns = [
        "number"=>["col_name"=>"A","name"=>"#","width"=>45/$koef],
        "photo"=>["col_name"=>"B","name"=>"Фотография","width"=>100/$koef],
        "product_id"=>["col_name"=>"C","name"=>"ID товара","width"=>90/$koef],
        "product_name"=>["col_name"=>"D","name"=>"Название светильника","width"=>260/$koef],
        "params"=>["col_name"=>"E","name"=>$price_head_param,"width"=>75/$koef],
        //"articul"=>["col_name"=>"C","name"=>"Артикул","width"=>95/$koef],
        //"color"=>["col_name"=>"G","name"=>"Цвет","width"=>100/$koef],
        "price_roznica"=>["col_name"=>"F","name"=>$price_head_roznica,"width"=>100/$koef],
        "price_opt_1"=>["col_name"=>"G","name"=>$price_head_opt1,"width"=>100/$koef],
        "price_opt_2"=>["col_name"=>"H","name"=>$price_head_opt2,"width"=>100/$koef],
        "price_opt_3"=>["col_name"=>"I","name"=>$price_head_opt3,"width"=>100/$koef],
        "nazakaz"=>["col_name"=>"J","name"=>$price_head_nakaz,"width"=>100/$koef]
        ];
    /* }
   else{
       
        $user_discount = 0;
        $last_column = "J";
         $columns = [
        "number"=>["col_name"=>"A","name"=>"#","width"=>45/$koef],
        "photo"=>["col_name"=>"B","name"=>"Фотография","width"=>100/$koef],
        "articul"=>["col_name"=>"C","name"=>"Артикул","width"=>95/$koef],
        "product_id"=>["col_name"=>"D","name"=>"ID товара","width"=>90/$koef],
        "product_name"=>["col_name"=>"E","name"=>"Название светильника","width"=>260/$koef],
        "sizes"=>["col_name"=>"F","name"=>"Размеры","width"=>75/$koef],
        "color"=>["col_name"=>"G","name"=>"Цвет","width"=>100/$koef],
        "price_roznica"=>["col_name"=>"H","name"=>"Цена 1-2 шт","width"=>100/$koef],
        "price_opt_3"=>["col_name"=>"I","name"=>"Цена 3-9 шт.","width"=>100/$koef],
        "price_opt_10"=>["col_name"=>"J","name"=>"Цена от 10 и более шт.","width"=>100/$koef]
        ];  
       
        
    } */
    
      
    
   

    
    
   






    // Подключаем класс для вывода данных в формате excel
    //require_once(getDocumentRoot(false).'/lib/PHPExcel/Writer/Excel5.php');

    // Создаем объект класса PHPExcel
    $xls = new PHPExcel();
    // Устанавливаем индекс активного листа
    $xls->setActiveSheetIndex(0);
    // Получаем активный лист
    $sheet = $xls->getActiveSheet();
    // Подписываем лист
    $sheet->setTitle('Прайслист ' . APP::Config("PROJECT_NAME").' '.date("d.m.Y"));

    // Объединяем ячейки
    $sheet->mergeCells('A1:'.$last_column.'1');
                    
    if ($img) {
        $imagePath = getDocumentRoot(false).$img;
        $logo = new PHPExcel_Worksheet_Drawing();
        $logo->setPath($imagePath);
        $logo->setCoordinates("A1");                
        $logo->setOffsetX(0);
        $logo->setOffsetY(0);    
        $sheet->getRowDimension(1)->setRowHeight(80);
        $logo->setWorksheet($sheet);
    } 

    //Генерим столбцы:
    $sheet->getRowDimension($header_line)->setRowHeight(40);
    //№    Фотография    Артикул    id товара    Название светильника    Размеры    Цвет    Цена розничная    Цена оптовая от 3 -10 шт.     Цена оптовая от 10 и более шт.

    foreach($columns as $label=>$column){
        $sheet->getStyle($column['col_name'].$header_line)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $sheet->getStyle($column['col_name'].$header_line)->getFill()->getStartColor()->setRGB($colors['menu_bg_color']);
        $sheet->getColumnDimension($column['col_name'])->setWidth($column['width']); 
        $sheet->setCellValue($column['col_name'].$header_line, $column['name']);
        $sheet->getStyle($column['col_name'].$header_line)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle($column['col_name'].$header_line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
         $sheet->getStyle($column['col_name'].$header_line)->getAlignment()->setWrapText(true);
        $sheet->getStyle($column['col_name'].$header_line)->getAlignment()->setShrinkToFit(false);
       
        $sheet->getStyle($column['col_name'].$header_line)->applyFromArray([
            "font"=> array(
                'name'          => 'Arial',
                'size'         => 11,
                'bold'          => false,
                'italic'        => false,
               // 'underline'     => PHPExcel_Style_Font::UNDERLINE_DOUBLE,
                'strike'        => false,
                'superScript'     => false,
                'subScript'     => false,
                'color'         => array(
                    'rgb' => $colors['menu_text']
                )
           ),
          "borders" => array(
                'top'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                    'rgb' => 'ffffff'
                    )
                ),
                'bottom'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                    'rgb' => 'ffffff'
                    )
                ),
                'right'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                    'rgb' => 'ffffff'
                    )
                ),
                'left'     => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array(
                    'rgb' => 'ffffff'
                    )
                )
              
           )       
        ]);
}

$cur_line = $header_line+2;
$counter_products = 1;
foreach($root_categories as $root_category){
    
    $sheet->mergeCells('A'.$cur_line.':'.$last_column.$cur_line);
    $sheet->getStyle('A'.$cur_line)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $sheet->getStyle('A'.$cur_line)->getFill()->getStartColor()->setRGB($colors['category_bg_color']);
    $sheet->getRowDimension($cur_line)->setRowHeight(30);
    $sheet->setCellValue('A'.$cur_line, $root_category['name']);
    $sheet->getStyle('A'.$cur_line)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('A'.$cur_line)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER); 
    $sheet->getStyle('A'.$cur_line)->getAlignment()->setWrapText(true);
    $sheet->getStyle('A'.$cur_line)->getAlignment()->setShrinkToFit(false);
    
    $sheet->getStyle('A'.$cur_line)->applyFromArray([
        "font"=> array(
            'name'          => 'Arial',
            'size'         => 13,
            'bold'          => true,
            'italic'        => false,
           // 'underline'     => PHPExcel_Style_Font::UNDERLINE_DOUBLE,
            'strike'        => false,
            'superScript'     => false,
            'subScript'     => false,
            'color'         => array(
                'rgb' => $colors['category_text']
            )
       )        
    ]);
    $cur_line++;
    
    //получаем все товары из этой категории
    
    list($items,$items_num) = dlModel::Create("dls_products")->findProducts(
        false,$root_category['id'],1,10000,1
    );
    
    
    
    if($items&&$items->hasElems()){
        while($item = $items->NextElem()){
            
            
            $product_photo = dls_products::getProductPhotoMod('small',$item['id'],$item['mod_color'],$item['images']);
            
            
            
            $start_price = $item['price'];
            $user_discount = $user_level["discount"];
            $user_add_discount = $user_level["add_discount"];
            $user_level_name = $user_level["name"];

            $price_opt_1 = dlPriceGenerator::getPrice(dls_products::applyProductDiscount($start_price,$user_discount));
            $price_opt_2 =  dlPriceGenerator::getPrice(dls_products::getDiscountOrderPrice($item['order_discounts'],2,$item['price'],$user_add_discount,$order_discounts));
            $price_opt_3 = dlPriceGenerator::getPrice(dls_products::getDiscountOrderPrice($item['order_discounts'],3,$item['price'],$user_add_discount,$order_discounts));
            $price_opt_nazakaz = dlPriceGenerator::getPrice(dls_products::getDiscountOrderPrice($item['order_discounts'],"zakaz",$item['price'],$user_add_discount,$order_discounts));
            $product_param = str_replace("<br>",", ",dls_products::getProductCharacteresticsForPrice($item['characteristics']));   
            
            
            
            
            /*
            $start_price = $item['price'];
            $price_opt_3 =  dls_products::getDiscountNumPrice("",3,$item['price'],$item['price'],$item['price']);
            $price_opt_10 = dls_products::getDiscountNumPrice("",10,$item['price'],$item['price'],$item['price']);
            
            //if($user_discount){
                $price_opt_1 = dls_products::applyProductDiscount($start_price,$user_discount);
                $price_opt_3 = dls_products::applyProductDiscount($price_opt_3,$user_discount);
                $price_opt_10 = dls_products::applyProductDiscount($price_opt_10,$user_discount);
            //}
            
            $item['mod_size'] = dls_products::getProductSize($item['mod_size'],$item['size']);
            
            
            $price_opt_1 = dlPriceGenerator::getPrice($price_opt_1);
            $price_opt_3 = dlPriceGenerator::getPrice($price_opt_3);
            $price_opt_10 = dlPriceGenerator::getPrice($price_opt_10);
            $start_price = dlPriceGenerator::getPrice($start_price);*/ 
            
            $sheet->getRowDimension($cur_line)->setRowHeight(80);
        
        /*
        "number"=>["col_name"=>"A","name"=>"#","width"=>45/$koef],
        "photo"=>["col_name"=>"B","name"=>"Фотография","width"=>100/$koef],
        "product_id"=>["col_name"=>"C","name"=>"ID товара","width"=>90/$koef],
        "product_name"=>["col_name"=>"D","name"=>"Название светильника","width"=>260/$koef],
        "params"=>["col_name"=>"E","name"=>$price_head_param,"width"=>75/$koef],
        //"articul"=>["col_name"=>"C","name"=>"Артикул","width"=>95/$koef],
        //"color"=>["col_name"=>"G","name"=>"Цвет","width"=>100/$koef],
        "price_roznica"=>["col_name"=>"F","name"=>$price_head_roznica,"width"=>100/$koef],
        "price_opt_1"=>["col_name"=>"G","name"=>$price_head_opt1,"width"=>100/$koef],
        "price_opt_3"=>["col_name"=>"H","name"=>$price_head_opt2,"width"=>100/$koef],
        "price_opt_10"=>["col_name"=>"I","name"=>$price_head_opt3,"width"=>100/$koef],
        "price_opt_3"=>["col_name"=>"J","name"=>$price_head_nakaz,"width"=>100/$koef]
        */
            
            //number
            $sheet->setCellValue($columns["number"]["col_name"].$cur_line, $counter_products);
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["number"]["col_name"].$cur_line));
            //фото
            if($product_photo!="/img/frontend/nopic_small.png"){
                $imagePath = getDocumentRoot(false).$product_photo;
                $logo = new PHPExcel_Worksheet_Drawing();
                $logo->setPath($imagePath);
                $logo->setCoordinates($columns["photo"]["col_name"].$cur_line);                
                $logo->setOffsetX(7);
                $logo->setOffsetY(7);    
                $logo->setWorksheet($sheet); 
                
            }
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["photo"]["col_name"].$cur_line));
            
            //product_id
            $sheet->setCellValue($columns["product_id"]["col_name"].$cur_line, $item['id']);
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["product_id"]["col_name"].$cur_line));
            

             //product_name
            $sheet->setCellValue($columns["product_name"]["col_name"].$cur_line, $item['name']);
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["product_name"]["col_name"].$cur_line));
            
            //params
            $sheet->setCellValue($columns["params"]["col_name"].$cur_line, $product_param);
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["params"]["col_name"].$cur_line),false,10);
            
            
             //price_roznica
            $sheet->setCellValue($columns["price_roznica"]["col_name"].$cur_line, $start_price);
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["price_roznica"]["col_name"].$cur_line),true,11,$colors["price_roznica"]);
            
            
            
            
            
            //price_opt_1
            $sheet->setCellValue($columns["price_opt_1"]["col_name"].$cur_line, $price_opt_1);
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["price_opt_1"]["col_name"].$cur_line),true,11,$colors["price_opt_1"]);
            
             //price_opt_2
            $sheet->setCellValue($columns["price_opt_2"]["col_name"].$cur_line, $price_opt_2);
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["price_opt_2"]["col_name"].$cur_line),true,11,$colors["price_opt_2"]);
            
             //price_opt_3
            $sheet->setCellValue($columns["price_opt_3"]["col_name"].$cur_line, $price_opt_3);
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["price_opt_3"]["col_name"].$cur_line),true,11,$colors["price_opt_3"]);
            
            
            //nazakaz
            $sheet->setCellValue($columns["nazakaz"]["col_name"].$cur_line, $price_opt_nazakaz);
            dlPriceGenerator::setContentCellStyle($sheet->getStyle($columns["nazakaz"]["col_name"].$cur_line),true,11,$colors["nazakaz"]);
            
            
            $counter_products++;
            $cur_line++;
        }
    }
    
        
}






        



  
  
  // Выводим HTTP-заголовки
/* header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
 header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
 header ( "Cache-Control: no-cache, must-revalidate" );
 header ( "Pragma: no-cache" );
 header ( "Content-type: application/vnd.ms-excel" );
 header ( "Content-Disposition: attachment; filename=".APP::Config("PROJECT_NAME")."PriceList.xls" );
  */
  
// Выводим содержимое файла
 $objWriter = new PHPExcel_Writer_Excel5($xls);
 //$objWriter->save('php://output');
 $objWriter->save(getDocumentRoot(false).dlPriceGenerator::getLink($profile_level));
}


}
 
 
?>
