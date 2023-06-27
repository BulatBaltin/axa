<?

class ROUTER
{
 private static $_url_prefix_key;
 private static $_url_prefix_template;
 private static $_url_prefix_default;
 private static $_slug_redirect;
 private static $_main_slug = 'main';

 public static $_controller_file_php;
 public static $_view_file_php;

 public static $_action_name;
 public static $_project_path;
 public static $_project_name;
 public static $_module_name;
 public static $_module_path;
 public static $_method_name; // POST, GET
 public static $_current_route;
 public static $_project_routes;
 public static $_module_routes;
 public static $_app_routes;
 public static $_cargo;

 private $_project;
 private $_module;
 private $_prefix;
 
//  public static function addRoute($routes)
//  {
//        foreach($routes as $key=>$value)
//            Self::$_app_routes[$key]=$value;
//  }

function __construct()
{
    $this->_project = '';
    $this->_module = '';
    $this->_prefix = '';
}

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

public static function ModuleRoute($slug, $template, $project_module) {
    $parts = explode(':', $project_module);
    if(count($parts) > 1) {
        $project = $parts[ 0 ];
        $module = $parts[ 1 ];
    } else {
        $project = DEFAULT_PROJECT;
        $module = $project_module;
    }

    Self::$_module_routes[] = [
        'slug' => $slug, 
        'template' => $template, 
        'project' => str_replace('.','/', $project),
        'module' => str_replace('.','/', $module)
    ];
}
public static function ProjectRoute($slug, $template, $project = null) {
    if(!$project) $project = DEFAULT_PROJECT;
    Self::$_project_routes[] = [
        'slug' => $slug, 
        'template' => $template, 
        'project' => str_replace('.','/', $project)
    ];

}

public static function Route($slug, $template, $action, $regularExp = null, $get_params = null)
{
    if(strpos($template,'/') == 0) {
        $template = trim($template, '/');
    }
    [ $method, $path, $project, $module, $action ] = self::get_method( $template, $action );
    if(self::$_url_prefix_key) {
        $regularExp[self::$_url_prefix_key] = self::$_url_prefix_template;
    }
    $routeInfo = [
        'slug' => $slug, 
        'url_templ' => $path, 
        'method' => $method,
        'project' => str_replace('.','/', $project),
        'module' => str_replace('.','/', $module),
        'action' => str_replace('.','/', $action)
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
        $method = ''; // "GET";
        $path   = $template;
    }
    $path = Self::set_url_prefix($path);
    $parts = explode(':', $execute); // project
    if(count($parts) > 1) {
        $project = $parts[ 0 ];
        $execute = $parts[ 1 ];
    } else {
        $project = DEFAULT_PROJECT; 
    }

    $parts = explode('@', $execute);
    if(count($parts) > 1) {
        $module = $parts[ 0 ];
        $action = $parts[ 1 ];
    } else {
        $module = "";
        $action = $execute;
    }

    return [$method, $path, $project, $module, $action];
  }

