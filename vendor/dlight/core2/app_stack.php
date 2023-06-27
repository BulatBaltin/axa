<?
function includeFromModule( $file ) {
    $file = BUNDLE . ROUTER::ModuleName() . "/" . $file;
    file_exists($file) and include_once($file);
}
function make_slug( $title ) {
    // get_url();
    $slug = strtolower( $title );
    $slug = str_replace(' ', '-', $slug );
    return $slug;
}
function route( $slug, $params = [] ) {
    // get_url();
    return ROUTER::get_url($slug,$params);  ;
}
function path( $slug, $params = [] ) {
    // get_url();
    echo ROUTER::get_url($slug,$params);  ;
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
function StartForm( $route = '', $method = 'POST', $upload = false) {
    if(empty($rout)) {
        $route = $_SERVER["PHP_SELF"];
    }
    if($upload) {
        $method = 'POST';
        $upload = ' enctype="multipart/form-data"';
    } else {
        $upload = '';
    }
    echo '<form method="' . $method . '" action="' . htmlspecialchars($route) .'"'. $upload .'>';
}
function EndForm() {
    echo '</form>';
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