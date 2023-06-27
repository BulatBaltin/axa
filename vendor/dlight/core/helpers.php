<?php


class UrlHelper
{
    public static function unsetPastUrl()
    
    {
        unset($_SESSION['past_url']);
    }

    public static function setPastUrl($url)
    {
        $_SESSION['past_url']=$url;
    }
    
    public static function removeLastSlash($str){
        if(substr($str, strlen($str)-1, strlen($str))=="/"){
            return substr($str, 0, strlen($str)-1);
        }
        return $str;
    }
    
    public static function uriParamReplace($new_param,$before="/?",$uri=false){
        if(!$uri){
            $uri = $_SERVER['REQUEST_URI'];
        }
        
        $url = explode("?",$uri);
        if(count($url)!=2){
            return $uri;
        }
        $param_str = $url[1];
        //echo $param_str;
        $href = $url[0].UrlHelper::urlParamReplace($param_str,$new_param,$before); 
        return UrlHelper::removeLastSlash($href);
        
    }
    
    
    
    public static function urlParamReplace($param_str,$new_param,$before="/?"){
        $param_arr=array();
        if($param_str)
            $param_arr = explode("&",$param_str);
        
        foreach($new_param as $new_param_key=>$new_param_value){
            
            $replaced = false;
            foreach($param_arr as $key=>$param){
                list($param_name,$param_value)=explode("=",$param);
                if($new_param_key==$param_name){
                    if($new_param[$param_name]!==null){
                        $param_arr[$key] = "{$param_name}={$new_param[$param_name]}";    
                    }
                    else{
                        unset($param_arr[$key]);
                    }
                    $replaced = true;
                    break; 
                }
            }
            if(!$replaced&&$new_param_value!==null){
                $param_arr[]="{$new_param_key}={$new_param_value}";
            }
        }
        if(count($param_arr))
            return $before . implode("&",$param_arr);
        else
            return  "";
    }

    public static function getPastUrl()
    {
        return $_SESSION['past_url'];
    }

    public static function isPastUrl()
    {
        if(isset($_SESSION['past_url']))
            return true;
        else
            return false;
    }
    
    
    public static function Redirect($url,$code="")
    {
        switch($code)
        {
         case "301":  
            header("HTTP/1.1 301 Moved Permanently");
            break;
         case "404":  
            header('HTTP/1.1 404 Not Found');
            echo file_get_contents(get_url(APP::Config("404_PAGE"),false,true)."?no404Headers");
            exit();
            break;
        }
        header ("Location: ".$url);
        exit();
    }
    
    
    public static function RedirectMain($code="")
    {
     UrlHelper::Redirect(UrlHelper::getMainPage(),$code);
    }
    
    public static function Redirect404()
    {
        header('HTTP/1.1 404 Not Found');
        //header ("location: ".UrlHelper::getPageLink(APP::Config("404_PAGE","main/404")));
        header ("location: ".get_url(APP::Config("404_PAGE","404")));
        //flush();
        //echo file_get_contents(get_url(APP::Config("404_PAGE"),false,true)."?no404Headers");
        exit();
    }
    
    public static function Redirect301($url)
    {
        header("HTTP/1.1 301 Moved Permanently");
        header ("location: ".$url);
        flush();
        exit();
    }
                
 

    
    public static function getBackendTableViewLink($table_name)
    {    
        return get_url("table_listing",array("table"=>$table_name));
    }
    
  public static function getBackendTableAddLink($table_name)
    {    
        //return "/backend/add-".$table_name;
        return get_url("table_add",array("table"=>$table_name));
    }
    
    public static function getBackendTableEditLink($table_name,$id)
    {    
        //return "/backend/edit-".$table_name."-".$id;
        return get_url("table_edit",array("table"=>$table_name,"id"=>$id));
    }
    
    public static function getBackendTableRemoveLink($table_name,$id)
    {    
        //return "/backend/remove-".$table_name."-".$id;
        return get_url("table_remove_item",array("table"=>$table_name,"id"=>$id)); 
    }    
    
    public static function getMainPage()
    {    
        //return UrlHelper::getPageLink(APP::Config('MAIN_PAGE','main/main'));
        // $path=get_url(APP::Config('MAIN_PAGE', "main"));
        $path=get_url(ROUTER::getMainSlug() );
        if(!$path)
            return "/";
        else
            return $path;
    }
    
    public static function get404Page()
    {    
        return get_url(APP::Config('404_PAGE',"404"));
    }
 
