<?php
  
class APP
{
    const VIEW_LAYOUT = 1;
    const VIEW_DIRECT = 2;

    public static $debug=false;
    public static $_dev_environment=false;
    public static $_const_params;
    public static $_app_config;
    public static $_app_plugins;
    public static $_generate_view= self::VIEW_LAYOUT; //true;
    public static $_app_name="frontend";
    public static $_controller_file_name;
    public static $error;

    public static function DisplayError($code, $message, $file, $line) {
        if(isset(self::$error)) {
            self::$error->DisplayError($code, $message, $file, $line);
        }
    }
    public static function Run($app_name="frontend")
    {
        self::Name($app_name);
        // $script_begin_time = microtime(true);
        self::IncludeAll();

        self::$error = new IdealErrorHandler;

        self::CheckIPAllow();
        date_default_timezone_set(self::Config("TIME_ZONE"));
        // route prefix is checked
        self::checkForBaseRedirects();
                
        // DataBase::Connect();
        self::setControllerFileName();
        // STAT::beginScript($script_begin_time);

        ROUTER::getPageFromRequest();

        // if($app_name=="backend"){
        //     $lang=Local::getLang();
        //     if(file_exists("langs/".$lang.".php"))
        //         include_once("langs/".$lang.".php");   
        // }
        
        // if(self::Config("MultiLang")){
        //     if(!REQUEST::getParam('lang',false))
        //     {
        //         UrlHelper::Redirect(UrlHelper::getMainPage(),"301");                
        //     }       
        //   $lang=Local::getLang();
        //   if(file_exists("langs/".$lang.".php"))
        //     include_once("langs/".$lang.".php");   
        // }
            
        // PluginManager::invokeEvent("preController");
        
        //запускаем все контроллеры
        try
        {
            DataBase::Connect();

            // Step 1.
            $file = LAYOUT . 'prefix.php';
            file_exists($file) and include($file);
            
            // Step 2.1
            //контроллер construct модуля!
            $file = ROUTER::ProjectPath()."__construct.php";
            file_exists($file) and include($file);

            // Step 2.2
            //контроллер construct модуля!
            $file = ROUTER::ModulePath()."__construct.php";
            file_exists($file) and include($file);
            
            // Step 3.
            //контроллер для action'a
            $file = ROUTER::ControllerFile();
            $file and file_exists($file) and include($file);
            
            // Step 4.
            $file = LAYOUT . 'postfix.php';
            file_exists($file) and include($file);
                    
        }
        catch (Exception $e){
            //$global_error=$e->getMessage();
            dlError::addError($e->getMessage(),"GlobalError");
        }

        // PluginManager::invokeEvent("postController");
        // генерируем вид
        
        if(self::isLayout()) // Regular way to work;   self::GenerateView()) 
        {
            // view для action'a with layout
            $file = LAYOUT . 'main.view.php';
            file_exists($file) and include($file);

        } else { // to build a page from zero level :)

            //view для action'a
            $file = ROUTER::ViewFile();
            $file and file_exists($file) and include($file);
            
        }
    }

    public static function IncludeAll()
    {
        //конфиг фреймворка
        include_once( DMIGHT . "config/config.php");
        //ядро
        include_once( DMIGHT . "core/database.php");
        // include_once( DMIGHT . "core/dlplugin.php");
        FILE_SYSTEM::includeDir( DMIGHT . "core/");
        //конфигурации проекта
        FILE_SYSTEM::includeDir( CONFIG );
        //плагины
        // FILE_SYSTEM::includeDir( DLIGHT . "plugins/");
        //библиотеки
        // FILE_SYSTEM::includeDir( DMIGHT . "lib/");
        // require_once( DMIGHT . "lib/phpthumb/ThumbLib.inc.php");
        //модель проекта
        // FILE_SYSTEM::includeDir( MODELS );
        //языки проекта, если есть
        FILE_SYSTEM::includeDir( APPROOT . 'lang/' );

        include_once( DMIGHT . "autoload.php");
        
    }

