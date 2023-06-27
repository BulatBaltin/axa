<?       
function dd(...$vars)
{
    foreach ($vars as $v) {
        print_r($v);
        // var_dump($v);
        echo '<br>';
    }

    exit(1);
}
function dump(...$vars)
{
    foreach ($vars as $v) {
        print_r($v);
        // var_dump($v);
        echo '<br>';
    }
}

function imgLazyLoadParams($img, $class=""){
    return 'class="lazyload '.$class.'" data-sizes=auto data-src='.$img.' loading=lazy src=/img/frontend/dummy.jpg';
}

function get_url($slug,$params=false,$full_domain = false)
{
  return ROUTER::get_url($slug,$params,$full_domain);  
}

function isCurPage($action_name,$module_name="main")
{
  return ROUTER::isCurPage($action_name,$module_name);  
}


function strposa($haystack, $needle, $offset=0) {
    if(!is_array($needle)) $needle = array($needle);
    foreach($needle as $query) {
        if(strpos($haystack, $query, $offset) !== false) return true; // stop on first true result
    }
    return false;
}


function getArray($data)
{
    if(is_array($data))
        return $data;
    else
        return array($data);
}


 function pasteIntoFileName($filename,$paste_str){
     if($filename){
        list($base,$ext) = explode(".",$filename);
        return $base.$paste_str.".".$ext;
     } 
     else{
         return "";
     }
 }


 
 
 
 function get_img_multi($model,$field,$value,$position=0,$alt_img=""){
    $value_arr = explode(";",$value);
    $arr_img = [];
    foreach($value_arr as $item){
        if($item){
            $arr_img[] = get_img($model,$field,$item,$position,$alt_img);
        }     
    }    
    return $arr_img;
 }
 
 
 

function get_img($model,$field,$value,$position=0,$alt_img=""){   
 if(!$value||$value=="NOT_SET")
    return $alt_img;
    
 $value_temp=explode(";",$value);
 if(count($value_temp)>1){
   $value=$value_temp[$position];  
 }
    
 if(!class_exists($model))
    return false;
    
  $model_obj=new $model();
  $FieldType=$model_obj->getFieldType($field);
  if(!$FieldType)
    return false;
    
  if(get_class($FieldType)!="MultiPhotoField"){
      $dir=$FieldType->getDirName();
      $filename="/".$dir.$value;
      if(file_exists(getDocumentRoot(false).$filename))
        return $filename;
      else
        return $alt_img;
  }
  else{
        $dir=$FieldType->getDirName();
        $value = pasteIntoFileName($value,$alt_img);
        $filename="/".$dir.$value;
      
      if(file_exists(getDocumentRoot(false).$filename))
        return $filename;
      else
        return $alt_img;
  }
}

function getDocumentRoot($last_slash=true)
{
    $last_slash_str="";
    if($last_slash)
        $last_slash_str="/";

    if($_SERVER['DOCUMENT_ROOT'])
        return $_SERVER['DOCUMENT_ROOT'] . $last_slash_str;
    else
        return dirname(dirname(dirname(__FILE__))) . $last_slash_str;        
}

function include_dlight_partial($label,$params=null)
{
    if($params)
        foreach($params as $key=>$value1)
            $$key=$value1;
            
    if(file_exists(getDocumentRoot()."dlight/partial/".$label.".php"))
        include(getDocumentRoot()."dlight/partial/".$label.".php");
    if(file_exists(getDocumentRoot()."dlight/partial/".$label.".html"))
        include(getDocumentRoot()."dlight/partial/".$label.".html");
}


function include_partial($label,$params=[],$return_output = false)
{
    extract($params);
    // if($params)
    //     foreach($params as $key=>$value)
    //         $$key=$value;
            
    if($return_output){
        ob_start();
    }
    $file_base = getDocumentRoot() . "app/" . APP::Name() . "/layout/partial/" . $label;        
    if(file_exists($file_base.".php")){
        include($file_base.".php");
    }
    if(file_exists($file_base.".html"))
        include($file_base.".html");
    
    if($return_output){
        $html = ob_get_contents();
        ob_end_clean();
        return $html; 
    }
}
function includePartial($label,$params=[],$return_output = false, $app_name = null)
{
    extract($params);
    if($app_name == null) $app_name = APP::Name();
    // if($params)
    //     foreach($params as $key=>$value)
    //         $$key=$value;
            
    if($return_output){
        ob_start();
    }
    $file_base = getDocumentRoot() . "app/" . $app_name . "/layout/partial/" . $label;        
    if(file_exists($file_base.".php")){
        include($file_base.".php");
    }
    if(file_exists($file_base.".html"))
        include($file_base.".html");
    
    if($return_output){
        $html = ob_get_contents();
        ob_end_clean();
        return $html; 
    }
}

function partial($label)
{
    $file_base = getDocumentRoot() . "app/" . APP::Name() . "/layout/partial/" . $label;
    if(file_exists($file_base)){
        return $file_base;
    }
    UrlHelper::Redirect404();
    // return getDocumentRoot()."app/".APP::Name()."/layout/partial/404.html";
}

function collection_partial($collection,$label,$params=null)
{
    if(!$collection)
        return false;
        
    if($params)
        foreach($params as $key=>$value)
            $$key=$value;
            
    if(!isset($htmlspecialchars))
        $htmlspecialchars=false;
        
    if(!isset($nl2br))
        $nl2br=false;
            
            
    if(get_parent_class($collection)=="dbIterator")
            {
                if($collection->CountElems())
                    {
                        $counter = 1;
                        while($item=$collection->NextElem($htmlspecialchars,$nl2br))
                        {
                            if(file_exists(getDocumentRoot()."app/".APP::Name()."/layout/partial/".$label.".php"))
                                include(getDocumentRoot()."app/".APP::Name()."/layout/partial/".$label.".php");
                            if(file_exists(getDocumentRoot()."app/".APP::Name()."/layout/partial/".$label.".html"))
                                include(getDocumentRoot()."app/".APP::Name()."/layout/partial/".$label.".html");
                                
                            $counter++;
                        }
                    }
            }
            elseif(is_array($collection))
            {
                if(count($collection))
                {
                    $counter = 1;
                    foreach($collection as $key=>$item)
                    {
                        if(file_exists(getDocumentRoot()."app/".APP::Name()."/layout/partial/".$label.".php"))
                            include(getDocumentRoot()."app/".APP::Name()."/layout/partial/".$label.".php");
                        if(file_exists(getDocumentRoot()."app/".APP::Name()."/layout/partial/".$label.".html"))
                            include(getDocumentRoot()."app/".APP::Name()."/layout/partial/".$label.".html");
                        
                        $counter++;
                    }
                }
                
            }
}

function dateDifference($date_1, $date_2, $differenceFormat = '%a')
{ // $date_1, $date_2=> YYYY-MM-DD Format
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);
    return $interval->format($differenceFormat);
}

function hoursDifference($date_1, $date_2, $differenceFormat = '%a %h')
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2);

    return $interval->format($differenceFormat);
}
function secsDifference($date_1, $date_2)
{
    $diff = strtotime($date_1) - strtotime($date_2);
    return $diff;
}
