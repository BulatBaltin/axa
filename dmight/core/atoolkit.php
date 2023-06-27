<?
function includeFromModule( $file ) {
    $file = ROUTER::ModulePath() . $file;
    file_exists($file) and include_once($file);
}
function CheckIfExistsInModule( $file1, $file2 ) {
    $file1 = ROUTER::ModulePath() . $file1;
    if(file_exists($file1)) {
        return $file1;
    } elseif (file_exists($file2)) {
        return $file2;
    }    
    return '';
}
function RunIfExistsInProject( $file1, $file2 ) {
    $file1 = ROUTER::ProjectPath() . $file1;
    if(file_exists($file1)) {
        return $file1;
    } elseif (file_exists($file2)) {
        return $file2;
    }    
    return '';
}
function make_slug( $title ) {
    // get_url();
    $slug = strtolower( $title );
    $slug = str_replace(' ', '-', $slug );
    return $slug;
}
function method($method) {
    // $method post/get
    return "<input type='hidden' name='_method' value='$method'>";
}
function csrf() {
    $token = csrf_token();
    return "<input type='hidden' name='_token' value='$token'>";
}

function csrf_token() {
    if (!isset($_SESSION['token'])) {
        $token = md5(uniqid(rand(), TRUE));
        $_SESSION['token'] = $token;
        $_SESSION['token_time'] = time();
    }
    else
    {
        $token = $_SESSION['token'];
    }
    return $token;
}

function asset( $path ) {
    // return PUBLIC_HTML . $path;
    return '/' . $path;
} 
function TruncateSafe( $text, $len, $postfix = "" ) {
    if(strlen($text) <= $len) return $text;
    return substr( $text, 0, strrpos( substr( $text, 0, $len), ' ' ) ) . $postfix;

}
function makeBreaks($text) {
    $text = preg_replace("/(?:\r\n|\r|\n)/g", '<br>', $text);
}
function random_str(
    int $length = 16,
    string $keyspace = '123456789ABCDEFGHIJKLMNPQRSTUVWXYZ'
): string {
    $pieces = '';
    $max = strlen($keyspace) - 1;
    for ($i = 0; $i < $length; ++$i) {
        $odd = random_int(0, 1);
        $pieces .= $odd ? $keyspace[random_int(0, $max)] : strtolower($keyspace[random_int(0, $max)]);
    }
    return $pieces;
}
// REQUEST::getParam("block1",false,true);
// The same as strip_tags() ? 
// function validate_input($data) {
//     $data = trim($data);
//     $data = stripslashes($data);
//     $data = htmlspecialchars($data);
//     return $data;
// }
// https://htmlweb.ru/php/function/strip_tags.php
// filter_var($var, FILTER_VALIDATE_EMAIL );

function module_partial($file_base,$params=[],$return_output = false)
{
    extract($params);

    $found = false;
    if($return_output){
        ob_start();
    }

    $file_base = ROUTER::ModulePath() . $file_base;   

    if(file_exists($file_base)){
        include($file_base);
        $found = true;
    } else {
        $file = $file_base.".php";
        if(file_exists($file)) {
            include($file);
            $found = true;
        }
        $file = $file_base.".view.php";
        if(file_exists($file)) {
            include($file);
            $found = true;
        }
    }

    if(!$found ) {
        dlLog::Write(date('Y-m-d H:i:s') . " Module partial View/PHP File not found " . $file_base . PHP_EOL);
        dlLog::Write('Current dir ' . __DIR__ . PHP_EOL);
    }
    if($return_output){
        $html = ob_get_contents();
        ob_end_clean();
        return $html; 
    }
}

function module_partial_ext($pattern,$params=[],$return_output = false)
{
    extract($params);

    if($return_output){
        $result = [];
    }
    if(!is_array($pattern)) {
        $pattern = [$pattern];
    }
    $found = false;
    foreach ($pattern as $file_base) {

        if($return_output){
            ob_start();
        }

        $file_base = ROUTER::ModulePath() . $file_base;   
        if(file_exists($file_base)){
            include($file_base);
            $found = true;
        } else {
            if(file_exists($file_base.".php")) {
                include($file_base.".php");
                $found = true;
            }
            if(file_exists($file_base.".view.php")) {
                include($file_base.".view.php");
                $found = true;
            }
        }

        if($return_output){
            $html = ob_get_contents();
            ob_end_clean();
            $result[] = $html; 
        }
    }

    if(!$found ) {
        dlLog::Write(date('Y-m-d H:i:s') . " Module partial View/PHP File not found " . $pattern[0] . PHP_EOL);
        dlLog::Write('Current dir ' . __DIR__ . PHP_EOL);
    }

    if($return_output) 
        if (count($result) == 1)
            return $result[0]; 
        else
            return $result; 
}

