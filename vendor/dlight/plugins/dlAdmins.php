<?
APP::addPlugin("dladmins");







class dl_sessions extends dlModel {
    
    function __construct(){
        parent::__construct();
        $this->setTableName("dl_sessions","Сессии");
        $this->SetAddText("Добавить сессию");
        
        $this->AddFields(array(            
            array(new Text(uniqid(),STRONG,100),"uid","UID"),
            array(new Text("",NOT_STRONG,100),"data","Данные"),
            array(new DateTimeField(NowDateTime(),NOT_STRONG),"datetime_open","Дата/Время")
        ));        
    }
    
    public function OpenSession($user){
        $uid = uniqid();
        $res = $this->Add(array("NULL",$uid,json_encode($user),NowDateTime()));
        if($res){
            $_SESSION[APP::Config("SESSION_ID")] = $uid;
            return true;
        }
        else{
            return false;
        }
    }
    
    public function getSession($uid = false){
        if($uid===false){
            if(isset($_SESSION[APP::Config("SESSION_ID")])){
                $uid = $_SESSION[APP::Config("SESSION_ID")];     
            }
            else{
                return false;
            }
        }
        $session = $this->getRecFieldsByField("uid",$uid);
        if($session)
            return json_decode($session['data'],true);
        else
            return null;
    }
    
    public function removeSession($uid = false){
        
        if($uid===false){
            if(isset($_SESSION[APP::Config("SESSION_ID")])){
                $uid = $_SESSION[APP::Config("SESSION_ID")];     
            }
            else{
                return false;
            }
        }
        
        unset($_SESSION[APP::Config("SESSION_ID")]);
        return $this->RemoveWhere("uid","=","'".$uid."'");
    }
}

abstract class AuthUsersBase extends dlModel
{
    
    function __construct($fields_names=false,$table_name=false,$table_key=false)
    {
        parent::__construct($fields_names,$table_name,$table_key);
    }
    function preController()
    {
        
        if(APP::Config("dlAuth_enable")&&APP::Config("dlAuth_signin_user_class"))
            {
                if(REQUEST::getParam("logout")=="true"){
                    $this->unsetLoginCookie();    
                }
                
                $signin_user_class=APP::Config("dlAuth_signin_user_class");
                $signin_user_class_gateway=new $signin_user_class();
                $this->activateSession();
                
                if(!AuthUser::isAuthorized()){
                    $signin_user_class_gateway->checkAuth(
                                                        APP::Config("dlAuth_use_cookies"),
                                                        APP::Config("dlAuth_post_login_name"),
                                                        APP::Config("dlAuth_post_login_pass"),
                                                        APP::Config("dlAuth_post_captcha")
                                                        );
                    if(AuthUser::isAuthorized()){
                       //если не был авторизован, а стал авторизованным, то меняем
                       $signin_page_route=ROUTER::getRouteInfo(APP::Config("dlAuth_signin_page"));
                        if(ROUTER::isCurModuleAction($signin_page_route['module']."/".$signin_page_route['action'])){
                           $route = ROUTER::getRouteInfo(APP::Config('dlAuth_after_signin_page')); 
                           ROUTER::setPage($route['method'],$route['module'],$route['action']);
                        } 
                    }
                }
                else{
                    $signin_user_class_gateway->checkExit();
                }   
                    
                if(ROUTER::isCurPageBySlug(APP::Config("dlAuth_restore_page"))){
                    $signin_user_class_gateway->RestorePass(REQUEST::getParam(APP::Config("dlAuth_restore_post_email"),false));
                }  
            }
    }
    
    public function EncryptPass($pass){
        return md5($pass);
    }
    
    public function onAfterAuthorize($user){
        
    }
    
    public function onAfterLogout(){
        
    }
    
