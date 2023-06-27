<?php

class OneCharValidator extends dlValidator
{
    function __construct(){
        $this->_validation_error=ll("This field should contain 1 symbol");
    }
    public function Validate($value)
    {
        if(strlen($value)==1){
            return true;
        }
        return false;
    }
}

abstract class dlValidator
{
    protected $_validation_error;
    public abstract function Validate($value);
    public function getValidationError()
    {
        return $this->_validation_error;
    }    
}

class NumValidator extends dlValidator 
{
    function __construct()
    {
        $this->_validation_error="Поле должно содержать целое число";
    }
    public function Validate($value)
    {
        return DataHelper::IsNum($value);
    }    
}

class EmailValidator extends dlValidator 
{
    function __construct()
    {
        $this->_validation_error="Введите корректный email";
    }
    public function Validate($value)
    {
        return DataHelper::checkEmail($value);
    }    
}

class RequiredValidator extends dlValidator 
{
    function __construct()
    {
        $this->_validation_error="Поле должно быть заполнено";
    }
    
    public function Validate($value)
    {
        if($value!=="")
            return true;
        else
            return false;
    }    

}
?>