    function getPic($base_path,$pic_field,$size,$return_def_image=true)
    {
        if($pic_field=="NOT_SET"||!$pic_field)
        {
            if($return_def_image)
            {
                if($size==0)
                    return "/img/no_pic.jpg";
                else
                    return "/img/no_pic_small.jpg";
            }
            else
                return false;
        }
        else
        {
            $ar=explode(";",$pic_field);
            if(file_exists(getDocumentRoot()."/".$base_path.$ar[$size]))
                return "/".$base_path.$ar[$size];
            else
                {
                    if($return_def_image)
                    {
                        if($size==0)
                            return "/img/no_pic.jpg";
                        else
                            return "/img/no_pic_small.jpg";
                    }
                    else
                        return false;
                }
        }
    }
    
    public static function Protocol(){
        if(REQUEST::isLocalhost()){
            return "http";
        }
        if(APP::Config('DOMAIN') == 'book.eendracht1.nl') {
            return "https";
        }
        return "http";    
    }
    
    public static function getHttpHostUrl()
    {
        return UrlHelper::Protocol()."://".APP::Config("DOMAIN");
    }
    
    
    public static function getHostUrl()
    {
        if(isset($_SERVER['HTTP_HOST'])){
            return $_SERVER['HTTP_HOST'];
        }
        else{
            return APP::Config("DOMAIN");
        }
    }
    
    public static function getRequestUrl()
    {
        return UrlHelper::getHttpHostUrl().$_SERVER['REQUEST_URI'];
    }
    
    
    function getFile($base_path,$file_field)
    {
        if($file_field=="NOT_SET"||!$file_field)
        {
            return false;
        }
        else
        {
            if(file_exists(getDocumentRoot()."/".$base_path.$file_field))
                return "/".$base_path.$file_field;
            else
                return false;
        }
    } 
    
    ////////////////////////////////PROJECT URL HELPERS////////////////////////////
    
    
    
    
    ////////////////////////////////END OF PROJECT URL HELPERS////////////////////////////


}


class TextHelper
{
    
    
    public static $trans = array("quot"=>"","а"=>"a","б"=>"b","в"=>"v","г"=>"g","д"=>"d","е"=>"e", "ё"=>"yo","ж"=>"j","з"=>"z","и"=>"i","й"=>"i","к"=>"k","л"=>"l", "м"=>"m",
      "н"=>"n","о"=>"o","п"=>"p","р"=>"r","с"=>"s","т"=>"t", "у"=>"y","ф"=>"f","х"=>"h","ц"=>"c","ч"=>"ch", "ш"=>"sh","щ"=>"sh","ы"=>"i","э"=>"e","ю"=>"u",
      "я"=>"ya"," "=>"-","-"=>"", "&"=>"",
      "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g","Д"=>"d","Е"=>"e", "Ё"=>"yo","Ж"=>"j","З"=>"z","И"=>"i","Й"=>"i","К"=>"k", "Л"=>"l","М"=>"m","Н"=>"n","О"=>"o","П"=>"p", 
      "Р"=>"r","С"=>"s","Т"=>"t","У"=>"y","Ф"=>"f", "Х"=>"h","Ц"=>"c","Ч"=>"ch","Ш"=>"sh","Щ"=>"sh", "Ы"=>"i","Э"=>"e","Ю"=>"u","Я"=>"ya",
      "ь"=>"","Ь"=>"","ъ"=>"","Ъ"=>"","-"=>"",
      "."=>"",":"=>"","\""=>"",","=>"",";"=>"","?"=>"","%"=>"","/"=>"","`"=>"","'"=>"","("=>"",")"=>"","\\"=>"","+"=>"","”"=>"","″"=>"","®"=>"","™"=>"");
    
   
   


public static function ReplaceSpecialcharsXml($str){
    $arr_search = [
           '"',
           '©',
            '®',
            '™',
            '?',
            'Ј',
            '„',
            '“',
            '«',
            '»',
            '>',
            '<',
            '≥',
            '≤',
            '≈',
            '≠',
            '≡'
    ];
    $arr_replace = [
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
        "",
    ]; 
        return htmlentities(str_replace($arr_search,$arr_replace,$str)); 
    }

    
    public static function Raw($str){
        return htmlspecialchars_decode($str);
    }
    public static function Out($str,$nl2br=false,$strip_tags=true,$exeption_keys=false)
    {
        if(is_array($str))
        {
            $str_temp = array();
            $exeption_keys_arr=getArray($exeption_keys);
            foreach($str as $key=>$value)
                if($exeption_keys&&in_array($key,$exeption_keys_arr))
                    $str_temp[$key]=$value;
                else
                    $str_temp[$key] = TextHelper::Out($value,$nl2br,$strip_tags);        
                
            return $str_temp;
        }
        else
        {
            if($strip_tags)
                $str=strip_tags($str);
                
            $res=htmlspecialchars($str);
            if($nl2br)
                $res=nl2br($res);
            return $res;
        }
    }