    public function activateSession(){
        $session_user_data = dlModel::Create("dl_sessions")->getSession();
        if($session_user_data){
            $this->AuthorizeUser(false,$session_user_data);
        }
        else{
        }
    }
    
    
    public static function CheckPass($id,$pass)
    {
        
        $signin_user_class=APP::Config("dlAuth_signin_user_class");
        $signin_user_class_gateway=new $signin_user_class();
        
        $item=$signin_user_class_gateway->getRecFieldsById($id,array(APP::Config('dlAuth_db_login_pass','pass')));
        if(!$item)
            return false;
            
        if($item[APP::Config('dlAuth_db_login_pass','pass')]==$signin_user_class_gateway->EncryptPass($pass))
            return true;
        else
            return false;
    }
    
    
    
    
    public function RestorePass($email)
    {
        $email=strtolower(trim($email));
        if(!$email)
        {
            dlError::addError(ll("Please, specify your email"),"NoEmail");
            return false;
        }
        
        if(!DataHelper::checkEmail($email))
        {
            dlError::addError(ll("Email wrong format. Please, try again"),"WrongEmail");
            return false;
        }
        
        $email_field=APP::Config("dlAuth_restore_email","email");
        $login_field=APP::Config("dlAuth_restore_login","email");
        $pass_field=APP::Config("dlAuth_restore_pass","pass");
        
        
        $user=$this->getRecFieldsByField($email_field,$email,array($email_field,$login_field,$pass_field));

        if(!$user)
        {
           dlError::addError(ll("We haven't found user connected to this email"),"NoUser");
           return false; 
        }
        
        $new_pass=DataHelper::RandValue(6);
        $new_pass_encrypt=$this->EncryptPass($new_pass);
        $this->UpdateFieldsByField($login_field,$user[$login_field],array($pass_field),array($new_pass_encrypt));
    
            
        MAILER::sendEmail(Local::getLang(),$email,false,"restore_pass",
            array("%%FIO%%","%%project_name%%","%%user_email%%","%%user_pass%%"),
            array("",APP::Constant("project_name"),$email,$new_pass)
        );
        
        /*MAILER::sendEmailQueue($email,false,"restore_pass",
            array("%%FIO%%","%%project_name%%","%%user_email%%","%%user_pass%%"),
            array("",APP::Constant("project_name",""),$email,$new_pass)
        );*/


    }

    public function checkExit()
    {
        $logout_route=ROUTER::getRouteInfo(APP::Config("dlAuth_logout_page"));
        if(ROUTER::isCurPage($logout_route['action'],$logout_route['module']))
        {
           $this->unsetLoginCookie();
           AuthUser::unsetParams();
           dlModel::Create("dl_sessions")->removeSession();
           $this->onAfterLogout();
           UrlHelper::Redirect(UrlHelper::getMainPage()."?logout=true");
        }
    }
    
    public function setLoginCookie($login,$pass)
    {
        REQUEST::Cookies(APP::Name()."_dl_login", $login);
        REQUEST::Cookies(APP::Name()."_dl_pass", $pass);
    }
    
    public function unsetLoginCookie()
    {
        REQUEST::Cookies(APP::Name()."_dl_login", "");
        REQUEST::Cookies(APP::Name()."_dl_pass", "");
    }
    
    public static function renderSocialAuth($id = false){
        if(!$id){
            $id = RandValue(7);        
        }
        $url = urlencode(get_url(APP::Config("dlAuth_social_auth_data_route",APP::Config("dlAuth_signin_page")),array(),true)."?social=true"); 
        echo <<<EOF
            <script src="//ulogin.ru/js/ulogin.js"></script>
            <div id="$id" data-ulogin="display=buttons;fields=first_name,last_name,email;redirect_uri=$url">
                                    
                                <a href="#" data-uloginbutton = "vkontakte"></a>
                                <a href="#" data-uloginbutton = "facebook"></a>
                                <a href="#" data-uloginbutton = "yandex"></a>
                                <a href="#" data-uloginbutton = "odnoklassniki"></a>
            
            </div>
EOF;
    }
    
