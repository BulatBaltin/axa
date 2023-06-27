<?

class ROUTER
{
 private static $_url_prefix_key;
 private static $_url_prefix_template;
 private static $_url_prefix_default;
 private static $_slug_redirect;
 private static $_main_slug = 'main';
 public static $_action_name;
 public static $_module_name;
 public static $_method_name; // POST, GET
 public static $_app_routes;
 public static $_module_routes;
 public static $_current_route;
 public static $_cargo;
 
//  public static function addRoute($routes)
//  {
//        foreach($routes as $key=>$value)
//            Self::$_app_routes[$key]=$value;
//  }

public static function Route2Route( $uri, $slug )
 {
    self::$_slug_redirect[$uri] = $slug;
 }
public static function urlPrefix( $key, $template, $default )
 {
    self::$_url_prefix_key = $key;
    self::$_url_prefix_template = $template;
    self::$_url_prefix_default = $default;
 }
public static function isPrefix()
{
    return self::$_url_prefix_key;
}
public static function cargo( $value = null )
 {
     if($value) self::$_cargo = $value;
     return self::$_cargo;
 }

public static function getMainSlug()
{
    return self::$_main_slug;
}
 
public static function Main($slug, $template, $action, $regularExp = null, $get_params = null)
{
    self::$_main_slug = $slug;
    return self::Route($slug, $template, $action, $regularExp, $get_params);
}
public static function Route($slug, $template, $action, $regularExp = null, $get_params = null)
{
    if(strpos($template,'/') == 0) {
        $template = trim($template, '/');
    }
    list($method, $path, $module, $action) = self::get_method( $template, $action );
    if(self::$_url_prefix_key) {
        $regularExp[self::$_url_prefix_key] = self::$_url_prefix_template;
    }
    $routeInfo = [
        'slug' => $slug, 
        'url_templ' => $path, 
        'method' => $method,
        'module' => $module,
        'action' => $action
    ];
    if($regularExp) $routeInfo['var_templates']=$regularExp;
    if($get_params) $routeInfo['get_params']=$get_params;

    Self::$_app_routes[$slug]=$routeInfo;
  }
  
  private static function set_url_prefix($template) {
    if(Self::$_url_prefix_key and is_string(Self::$_url_prefix_key) ) {
        $path='{' . Self::$_url_prefix_key .'}' .'/'. $template;
        return trim($path, '/');
    }
    return $template;
  }
  public static function get_method($template, $execute) {
    $parts = explode(':', $template);
    if(count($parts) > 1) {
        $method = $parts[ 0 ];
        $path = $parts[ 1 ];
    } else {
        $method = "GET";
        $path = $template;
    }
    $path = Self::set_url_prefix($path);
    $parts = explode('@', $execute);
    if(count($parts) > 1) {
        $module = $parts[ 0 ];
        $action = $parts[ 1 ];
    } else {
        $module = "";
        $action = $execute;
    }

    return [$method, $path, $module, $action];
  }