  // it handles actual URLs
  private static function getPageFromRouter()
  {
     $uri=trim($_SERVER['REQUEST_URI'],'/');
     $method=$_SERVER['REQUEST_METHOD'];
// dump('URI', $uri);                    

     [$uri, $get_params] = array_pad(explode("?", $uri, 2), 2, null);
     $uri = trim($uri,'/');

     if(isset(Self::$_slug_redirect[$uri])) {
        $uri = Self::$_slug_redirect[$uri];
     }

     if(Self::$_project_routes) {
// dump('Projects', Self::$_project_routes);                    
        foreach(Self::$_project_routes as $project_route)
        {
            if( preg_match('#^'. $project_route['template'].'#i', $uri, $matches)) {

                $route_php = APPROOT . $project_route['project'] . '/routes.php';

                if(file_exists($route_php)) {
// dump('Module:include' . $route_php);                    
                    include_once($route_php);
                } 
            }
        }
     }
     if(Self::$_module_routes) {
        foreach(Self::$_module_routes as $module_route)
        {
            if( preg_match('#^'. $module_route['template'].'#i', $uri, $matches)) {

                $route_php = APPROOT . 
                    $module_route['project'] . '/' . 
                    $module_route['module']  . '/routes.php';

                if(file_exists($route_php)) {
// dump('Module',$route_php);                    
                    include_once($route_php);
                } 
            }
        }
     }

// dd(Self::$_app_routes);     

     foreach(Self::$_app_routes as $route_obj)
     {

         $route_method = $route_obj['method'];

         if($route_method and stripos($route_method,$method) === false) continue;

         $route=$route_obj['url_templ'];
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

// dd($route_for_match);     

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

                $route_project  =$route_obj['project'];
                $route_module   =$route_obj['module'];
                $route_action   =$route_obj['action'];

                return [$method, $route_project, $route_module, $route_action ];
             }
         }
     }
     return ["", false, false, false ]; 
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
  
 public static function get_url($slug, $params=[], $full_domain = false, $debug=false)
 {

    if($slug == 'blog') {
        $debug = true;
    }

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
 
    if(Self::$_project_routes) {
// if($debug) {
//     dymp('STEP-1',$slug,Self::$_project_routes);
// }
        
        foreach(Self::$_project_routes as $project_route)
        {
// if($debug) {
//     dymp('STEP-2.X search', $slug, $project_route['slug']);
// }
            if( preg_match('/^('.$project_route['slug'].')(\.|$)/i', $slug, $matches)) {
// if($debug) {
//     dymp('STEP-2.0 FOUND', $slug, $project_route['slug'], $matches);
// }
                
                $route_php = APPROOT . 
                $project_route['project'].'/routes.php';
                if(file_exists($route_php)) {
// if($debug) {
//     dymp('STEP-2',$slug,$route_php);
// }
                    include_once($route_php);
                } 
            } 
        }
    }

    if(Self::$_module_routes) {
        foreach(Self::$_module_routes as $module_route)
        {
            // if( preg_match('/^('.$module_route['slug'].')\\.|$/i', $slug, $matches)) {
            if( preg_match('/^('.$module_route['slug'].')(\.|$)/i', $slug, $matches)) {

                $route_php = APPROOT . 
                $module_route['project'].'/'.
                $module_route['module'] .'/routes.php';
                if(file_exists($route_php)) {
// if($debug) {
//     dymp('STEP-3',$slug,$route_php);
// }
                    include_once($route_php);
                } 
            } 
        }
    }
// if($debug) {
//     dymp('STEP-4',$slug,Self::$_app_routes);
// }
        
    if(isset(Self::$_app_routes[$slug]))
    {
        $route_obj = Self::$_app_routes[$slug];
        if($params && is_array($params))
        {
            $get_param_str = '';
            $get_param = [];
            $url_templ = $route_obj['url_templ'];
            foreach($params as $key=>$value)
            {
                $long_key =  '{'.$key.'}';
                if(strpos($url_templ, $long_key) !== false) {
                    $url_templ = str_replace($long_key, $value, $url_templ );
                } else {
                    $get_param[$key] = $value;
                }
            }
            if(count($get_param) > 0) $get_param_str = http_build_query($get_param);
            if($get_param_str) $get_param_str = '?' . $get_param_str;

            return $domain."/".$url_templ . $get_param_str;
        }
        
        return $domain."/".$route_obj['url_templ']; 
    } 
    return false;
 }
 
