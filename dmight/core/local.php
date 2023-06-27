<?php

//языки проекта, если есть добавляются в IncludeAll()
// FILE_SYSTEM::includeDir( APPROOT . '/langs' );

class Local
{
    
    public static $_translation;
    public static $_langs = ['en'=>'en','uk'=>'uk'];
    public static $_langNames = ['en'=>'ENG', 'uk'=>'UKR'];


    public static function getLangs(){
        return Local::$_langs;
    }

    public static function getAlternativeLangs($lang,$uri = false){
        return Local::$_langs;
    }

    public static function getLangName(string $lang)
    {
        return self::$_langNames[$lang];
    }


    public static function getLangsInfo($uri = false){
        $cur_lang = Local::getLang();
        $result = [];
        foreach(Local::getLangs() as $key=>$lang){
            $url = self::getPageUrlWithOtherLang($cur_lang,$lang,$uri);
            $selected = ( $cur_lang == $lang )?true:false;
            $result[$lang] = ["name"=>$key,"url"=>$url,"selected"=>$selected];
        }
        return $result;
    }
    
    public static function addTranslation($translation,$lang="")
    {
        if(is_array($translation))
        {
            foreach($translation as $key=>$value)
            {
               Local::$_translation[$lang][$key]=$value; 
            }
        }
    }
    
    public static function Translate($slug,$lang="")
    {
        if(!$lang){
            $lang = Local::getLang();
        }
        if(!isset(Local::$_translation[$lang][$slug])||!Local::$_translation[$lang][$slug]){
            return $slug;
        }
        if(Local::isLang("uk")){
            return str_replace("i","і",Local::$_translation[$lang][$slug]);
        }
        else{
            return Local::$_translation[$lang][$slug];
        }
    }
    
    
    
    public static function getSessionLang()
    {
        if(isset($_SESSION['lang']))
            return $_SESSION['lang'];
        else
            return "";
    }

    public static function setSessionLang($lang)
    {
        $_SESSION['lang']=$lang;
    }


    public static function getCOOKIELang()
    {
        if(isset($_COOKIE['lang']))
            return $_COOKIE['lang'];
        else
            return "";
    }

    public static function setCOOKIELang($lang)
    {
        $time=mktime(date("H"), date("i"), date("s"), date("m")+12, date("j"), date("Y"));
        setcookie("lang", $lang, $time);
    }
    
    public static function getPageUrlWithOtherLang($cur_lang,$new_lang,$url=false)
    {
        if(!$url)
            $url=$_SERVER['REQUEST_URI'];
        return str_replace(array("/{$cur_lang}","&lang={$cur_lang}"),array("/{$new_lang}","&lang={$new_lang}"),$url);
    }


    public static function getLang($default_language=false)
    {
        return 'en';
        $lang=false;
        if(isset($_GET['lang'])&&in_array($_GET['lang'],Local::getLangs()))
        {
            $lang=$_GET['lang'];
            if(Local::getSessionLang()!=$lang)
            {
                Local::setSessionLang($lang);   
                Local::setCOOKIELang($lang);
            }
        }
        else if(Local::getSessionLang()&&in_array(Local::getSessionLang(),Local::getLangs()))
        {
            $lang=Local::getSessionLang();
        }
        else if(Local::getCOOKIELang())
        {
            Local::setSessionLang(Local::getCOOKIELang());
            $lang=Local::getCOOKIELang();
        }
        else
        {
            if($default_language)
               return $default_language; 

            $def_lang="en";
                
            Local::setSessionLang($def_lang);
            Local::setCOOKIELang($def_lang);
            
            $lang=$def_lang;
        }
        return $lang;
    }        

    public static function isLang($lang)
     {
         if(Local::getLang()==$lang)
            return true;
           else
            return false;    
     }
    
    public static function getDefLanguage()
     {    
         $langcode = (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
         $langcode = (!empty($langcode)) ? explode(";", $langcode) : $langcode;
         $langcode = (!empty($langcode['0'])) ? explode(",", $langcode['0']) : $langcode;
         $langcode = (!empty($langcode['0'])) ? explode("-", $langcode['0']) : $langcode;
         return isset($langcode['0'])?$langcode['0']:"";
     }
     
}
// funcs =======
function getLang($default_language=false)
{
    return Local::getLang($default_language);
}

function isLang($lang)
{
    return Local::isLang($lang);
}

function l($slug)
{
    echo Local::Translate($slug);
}

function Local($slug)
{
    echo Local::Translate($slug);
}

function getLocal($slug)
{
    return Local::Translate($slug);
}
function ll($slug)
{
    return Local::Translate($slug);
}