  // it handles actual URLs
  public static function getPageFromRouter()
  {
     $uri=trim($_SERVER['REQUEST_URI'],'/');
     $method=$_SERVER['REQUEST_METHOD'];

     list($uri, $get_params) = array_pad(explode("?", $uri, 2), 2, null);
     $uri = trim($uri,'/');

     if(isset(Self::$_slug_redirect[$uri])) {
        $uri = Self::$_slug_redirect[$uri];
     }

     foreach(Self::$_app_routes as $route_obj)
     {
         $route_method = $route_obj['method'];

         if(stripos($route_method,$method) === false) continue;

         $route=$route_obj['url_templ'];
         $route_module=$route_obj['module'];
         $route_action=$route_obj['action'];
         $route_slug=$route_obj['slug'];

        //  if($route && $route_slug)
         if($route_slug)
         {
            $route_for_match = $route;

             $route_var_templates = [];
             if(isset($route_obj['var_templates'])){
                 $route_var_templates = $route_obj['var_templates'];     
                 foreach($route_var_templates as $var_name=>$var_template){
                    $var_template = strtolower($var_template);
                     if($var_template == "number") {
                        $var_template = "([0..9]+)";
                     } elseif($var_template == "usual") {
                        $var_template = "([a-z0..9_\-]+)";
                     }
                     // Change standart "([^\s/]+)" to unique one
                     $route_for_match=preg_replace("/{".$var_name."}/",$var_template,$route_for_match);
                 }
            }

             //1. заменяем для того чтобы проверить шаблон на соотвествие с текущим URI
             // ... нотация !id
            //  $route_for_match=preg_replace("/!(\w+)/","([^\s]+)",$route_for_match);
             // ... или нотация {id}
             // It was [^\s] I changed to [^\s/] -> to be [^\s\/]
             $route_for_match=preg_replace("/{(\w+)}/","([^\s/]+)",$route_for_match);
             $route_for_match=str_replace("/","\/",$route_for_match);
            //2. проверяем шаблон на соотвествие с текущим URI
            if(preg_match("/^".$route_for_match."$/", $uri, $matches_values))
            {
                 //3. получаем имена переменных, которые нужно установить в $_GET
                 preg_match_all("/{(\w+)}/", $route, $matches);

                 $var_names=$matches[1]; //имена переменных которые нужно установить в $_GET
                 
                 //4. Устанавливаем переменные в $_GET 
                 for($i=0;$i<count($var_names);$i++)
                     $_GET[$var_names[$i]]=$matches_values[$i+1];
                     
                 if(isset($route_obj['get-params'])) {
                     $get_params = $route_obj['get-params'];
                     foreach($get_params as $key=>$val)
                     $_GET[$key]=$val;
                }

                 Self::$_current_route = $route_obj;
                  
                 if(isset($_GET['action']) && isset($_GET['module']))
                     return [$method, $_GET['module']."/".$_GET['action']];
                 else if(isset($_GET['action'])&&!isset($_GET['module']))
                     {
                         if(!$route_module)
                             $route_module="main";
                         return [$method, $route_module."/".$_GET['action']];    
                     }
                 else
                     return [$method, $route_module."/".$route_action ];
             }
         }
     }
     return ["", false ]; 
  }
public static function hasSlug($slug) //+
  {
     return self::isCurrentRoute($slug);
  }
  public static function isCurrentRoute($slug)
  {
        if(Self::$_current_route['slug'] == $slug){
            return true;
        }
        return false;
  }
    
  public static function getRouteInfo($slug = null)
  {
        return $slug ? Self::$_app_routes[$slug] ?? false : Self::$_current_route;
  }
  public static function getRouteSlug()
  {
        $info = Self::getRouteInfo();
        return $info ? $info['slug'] : false;     
  }
  
 public static function get_url($slug,$params=false,$full_domain = false)
 {
    //  if(APP::Config("MultiLang") && !isset($params['lang']))
    //  {
    //     $params['lang']=Local::getLang();
    //  }
    
    // dd($params[ Self::$_url_prefix_key ]);

    if( !isset($params[ Self::$_url_prefix_key]) ) {
        $params[ Self::$_url_prefix_key] = Self::$_url_prefix_default;
    }
    
     $domain = "";
     if($full_domain===true){
         $domain = UrlHelper::getHttpHostUrl(); 
     }
     elseif($full_domain){
        $domain = $full_domain;
     }
// if($slug == 'dashboard-roles') {
//     var_dump(Self::$_app_routes);
//     die;
// }     
    // foreach(Self::$_app_routes as $route_obj)
    if(isset(Self::$_app_routes[$slug]))
    {
        $route_obj = Self::$_app_routes[$slug];

            if($params && is_array($params))
            {
                $keys_arr=array();
                $values_arr=array();
                foreach($params as $key=>$value)
                {
                    // $keys_arr[]="!".$key;
                    $keys_arr[]='{'.$key.'}';
                    $values_arr[]=$value;
                }
                return $domain."/".str_replace($keys_arr,$values_arr,$route_obj['url_templ']);
            }
            
            return $domain."/".$route_obj['url_templ']; 
    } 
    return false;
 }
 