public static function ControllerFile($file_php = false)
{
if($file_php)
    Self::$_controller_file_php=$file_php;
else
    return Self::$_controller_file_php ?? '';
}
public static function ViewFile($file_php = false)
{
if($file_php)
    Self::$_view_file_php=$file_php;
else
    return Self::$_view_file_php;
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
    if($value) {
        Self::$_module_name = $value;
        Self::$_module_path = Self::$_project_path . $value . '/';
    }
    else
        return Self::$_module_name;
 }
 public static function ModulePath($value=false)
 {
    if($value)
        Self::$_module_path=$value;
    else
        return Self::$_module_path;
 }
 public static function ProjectPath($value=false)
 {
    if($value)
        Self::$_project_path = $value;
    else
        return Self::$_project_path;
 }
 
 public static function ProjectName($value=false)
 {
    if($value) {

        Self::$_project_name = $value;
        Self::$_project_path = APPROOT.str_replace('.','/',$value) .'/';
    } else
        return Self::$_project_name;
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
 
 public static function setPage(
    $method, 
    $project, 
    $module_name, 
    $action_name, 
    $full_name_file_php, 
    $full_name_file_view_php, 
    $cargo = false)
 {
    Self::MethodName($method);
    Self::ProjectName($project);
    Self::ModuleName($module_name);
    Self::ActionName($action_name);
    Self::ControllerFile($full_name_file_php);
    Self::ViewFile($full_name_file_view_php);
    if($cargo) Self::$_cargo = $cargo;
 }
  
public static function setPage404($file, $kod404 = '404') {

    $route404 = Self::getRouteInfo(APP::Config("404_PAGE"));

    $file_base = APPROOT . 
    $route404['project'] . '/' .
    $route404['module'] . '/' .
    $route404['action'];

    // dump($route404, $file_base);

    Self::cargo([
        'uri: '. $_SERVER['REQUEST_URI'], 
        'method: ' .$_SERVER['REQUEST_METHOD'],
        'file: ' . $file  
    ]);


    Self::setPage("GET", 
        $route404['project'], 
        $route404['module'], 
        $route404['action'], 
        $file_base . '.php',
        $file_base . '.view.php',
        Self::cargo()
    );


 }
 public static function getPageFromRequest()
 {
      
    [$method, $project, $module, $action ] = Self::getPageFromRouter();

    if($project === false) {

        Self::setPage404( ROUTER::ControllerFile() );
        return;
    }    

    //проверяем, что модуль и action существует
    $module = trim($module,'.');
    $file_name = APPROOT . $project. '/' . $module."/". $action;
    $file_name = str_replace('.', '/', $file_name);

    $file_php   = $file_name.'.php';
    if(!file_exists( $file_php)) $file_php = '';
    $file_view  = $file_name.'.view.php';
    if(!file_exists( $file_view)) $file_view = '';
    
    if(!$file_php and !$file_view)
    {

        $mssg = 'Controller and View files not found. Module: '. $module . '; Action: '.$action;
        App::displayError(404, $mssg, 'router.php', 521);
        // Self::setPage404($mssg);
        // throw new Exception($mssg, 404);
        return;
    }
    // dd("======",$method, $project, $module, $action);
    Self::setPage($method, $project,  $module, $action, $file_php, $file_view);
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
    if(Self::getPage()==$module_action) return true;
    return false;
 }
 
 
 public static function isUrlOnlyDomain(){
    $uri=trim($_SERVER['REQUEST_URI'],'/');
    if($uri=="") return true;
    return false;
 }
 
 public static function isCurPageBySlug($slug)
 {
    $route=Self::getRouteInfo($slug);
    if($route && Self::ActionName()==$route['action'] && Self::ModuleName()==$route['module'])
        return true;
    
    return false;
 }
 
    function Project(string $node) {
        $this->_project = $node ? $node : '';
        return $this;
    }
    function Folder(string $node) {
        $this->_module = $node ? $node : '';
        return $this;
    }
    function Module(string $node) {
        $this->_module = $node ? $node : '';
        return $this;
    }
    function Prefix(string $prefix) {
        $this->_prefix = $prefix ? $prefix .'.' : '';
        return $this;
    }
    function Add(
        string $slug, 
        string $template, 
        string $action,
        $regularExp = null, 
        $get_params = null) {

        $action = (strpos($action,'@') === false) ? $action = '@'.$action : '.'.$action; 
        $project = $this->_project ? $this->_project . ':' : ''; 
        $action = $project . $this->_module . $action;
        $slug = trim($this->_prefix . $slug, '.');
        self::Route($slug, $template, $action, $regularExp, $get_params);
        return $this;
    }
}
function get_url( $slug, $params = [], $full_domain = false, $debug=false ) {
    // get_url();
    return ROUTER::get_url($slug,$params, $full_domain, $debug);  ;
}
function route( $slug, $params = [], $full_domain = false, $debug=false ) {
    // get_url();
    return ROUTER::get_url($slug,$params, $full_domain, $debug);  ;
}
function generateUrl( $slug, $params = [], $full_domain = false, $debug=false ) {
    // === route();
    return ROUTER::get_url($slug,$params, $full_domain, $debug);  ;
}
function path( $slug, $params = [], $full_domain = false, $debug=false ) {
    // get_url();
    echo ROUTER::get_url($slug,$params, $full_domain, $debug);  ;
}
?>