function include_partial($file_base,$params=[],$return_output = false)
{
    extract($params);

    $found = false;
    if($return_output){
        ob_start();
    }
    // $file_base = ROUTER::ModulePath() . $file_base;   
    if(file_exists($file_base)){
        include($file_base);
        $found = true;
    } else {
        $file = $file_base.".php";
        if(file_exists($file)) {
            include($file);
            $found = true;
        }
        $file = $file_base.".view.php";
        if(file_exists($file)) {
            include($file);
            $found = true;
        }
    }

    if(!$found ) {
        dlLog::Write(date('Y-m-d H:i:s') . " File partial View/PHP File not found " . $file_base . PHP_EOL);
        dlLog::Write('Current dir ' . __DIR__ . PHP_EOL);
    }
    if($return_output){
        $html = ob_get_contents();
        ob_end_clean();
        return $html; 
    }
}
// The same as include_partial
function include_view($file_base,$params=[],$return_output = false)
{
    extract($params);

    $found = false;
    if($return_output){
        ob_start();
    }
    // $file_base = ROUTER::ModulePath() . $file_base;   
    if(file_exists($file_base)){
        include($file_base);
        $found = true;
    } else {
        $file = $file_base.".php";
        if(file_exists($file)) {
            include($file);
            $found = true;
        }
        $file = $file_base.".view.php";
        if(file_exists($file)) {
            include($file);
            $found = true;
        }
    }
    
    if(!$found ) {
        dlLog::Write(date('Y-m-d H:i:s') . "File View/PHP not found " . $file_base . PHP_EOL);
        dlLog::Write('Current dir ' . __DIR__ . PHP_EOL);
    }
    if($return_output){
        $html = ob_get_contents();
        ob_end_clean();
        return $html; 
    }
}
function nl2p($string)
{
    $paragraphs = '';
    $lines = explode(PHP_EOL, $string);
    foreach ($lines as $line) {
        if (trim($line)) {
            $paragraphs .= '<p>' . $line . '</p>';
        }
    }
    return $paragraphs;
}

function Json_Response($contents) {
    $contents = \json_encode($contents);
    echo $contents;
    exit;
}
function get_class_short($obj) {
    // $short = (new \ReflectionClass($obj))->getShortName();
    $shorty = explode('\\', get_class($obj));
    $short  = end($shorty);
    return strtolower($short);
}

function CopyData(&$target, $source) {
    foreach ($target as $key => $value) {
        if(isset($source[$key])) {
            $target[$key] = $source[$key];
        }
    }
}
function CopyMerge(&$target, &$source) {
    foreach ($source as $key => $value) {
        $target[$key] = $value;
    }
}
function getDocumentRoot($last_slash=true)
{
    $last_slash_str = $last_slash ? '/' : '';
    if($_SERVER['DOCUMENT_ROOT'])
        return $_SERVER['DOCUMENT_ROOT'] . $last_slash_str;
    else
        return dirname(dirname(dirname(__FILE__))) . $last_slash_str;        
}