 public static function ActionName($value=false)
 {
    if($value)
        Self::$_action_name=$value;
    else
        return Self::$_action_name;
 }
 
 public static function ModuleName($value=false)
 {
    if($value)
        Self::$_module_name=$value;
    else
        return Self::$_module_name;
 }
 public static function MethodName($value=false)
 {
    if($value)
        Self::$_method_name=$value;
    else
        return Self::$_method_name;
 }
 
 public static function getPage()
 {
    return Self::ModuleName()."/".Self::ActionName(); 
 }
 
 public static function setPage($method, $module_name, $action_name, $cargo = false)
 {
    Self::MethodName($method);
    Self::ModuleName($module_name);
    Self::ActionName($action_name);
    if($cargo) Self::$_cargo = $cargo;
 }
  
 public static function getPageFromRequest()
 {
      
    list($method, $page_request) = Self::getPageFromRouter();

    if(!$page_request)
        $page_request=REQUEST::getParam("page",false);
    
    if(!$page_request)
    {
        Self::cargo([
            'uri: '. $_SERVER['REQUEST_URI'], 
            'method: ' .$_SERVER['REQUEST_METHOD'] 
        ]);

        $route404=Self::getRouteInfo(APP::Config("404_PAGE"));
        list($method, $module, $action)=array("GET",$route404['module'],$route404['action']);
        Self::setPage($method, $module, $action);
        
        return;

       // UrlHelper::Redirect404();
       // echo "123";
    }    

    $page_request_parts=explode("/",$page_request);


    if(count($page_request_parts)==1)
    {
        $module="";
        $action=$page_request_parts[0];
    }
    else
    {
        $module=$page_request_parts[0];
        $action=$page_request_parts[1];
    }
            
    //проверяем, что модуль и action существует
    $module = str_replace('.', '/', $module);
    $action = str_replace('.', '/', $action);
    $file_php = BUNDLE . $module."/". $action.".php";
    $file_view = BUNDLE . $module ."/". $action.".view.php";
    // dd("======",$file_php,$file_view);
    
    if(!file_exists( $file_php) and !file_exists( $file_view) )
    {
        // dd($method, $module, $action);
        $route404=Self::getRouteInfo(APP::Config("404_PAGE"));
        list($method, $module, $action)=array("GET",$route404['module'],$route404['action']);
        Self::setPage($method, $module, $action, [
            'Controller: ' . $file_php, 
            'View: ' . $file_view 
            ] );
        return;
    }
    // dd("======",$method, $module, $action);
    Self::setPage($method, $module, $action);
       
 }
  
 public static function isCurPage($action_name,$module_name="main")
 {
     $arr=explode("/",$action_name);
     if(count($arr)>1)
     {
        if(Self::getPage()==$action_name)
            return true;
        else
            return false; 
     }
     else
     {
        if(Self::ActionName()==$action_name&&Self::ModuleName()==$module_name)
            return true;
        else
            return false;
     }
 }
 
 public static function isCurModuleAction($module_action)
 {
    if(Self::getPage()==$module_action)
        return true;
    else
        return false;
 }
 
 
 public static function isUrlOnlyDomain(){
      $uri=trim($_SERVER['REQUEST_URI'],'/');
      if($uri==""){
          return true;
      }
      return false;
 }
 
 public static function isCurPageBySlug($slug)
 {
    $route=Self::getRouteInfo($slug);
    if($route&&Self::ActionName()==$route['action']&&Self::ModuleName()==$route['module'])
        return true;
    else
        return false;
 }
 
}

?>