    public static function getSocialAuthData(){
        $s = file_get_contents('http://ulogin.ru/token.php?token=' . $_POST['token'] . '&host=' . $_SERVER['HTTP_HOST']);
        return json_decode($s, true);
    }
    
    public static function SocialAuthRegisterUser($user_data){
         $pass = RandValue(7); 
         $new_user_id = dls_users::Register($user_data['first_name']." ".$user_data['last_name'],$user_data['email'],$pass,$pass,"");
         if($new_user_id){
            return dlModel::Create("dls_users")->getRecById($new_user_id);
         }
         else{
             return false;
         }
    }
    
    public function checkAuth($use_cookies,$post_login,$post_pass,$post_code=false)
    {   
        $need_login = false;
        $pass=false;
        
        
        
        //авторизация
        if(!REQUEST::getParam("social",false) && ((REQUEST::getParam($post_login)&&REQUEST::getParam($post_pass))||!AuthUser::isAuthorized()))
        {
            $need_login = true;
            $login=false;    
            $cookies_set=false;
            
            $signin_page_route=ROUTER::getRouteInfo(APP::Config("dlAuth_signin_page"));
            
            if(REQUEST::getParam($post_login)&&ROUTER::isCurModuleAction($signin_page_route['module']."/".$signin_page_route['action'])){
                
                $login=trim(strip_tags(REQUEST::getParam($post_login)));
                $pass=$this->EncryptPass(trim(REQUEST::getParam($post_pass)));    
                if(!dlForm::checkCSRFToken()){
                    dlError::addError(ll("Wrong CSRF signature"),"WrongCaptchaCode");
                    return false;
                }
                //echo "авторизация из логина и пароля";
                
            }
            elseif( $use_cookies && REQUEST::Cookies(APP::Name()."_dl_login" )){
                    $login = REQUEST::Cookies(APP::Name().'_dl_login');
                    $pass = REQUEST::Cookies(APP::Name().'_dl_pass');
                    $cookies_set = true;
                  //  echo "авторизация их куков";
            }  
               
                      
            if(!$login||!$pass){
                return false;
            }
                
            
            if($post_code)
                $code=trim(REQUEST::getParam($post_code));
                    
            if($post_code&&$code!=Captcha::getCode())
            {
                dlError::addError(ll("Wrong captcha code. Please, try again"),"WrongCaptchaCode");
                return false;
            }  
            
            
           
          $dlauth_failed_access_log_gateway=new dlauth_failed_access_log();
          //проверка на то, чтобы число неудачных попыток c слогином $login не привышало 
          //APP:Config('dlAuth_wrong_attempts') раз 
          //за последние APP:Config('dlAuth_wrong_attempts_time') мин.
          if(!$dlauth_failed_access_log_gateway->checkAttemptsNum($login)){
            
            dlError::addError(str_replace(["{x}"],[APP::Config('dlAuth_wrong_attempts_time')],ll("You have reached the number of wrong sign in attempts for the last {x} minutes. Please, wait and try again")),"WrongLoginLimitExpired");
            return false;
          }
          
          
          
        }
        
        $social = false;
        
        //авторизация через соц. сети
        if(!AuthUser::isAuthorized()&&REQUEST::getParam("social",false)){
            $need_login = true;
            $social = true;
            $user_data = $this->getSocialAuthData();
            $login = $user_data['email'];
        }
           
        if($need_login){
            
          list($result,$user)=$this->Login($login,$pass,$social);
          
          $new_user = false;
          if($result===false) {
            if($social){
                $user = $this->SocialAuthRegisterUser($user_data);
                $new_user = true;
                //echo "NEW CREATED";
            }
            else{  
                dlError::addError(ll("Wrong combination of login and password"),"WrongLogin");
                // тут нужно записать в лог неудачных авторизаций:
                $dlauth_failed_access_log_gateway->Add(array("NULL",NowDateTime(),$login,REQUEST::GetIp(),APP::Name()));
                return false;
            }
          } 
          
          
          if($result===0) {
            dlError::addError("Your account has been closed till ".FormatDateForView($user),"WrongLogin");
            return false;
          }
          
          //устанавливаем переменные в сессию
          //авторизуемся
          //echo "Auth";
          //print_r($user);
          $this->AuthorizeUser(false, $user, true);
          //echo "END Auth";
          //конец авторизации
          
          if($use_cookies){
            if($new_user){
                $this->setLoginCookie($login,$user['pass']);
            }
            else{
                $this->setLoginCookie($login,$pass);
            }
          }
                  
          //записываем в лог успешных запросов
          $dlauth_access_log_gateway=new dlauth_access_log();
          $dlauth_access_log_gateway->Add(array("NULL",NowDateTime(),$user['id'],REQUEST::GetIp(),APP::Name()));
          
          $this->onAfterAuthorize($user);
          
          
          /*if($social){
            UrlHelper::Redirect(get_url(APP::Config('dlAuth_social_auth_after_login_route')));
          }
            $cookies_set
          //если есть такая настройка, переходим на страницу после авторизации
          if(APP::Config('dlAuth_after_signin_page')&&REQUEST::getParam($post_login)&&ROUTER::isCurModuleAction($signin_page_route['module']."/".$signin_page_route['action'])){
              UrlHelper::Redirect(get_url(APP::Config('dlAuth_after_signin_page')));
              exit();
          }*/
          
          
          /*if(){
                  $route = ROUTER::getRouteInfo(APP::Config('dlAuth_after_signin_page')); 
                  ROUTER::setPage($route['module'],$route['action']); 
          } */ 
           
          
        }
    }
    
    
    
    
    
    
    public function AuthorizeUser($email=false,$user=false,$need_to_open_session = false){
        
         
        
        
        
        if($email){

            $dlAuth_db_login_fields_to_take=APP::Config('dlAuth_db_login_fields_to_take');
          
          if($dlAuth_db_login_fields_to_take){
            if(!is_array($dlAuth_db_login_fields_to_take))
                $dlAuth_db_login_fields_to_take=array($dlAuth_db_login_fields_to_take);
          }
          else{
              $dlAuth_db_login_fields_to_take=array("email","name","id");
          }
           
            $dlAuth_db_login_names=APP::Config("dlAuth_db_login_name");
            if($dlAuth_db_login_names)
            {
                if(!is_array($dlAuth_db_login_names))
                    $dlAuth_db_login_names=array($dlAuth_db_login_names);
            }
            else
              $dlAuth_db_login_names=array("email");
              
              
            foreach($dlAuth_db_login_names as $login_name){
                
                $user=$this->getRecFieldsByField($login_name,$email,$dlAuth_db_login_fields_to_take);
                if($user)
                    break;
            }
            
            if(!$user){
                return false;
            }        
        }
        
        if( ($need_to_open_session&&$user) || $email){
            dlModel::Create("dl_sessions")->openSession($user);
        }
        
        AuthUser::setParams($user); 
        return true;
        
    }
   

    
    