function print_line_dump( $content, $space, $eol ) {
    // echo '<br>', str_repeat('. ', $space). $content;
    echo $eol, str_repeat('. ', $space). $content;
}
function print_array(&$vars, &$space, $tag = false, $eol = '<br>') {
    $step = 3;
    $old_space = $space;
    $text = ($tag ? $tag . '=>' : '').'(array) size('.count( $vars).') [';
    print_line_dump($text, $space, $eol);

    $space += $step;
    foreach ($vars as $key => $v) {
        if(is_array($v)) {
            print_array($v, $space, $key, $eol);

        } elseif(is_object($v)) {
            echo $eol, str_repeat('. ', $space), $tag ? $tag .'=>': '';
            var_export($v);

        } else {
            $text =  $key . ' => ' . $v;
            print_line_dump($text, $space, $eol);
        }
    }
    print_line_dump(']', $old_space, $eol);

    $space = $old_space;
    return;
}
function dump(...$vars)
{
    $space = 0;
    $eol = "<br>";
    foreach ($vars as $val) {
        if(is_array($val)) {
            print_array($val, $space);
        } elseif(is_object($val)) { 
            echo $eol;
            var_export($val);
        } else 
            echo $eol, $val ;
    }
}
function dump_ret(...$vars)
{
    ob_start();
    $space  = 0;
    $eol    = PHP_EOL;
    foreach ($vars as $val) {
        if(is_array($val)) {
            print_array($val, $space, false, $eol);
        } elseif(is_object($val)) { 
            echo $eol; //'<br>';
            // var_export($val);
            var_dump($val);
        } else 
            echo $eol, $val ;
    }
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

function dd(...$vars)
{
    dump(...$vars);
    exit(1);
}

// function esc_single_double_quote($value) {
//     if(strpos($value, "'")) $value = str_replace("'", "\'", $value);
//     if(strpos($value, '"')) $value = str_replace('"', '\"', $value);
//     return $value;
// }
function roundEx($value, $precision, $mode = PHP_ROUND_HALF_UP ) {
    if(is_numeric($value)) return round($value, $precision, $mode);
    return 0;
}
function str_has($haystack, $needle) {
    if(!is_string($haystack) and !is_string($needle)) return false;
    return stripos($haystack, $needle) !== false;
}

function containExt($haystack, $needle) {
    if(is_array($needle)) {
        foreach ($needle as $value) {
            if(str_has($haystack, $value)) return true;
        }
    } else {
        return str_has($haystack, $needle);
    }
    return false;
}
function str_starts($hayStack, $pattern) {
    return strtolower(substr($hayStack, 0, strlen($pattern))) == strtolower($pattern);
}

class dlLog
{
  //public static $_filepath = ""; 
  public static $_eos = "\r\n";
  public static $_file = null;

  public static function WriteDump(...$vars) {
      self::Write(dump_ret(...$vars));
  }
  public static function Write($str, $openclose = true)
  {
    if ($openclose) {
      dlLog::BeginWrite();
    }
    fputs(dlLog::$_file, $str . dlLog::$_eos);
    if ($openclose) {
      dlLog::EndWrite();
    }
  }

  public static function BeginWrite()
  {
    dlLog::$_file = fopen(ROOT . "logs/log.txt", "a");
    if (!dlLog::$_file) {
      echo ("Error opening file log.txt");
    }
  }

  public static function EndWrite()
  {
    fclose(dlLog::$_file);
  }
  public static function Read()
  {
    $file_txt = ROOT . "logs/log.txt";

    if (file_exists($file_txt)) {
      return file_get_contents($file_txt);
    } else {
      return "No such file: " . $file_txt;
    }
  }
  public static function Clear()
  {
    dlLog::BeginWrite();
    ftruncate(dlLog::$_file, 0);
    dlLog::EndWrite();
  }
}

class Messager
{
    static function renderMssg($text, $color, $border, $background, $lingo = null, $style ="")
    {
        if($lingo) {
            $text = ll($text);
        }
        return "<div style='color:{$color}; padding:0.5rem 1rem; background:{$background}; border-left: 6px solid {$border};{$style};'>{$text}</div>";
    }
    static function renderError($text, $lingo = null, $style='')
    {
        return self::renderMssg($text, "red", "red", "var(--redLight)", $lingo, $style);
    }
    static function renderSuccess($text = "Data successfully updated", $lingo = null, $style  = '')
    {
        if(empty($text)) $text = "Data successfully updated"; 
        return self::renderMssg($text, 'green', "lightgreen", "var(--greenLight)", $lingo, $style);
    }
    static function log(string $mssg, $time = null) {

        // dd($_SERVER);
        // $file = dirname($_SERVER['DOCUMENT_ROOT']) . '/var/log/php_log.txt';
        $file = ROOT . 'logs/php_log.txt';
        // dd($file);
        // $file = './var/log/php_log.txt';
        if($time) {
            file_put_contents($file, (new DateTime())->format('c'). " ".$mssg.PHP_EOL, FILE_APPEND);
        } else {
            file_put_contents($file, $mssg.PHP_EOL, FILE_APPEND);
        }
    }
    static function AddTraceInfo(Exception $e, string $exclude, $break = '<br>') {
        $trace = $e->getTrace();
        $mssg = '';
        foreach ($trace as $step) {
            if(strpos($step['file'], $exclude) === false) {
                $mssg .= $break.'File: '.$step['file'].'; Line:'.$step['line'].'; Function: '.$step['function'];
            }
        }
        return "<br> Count(trace)=(". count($trace) .')<br>'. $mssg;

    }
}

function dymp(...$vars) {
  dlLog::WriteDump(...$vars);
}