    public static function getTexts($labels,$lang=false)
    {
        $lang_str="";
        if($lang)
           $lang_str="_".$lang;
           
        $gateway=new texts();
        
        if(is_array($labels))
        {
            foreach($labels as $key=>$label)
                $labels[$key]="'{$label}'";
                
            $labels_str=implode(",",$labels);
            $recs=$gateway->getWhereExt("`label` IN ({$labels_str})",array("text".$lang_str,"label"));
            $result=array();
            if(Database::num_rows($recs))
                while($rec=DataBase::fetch_array($recs))
                    $result[$rec['label']]=$rec["text".$lang_str];
            return $result;
        }
        else
        {
            $recs=$gateway->getWhereExt("`label`='{$labels}'",array("text".$lang_str,"label"));
            $result=array();
            if(Database::num_rows($recs))
                while($rec=DataBase::fetch_array($recs))
                    $result[$rec['label']]=$rec["text".$lang_str];
                    
            return $result[$labels];
        }
    }

    
    
    public static function Cut($str,$num)
    {
        if(strlen($str)<=$num)
            return $str;
        else
            return substr($str,0,$num)."...";
    }
    
    
    public static function translite($string)
    {
      $string=mb_strtolower($string,"utf-8");
      $string = strtr($string, TextHelper::$trans);
      $string = preg_replace("/\-{2,}/","-",$string);
      $string = preg_replace('~[^0-9a-z\s-]+~','',$string); 
      return trim($string,"-"); 
    }

    // public static function InsertAtags($text1)
    // {
    // $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)', 
    //    '<noindex><a href="\\1" rel="nofollow">\\1</a></noindex>', $text1); 
    // $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&//=]+)', 
    //    '<noindex>\\1<a rel="nofollow" href="http://\\2">\\2</a></noindex>', $text); 
    // $text = eregi_replace('([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})', 
    //    '<a href="mailto:\\1">\\1</a>', $text);
    //  return $text;
    // }
    
    public static function replace_links($str)
    {
        return preg_replace('/<a(.+?)href=("|\')(.+?)("|\')(.*?)>(.+?)<\/a>/i', 
        "<a$1href=\"/out.php?link=$3\"$5>$6</a>", $str);
    }

    public static function replace_linksHref($text)
    {
         $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"/out.php?link=$3\" >$3</a>", $text);
         $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http:///out.php?link=$3\" >$3</a>", $text);
         return $text;
    }
}


class SocialButtons{
    
   
    
    public static $_head_tags = "";
    
    public static function Init($title = "",$desc = "",$img = ""){
        
        HTML::addJS(array("/dlight/vendor/socialbuttons.js"));
        
        if( $title && $desc && $img ){
             
            $project_name = APP::Config("PROJECT_NAME");
            $title = htmlspecialchars($title);
            $desc = htmlspecialchars($desc);
            
            SocialButtons::$_head_tags = <<< EOF
            <meta property="og:title" content="$title">
            <meta name="twitter:title" content="$title">
            
            <meta property="og:type" content="article">
            <meta name="twitter:card" content="summary">

            <meta property="og:description" content="$desc">
            <meta name="twitter:description" content="$desc">
            
            
            <meta property="og:image" content="$img" />    
            <link rel="image_src" href="$img" />
            <meta name="twitter:image:src" content="$img">
            
EOF;

//<meta itemprop="description" content="$desc">
//<meta itemprop="image" content="$img">
//<meta itemprop="name" content="$title">
        }
            
    }
    
    public static function RenderHead(){
        echo SocialButtons::$_head_tags; 
    }
    
    public static function getVKLink($url = false){
        if(!$url){
            $url = UrlHelper::getRequestUrl();
        }
        $url = urlencode($url);
        
        return "https://vk.com/share.php?url=" . $url;  
    }
    