    public function Login($login,$pass,$social = false)
    {
        if(!strlen($login))
        return array(false,false);
        
        
                
        $dlAuth_db_login_names=APP::Config("dlAuth_db_login_name");
        if($dlAuth_db_login_names)
        {
            if(!is_array($dlAuth_db_login_names))
                $dlAuth_db_login_names=array($dlAuth_db_login_names);
        }
        else
          $dlAuth_db_login_names=array("email");
          
          
        $dlAuth_db_login_fields_to_take=APP::Config("dlAuth_db_login_fields_to_take");
        if($dlAuth_db_login_fields_to_take)
        {
            if(!is_array($dlAuth_db_login_fields_to_take))
                $dlAuth_db_login_fields_to_take=array($dlAuth_db_login_fields_to_take);
                
            if(APP::Config('dlAuth_db_ban')&&in_array(APP::Config('dlAuth_db_ban'),$dlAuth_db_login_fields_to_take)===false)
                $dlAuth_db_login_fields_to_take[]=APP::Config('dlAuth_db_ban');
                
        }
        else
            $dlAuth_db_login_fields_to_take=array("email","name","id","pass");
         
        
            
        if(!in_array(APP::Config('dlAuth_db_login_pass','pass'),$dlAuth_db_login_fields_to_take))
            $dlAuth_db_login_fields_to_take[]=APP::Config('dlAuth_db_login_pass','pass');
            
             
        foreach($dlAuth_db_login_names as $login_name)
        {
            $user=$this->getRecFieldsByField($login_name,$login,$dlAuth_db_login_fields_to_take);
            if($user)
                break;
        }
        
         
        if(!$user) {
            return array(false,false);
        }
            
            
            
        
        if(APP::Config('dlAuth_db_ban')&&$user[APP::Config('dlAuth_db_ban')]&&$user[APP::Config('dlAuth_db_ban')]!="0000-00-00")
        {
            $ban_array=explode("-", $user[APP::Config('dlAuth_db_ban')]);
            $now = time();
            $ban=mktime(0, 0, 0, $ban_array[1], $ban_array[2], $ban_array[0]);    
            if($now-$ban<0)
                return array(0,$user[APP::Config('dlAuth_db_ban')]);;
        }
             
        if(!$social && $user[APP::Config('dlAuth_db_login_pass','pass')]!=$pass){
            return array(false,false);
        }
            
            
        
        return array(true,$user);
    }
    
    
    
}