    public static function CheckIPAllow()
    {
        $ipAllow = self::Config("ipAllow");
        if(is_array($ipAllow)&&count($ipAllow))
        {
            if(!in_array(REQUEST::GetIp(),$ipAllow))
            {
                echo self::Config("disallowText");                    
                exit(); 
            }
        }
    }

    public static function checkForBaseRedirects(){
        $uri=$_SERVER['REQUEST_URI'];
        if($uri=="/index.php"){
            UrlHelper::Redirect(UrlHelper::getMainPage(),"301");
        }
        //    if(self::Config("MultiLang")&&$uri=="/"){
        if(ROUTER::isPrefix() && $uri=="/"){
            UrlHelper::Redirect(UrlHelper::getMainPage(),"301");
        }    

        if($uri!="/"&&substr($uri, strlen($uri)-1, strlen($uri))=="/"){
            UrlHelper::Redirect(substr($uri, 0, strlen($uri)-1),"301");
        }    
    }

    public static function isLayout($value = null)
    {
        if($value !== null)
            self::$_generate_view = $value ? self::VIEW_LAYOUT : self::VIEW_DIRECT;
        return self::$_generate_view === self::VIEW_LAYOUT;
    }
    public static function GenerateView($value="")
    {
        if($value==="")
            return self::$_generate_view;
        else
            self::$_generate_view=$value;
    }
    
    public static function addPlugin($plugins)
    {
        return PluginManager::addPlugin($plugins);
    }
    
    public static function activePlugin($plugin_name)
    {
        return PluginManager::activePlugin($plugin_name);
    }
    
    public static function setConfig($app_config)
    {
        foreach($app_config as $key=>$value)
            self::$_app_config[$key]=$value;
    }
    
    public static function setConstant($const_params)
    {
        foreach($const_params as $key=>$value)
            self::$_const_params[$key]=$value;
    }
        
    public static function setDevEnvironment($value)
    {
      self::$_dev_environment=$value;
    }
    
    public static function isDevEnvironment()
    {
      return self::$_dev_environment;
    }
    
    public static function Config($label,$def_value=false)
    {
        if(isset(self::$_app_config[$label]))
            return self::$_app_config[$label];
        else
            return $def_value;
    }
    
    public static function Constant($label,$value=false)
    {
        if(!$value){
            if(isset(self::$_const_params[$label]))
                return self::$_const_params[$label];
            else
                return null;
        }
        else
            self::$_const_params[$label]=$value;
    }
       
    public static function CheckForHttpsRedirect(){
    
        if(UrlHelper::Protocol()=="https" && (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off")){
            $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: ' . $redirect);
            exit();
        }
    }
// Need them ? --------]    
    public static function setControllerFileName()
    {
        self::$_controller_file_name=str_replace("/","",$_SERVER['SCRIPT_NAME']);
    }
 
     public static function Name($value=false)
     {
         if(!$value)
             return self::$_app_name;
         else
             self::$_app_name=$value;
     }
     
     public static function getStaticContentCacheParam(){
         return "?v83k";    
     }
     public static function getControllerFileName()
     {
         return self::$_controller_file_name;
     }
     
     public static function getControllerName()
     {
         $arr=explode(".",self::$_controller_file_name);
         return $arr[0];
     }
     
     public static function RunForAjax($app_name="frontend")
     {
         self::Name($app_name);
         self::IncludeAll();
         self::CheckIPAllow();
         date_default_timezone_set(self::Config("TIME_ZONE"));
         DataBase::Connect();
         self::setControllerFileName();
     }
      
    // function Param($labels)
    // {
    //     $params_gateway=new params();
        
    //     if(is_array($labels))
    //     {
    //         $rec=$params_gateway->getRecFieldsById(1,$labels);
    //         $result=array();
    //         for($i=0;$i<count($labels);$i++)
    //             $result[]=$rec[$labels[$i]];
    //         return $result;
    //     }
    //     else
    //     {
    //         $rec=$params_gateway->getRecFieldsById(1,array($labels));
    //         return $rec[$labels];
    //     }
    // }
}

include_once("file_system.php");