    public static function getFBLink($url = false){
        if(!$url){
            $url = UrlHelper::getRequestUrl();
        }
        $url = urlencode($url);
        
        return "https://www.facebook.com/sharer.php?u=" . $url;  
    }
    
    public static function getTWLink($url = false){
        if(!$url){
            $url = UrlHelper::getRequestUrl();
        }
        $url = urlencode($url);
        
        return "https://twitter.com/share?url=" . $url;  
    }
    
    public static function getGPLink($url = false){
        if(!$url){
            $url = UrlHelper::getRequestUrl();
        }
        $url = urlencode($url);
        
        return "https://plus.google.com/share?url=" . $url;  
    }
}


class DataHelper
{
    
    public static function RandValue($num)
    {
          $name="";
          for ($i=0;$i<$num;$i++){
              $name .= chr(rand(97,121));
          }
          return $name;
    }

    
    public static function getImgExt($imgtype)
    {
    if(strstr($imgtype,"image"))
        {
            if($imgtype=="image/jpeg")
            {       
                return "jpg";
            }
            if($imgtype=="image/gif")
            {       
                return "gif";
            }
            if($imgtype=="image/png")
            {       
                return "png";
            }
            return "jpg";
        }
        else
        {
           return false;
        } 

    }

    
    public static function getSite($website)
    {
    if(!strstr($website,"http://") && !strstr($website,"https://")){
        
        return "http://".$website;   
    }
    else
        return $website;
    }
    
    
    public static function getPhone($ccode,$code,$number,$name="",$department="")
    {
        $str="+{$ccode} ({$code}) {$number}";
        if($name&&$department)
            $str.=" - {$name} ({$department})";
        elseif($name)
            $str.=" - {$name}";
        elseif($department)
            $str.=" - {$department}";
            
        return $str;
    }
    
    public static function getPriceFormat($price)
    {
        return "€ " . number_format($price, 2, '.', '');   
    }

    public static function checkbox_verify($_name)
    {
        $result=0;
        if (isset($_REQUEST[$_name]))
        { 
            if ($_REQUEST[$_name]=='on') { $result=1; } else { $result=0; }
        }
        return $result;
    }
   
    
    public static function IsCharsName($string)
    {
        return preg_match("/^[a-zA-Zа-яА-Я\s]+$/",$string);
    }

    public static function IsStrictName($string)
    {
        return preg_match("/^[-а-яА-Яa-zA-Z0-9\"\.,\s]+$/",$string);
    }

    public static function IsStrictPhone($string)
    {
        return preg_match("/^[-\s0-9\(\)\+]+$/",$string);
    }


    public static function IsDigits($string)
    {
        return preg_match("/^[0-9\s]+$/",$string);
    }


    public static function IsUsualString($string)
    {
        return preg_match("/^[-a-zA-Z0-9\sа-яА-Я,\.:;\?\(\)%=_+@\"\/]+$/",$string);
    }


    public static function IsNum($string)
    {
        return is_numeric($string)&&preg_match("/^[0-9]{1,13}$/",$string);
    }

    public static function checkEmail($email)
    {       
        return preg_match("|^([-a-z0-9_\.]{1,20})@([-a-z0-9\.]{1,20})\.([a-z]{2,4})|is", strtolower($email));
    }
}


class DateHelper
{
    public static $_month_arr=array("sm01"=>"января",
                                    "sm02"=>"февраля",
                                    "sm03"=>"марта",
                                    "sm04"=>"апреля",
                                    "sm05"=>"мая",
                                    "sm06"=>"июня",
                                    "sm07"=>"июля",
                                    "sm08"=>"августа",
                                    "sm09"=>"сентября",
                                    "sm10"=>"октября",
                                    "sm11"=>"ноября",
                                    "sm12"=>"декабря");
                                    
    
                                    

    public static function formatWords($date,$is_year=false)
    {
        list($year,$month,$day)=explode("-",$date);
        $day=(int)$day;
        
        if(!$is_year)
            $year="";
        
        return $day." ".DateHelper::$_month_arr["sm".$month]." ".$year;
    }
    
    public static function formatDateTime($datetime,$format)
    {
        list($date,$time) = explode(" ",$datetime);
        list($hours,$mins,$secs)=explode(":",$time);
        list($year,$month,$day)=explode("-",$date);
        $day=(int)$day;
        
        return str_replace(array("%d","%m","%y","%h","%i","%s"),array($day,$month,$year,$hours,$mins,$secs),$format);
    }
    
}