class dlauth_access_log  extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id","datetime","user_id","ip","app_name"),"dlauth_access_log","id");
        $this->setTableRus("Лог успешных авторизаций",array("ID","Дата/время","ID Пользователя","IP","Приложение"));
        
        $this->SetAddText("Добавить авторизацию");

        $this->AddFieldType(new ID());
        $this->AddFieldType(new DateTimeField(NowDateTime(),STRONG));
        $this->AddFieldType(new Text("",STRONG,10));
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new Text("",STRONG,40));
    }
}


class dlauth_failed_access_log  extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id","datetime","login","ip","app_name"),"dlauth_failed_access_log","id");
        $this->setTableRus("Лог неудачных авторизаций",array("ID","Дата/время","Логин Пользователя","IP","Приложение"));
        
        $this->SetAddText("Добавить авторизацию");

        $this->AddFieldType(new ID());
        $this->AddFieldType(new DateTimeField(NowDateTime(),STRONG));
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new Text("",STRONG,40));
    }
    
    function checkAttemptsNum($login)
    {
        $login=DataBase::real_escape_string($login);
        $datetime=NowDateMin(-APP::Config('dlAuth_wrong_attempts_time',10));
        
        $sql="
        SELECT 
            COUNT(`id`) AS 'num' 
        FROM 
            `".$this->_table_name."` 
        WHERE 
            `datetime`>='{$datetime}' 
            AND `login`='{$login}'
            AND `app_name`='".APP::Name()."'";
            
        
            
        $result=DataBase::ExecuteQuery($sql);
        if($result)
        {
            $res=DataBase::fetch_array($result);
            if($res&&$res['num'])
                $num = $res['num'];
            else
                $num = 0;
                
        
                
            if($num>APP::Config('dlAuth_wrong_attempts',5))
                return false;
            else
                return true;
        }
        else
        {return "Ошибка в запросе к базе данных! Возможно неверный формат параметров! Ошибка:".Database::get_error();}

        
        
    }
}

 


