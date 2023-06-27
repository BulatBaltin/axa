
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

class ErrorHandler {
// https://edmondscommerce.github.io/php/php-custom-error-and-exception-handler-make-php-stricter.html

    function set($severity, $message, $filename, $lineno, $errcontext) {

        if (error_reporting() == 0) {
            return;
        }
        
        throw new ErrorException($message, 0, $severity, $filename, $lineno);

    }
    // set_exception_handler('ec_exceptions_handler');
    function show(Exception $e) {
        $statusCode = $e->getCode();
        $message = $e->getMessage();
        $trace = $e->getTrace();

        // $user = User::getUser();
        $params['user_hash'] = ''; //$user['hash'];
        $params = [
            'statusCode' => $e->getCode(),
            'message' => $e->getMessage(),
            'trace' => $e->getTrace()
        ];

        include_once(DMIGHT . 'template/ErrorHandler.html.php');

        exit(1);
    }
}

class iDealErrorHandler {

// protected function initSystemHandlers()
function __construct()
{
    set_exception_handler(array($this, 'handleException'));
    set_error_handler(array($this, 'handleError'), error_reporting());
}
public function handleError($code, $message, $file, $line)
{
    if ($code & error_reporting()) {
        restore_error_handler();
        restore_exception_handler();
        try {
            $this->displayError($code, $message, $file, $line);
        } catch (Exception $e) {
            $this->displayException($e);
        }
    }
}
public function handleException($exception)
{
    restore_error_handler();
    restore_exception_handler();
    $this->displayException($exception);
}

public function displayError($code, $message, $file, $line) {

    $trace = debug_backtrace();

    if (count($trace) > 6)
        $trace = array_slice($trace, 6);
    
    if (count($trace) > 1)
        array_shift($trace); 

    // $user = User::getUser();
    $user_hash = ''; //$user['hash'] ?? '';

    include_once(DMIGHT . 'template/ErrorHandler.html.php');
    exit();
}

public function displayException($exception)
{
    $code   = $exception->getCode();
    $trace  = $exception->getTrace();
    $file   = $exception->getFile();
    $line   = $exception->getLine();

    $message = $exception->GetMessage();

    // $user = User::getUser();
    $user_hash = ''; //$user['hash'];

    include_once(DMIGHT . 'template/ErrorHandler.html.php');
    exit();

    // echo '<h1>' . get_class($exception) . "</h1>\n";
    // echo '<p>' . $exception->getMessage() . ' (' . $exception->getFile() . ':' . $exception->getLine() . ')</p>';
    // echo '<pre>' . $exception->getTraceAsString() . '</pre>';
}

}

