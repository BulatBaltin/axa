<?php
  
class AuthUser
{
    public static $_session = array(); 
    public static function getDefObject()
    {
        return APP::Name();
    } 
    public static function isAuthorized($object_id=false, $object=false){
        if($object===false)
            $object=AuthUser::getDefObject();
            
            //var_dump( AuthUser::$_session[$object]);
        if($object_id===false)
        {
            if(isset(AuthUser::$_session[$object]))
                return true;
            else
                return false;
        }
        else
        {
            if(isset(AuthUser::$_session[$object]['id'])&&AuthUser::$_session[$object]['id']==$object_id)
                return true;
            else
                return false;
        }
    }
    
    public static function setParams($params,$object=false)
    {
        if($object===false){
            $object=AuthUser::getDefObject();
        }
        AuthUser::$_session[$object]=$params;
    }
    
    public static function setParam($param_name,$param,$object=false)
    {
        if($object===false)
            $object=AuthUser::getDefObject();
        
        AuthUser::$_session[$object][$param_name]=$param;
    }
    
    public static function setParamsStd($id,$login,$name,$access_level_id,$object=false)
    {
        if($object===false)
            $object=AuthUser::getDefObject();
            
        AuthUser::$_session[$object]=array("id"=>$id,"login"=>$login,"name"=>$name,"access_level_id"=>$access_level_id);
    }
    
    public static function getParam($param_name,$object=false)
    {   
        if($object===false)
            $object=AuthUser::getDefObject();
            
        return AuthUser::$_session[$object][$param_name];
    }
    
    public static function unsetParams($object=false)
    {
        if($object===false)
            $object=AuthUser::getDefObject();
            
        unset(AuthUser::$_session[$object]);
        
    }
    
    
    public static function getID($object=false)
    {
        if($object===false)
            $object=AuthUser::getDefObject();
            
        return AuthUser::$_session[$object]['id'];
    }

    public static function getLogin($object=false)
    {
        if($object===false)
            $object=AuthUser::getDefObject();
            
        return AuthUser::$_session[$object]['login'];
    }

    public static function getName($object=false)
    {
        if($object===false)
            $object=AuthUser::getDefObject();
            
        return AuthUser::$_session[$object]['name'];
    }
    
    public static function secureLevel($object=false)
    {
        if($object===false)
            $object=AuthUser::getDefObject();
        if(isset(AuthUser::$_session[$object]['access_level_id']))    
            return AuthUser::$_session[$object]['access_level_id'];
        else
            return null;
    }
    
    public static function isSuper($object=false)
    {
        if($object===false)
            $object=AuthUser::getDefObject();
            
        //var_dump($_SESSION);
            
        if(isset(AuthUser::$_session[$object]['access_level_id'])&&AuthUser::$_session[$object]['access_level_id']==3)
            return true;
        else
            return false;
    }
    
   
    
   
    

      
}

?>