class dladmins extends AuthUsersBase
{
    function __construct()
    {
        parent::__construct(array("id","name","email","pass","access_level_id"),"dladmins","id");
        $this->setTableRus(ll("Admins"),array("ID",ll("Name"),ll("Email"),ll("Password"),ll("Access level")));
        
        $this->SetAddText(ll("Add"));

        $this->ListingFields(array(
            "name",
            //"email",
            //"pass",
        ));

        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new Email("",STRONG,40));
        $this->AddFieldType(new Pass("",STRONG,40));
        $access_field = new ComboTable("0",STRONG,"dladmins_access_levels","id","name");
        $access_field->NotInListing();
        $this->AddFieldType($access_field);
    }
    
   
}


class dladmins_log extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id","admin_id","table_name","action_id","data","datetime"),"dladmins_log","id");
        $this->setTableRus("Лог действий администратора",array("ID","ID Админа","Таблица","Действие","Данные","Дата/время"));
        $this->NOTAddable();
        $this->NOTDeletable();
        $this->NOTEditable();
        

        $this->AddFieldType(new ID());
        $this->AddFieldType(new ComboTable("0",STRONG,"dladmins","id","name"));
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new ComboTable("0",STRONG,"dladmins_log_actions","id","name"));
        $this->AddFieldType(new Text("",STRONG,70));
        $this->AddFieldType(new DateTimeField("",STRONG));
    }
    
    
    public static function addToLog($label,$table_name,$data)
    {
        $dladmins_log_actions_gateway=new dladmins_log_actions();
        $action_id=$dladmins_log_actions_gateway->LogEnabled($label);
        if($action_id)
        {
          $data=$data." (IP: ".REQUEST::GetIp().")";
          $dladmins_log_gateway=new dladmins_log();
          $dladmins_log_gateway->Add(array("NULL",AuthUser::getID(),$table_name,$action_id,$data,NowDateTime()));  
        }
    }
}

class dladmins_log_actions extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id","label","name","enable"),"dladmins_log_actions","id");
        $this->setTableRus("Действия администратора",array("ID","Метка (не изменять)","Название","Сохранять в лог"));
        
        $this->SetAddText("Добавить действие");

        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new ComboArray(0,STRONG,APP::Constant("yes_no_array")));
    }
    
    
   
    
    
    public function LogEnabled($label)
    {
        $this->ReturnIterator();
        $result=$this->getWhere("label",$label);
        if($result->hasElems())
        {
            $res=$result->NextElem();
            if($res['enable'])
                return $res['id'];
            else
                return 0; 
        }
        else
            return false;
        
    }
}





class dladmins_access_levels extends Spr
{
    function __construct()
    {
        parent::__construct("dladmins_access_levels","Уровни доступа администратора");
    }
}

class dladmins_access_levels_permissions extends dlModel
{
    function __construct()
    {
        parent::__construct(array("id","discription","table_name","view","edit"),"dladmins_access_levels_permissions","id");
        $this->setTableRus("Доступ к информации",array("ID","Описание","Таблица","Просмотр","Редактирование"));
        
        $this->SetAddText("Добавить разрешение");

        $this->AddFieldType(new ID());
        $this->AddFieldType(new Text("",STRONG,60));
        $this->AddFieldType(new Text("",STRONG,40));
        $this->AddFieldType(new ComboTable("0",STRONG,"dladmins_access_levels","id","name"));
        $this->AddFieldType(new ComboTable("0",STRONG,"dladmins_access_levels","id","name"));
        
    }
    
    
    public static function hasPermission($user_secure_level,$table_name,$action="view")
    {
       
       if($user_secure_level===0)
            return true;
            
       $dladmins_access_levels_permissions=new dladmins_access_levels_permissions();
       $dladmins_access_levels_permissions->ReturnIterator();
       $result=$dladmins_access_levels_permissions->getWhereExt("`table_name`='{$table_name}'",false);
       if(!$result->hasElems())
        return true;
       else
       {
        $res=$result->NextElem();
        if($res[$action]>=$user_secure_level)
            return true;
        else
            return false;
       } 
    }
}



?>