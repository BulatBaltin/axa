<?php
  
class dlError
{
    public static $_errors;
    public static $_errors_classes = array();
    
    public static function getErrorClass($label, $code)
    {
         if(dlError::isErrorCode($code)){
             return dlError::$_errors_classes[$label][0]; 
         }
         else{
             return dlError::$_errors_classes[$label][1];
         }
        
    }
    
    public static function addErrorClass($label,$classes)
    {
       dlError::$_errors_classes[$label]=$classes;
    }
    
    public static function addError($error_text,$code=false)
    {
       dlError::$_errors[]=array("text"=>$error_text,"code"=>$code);
    }
    public static function clearErrors()
    {
       dlError::$_errors=null;
    }
    public static function hasErrors()
    {
        if(!dlError::$_errors){
            return null;
        }
       return count(dlError::$_errors);
    }
    public static function getErrors()
    {
       return dlError::$_errors;
    }
    public static function getErrorsHtml($separator="<br>")
    {
        $error_str="";
        if(is_array(dlError::$_errors) and count(dlError::$_errors)){
        foreach(dlError::$_errors as $error)
            $error_str.=$error['text'].$separator;
        }
        return $error_str;
    }
    public static function isErrorCode($code)
    {
        if(dlError::hasErrors()){
            foreach(dlError::$_errors as $error){
                if($error['code']==$code){
                    return true;
                }
            }
        }
        return false;
    }
}

?>