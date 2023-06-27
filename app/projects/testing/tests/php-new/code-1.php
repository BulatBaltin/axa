<?
function byVal($arg) {
    echo 'Передан          : ', var_export(func_get_arg(0)), "<br>";
    $arg = 'baz';
    echo 'После изменения  : ', var_export(func_get_arg(0)), "<br>";
}

function byRef(&$arg) {
    echo 'Передан          : ', var_export(func_get_arg(0)), "<br>";
    $arg = 'baz';
    echo 'После изменения  : ', var_export(func_get_arg(0)), "<br>";
}
function test( $test ){
    $test = '123';
    echo func_get_arg(0), "<br>";
}
// =============================
function f3dot($req, $opt = null, ...$params) {
    // $params - массив, содержащий все остальные аргументы.
    printf('$req: %d; $opt: %d; количество параметров: %d'."\n",
           $req, $opt, count($params));
    var_export($params);
    echo "<br>";           
}

interface Rendable {
    function Draw ();
    function Clear();
    function DrawStyle();
    function SetContents(string $contents);
    function GetContents();
    function DrawClass();
}
class DrawDiv implements Rendable {
    private $contents;
    function Draw () {
        return "<div class='" . $this->DrawClass() . "' style='".$this->DrawStyle()."'>" .$this->GetContents() . "</div>"; 
    }
    function Clear() {}
    function DrawStyle() {}
    function GetContents() {
        return $this->contents;
    }
    function SetContents(string $contents) {
        $this->contents = $contents;
    }
    function DrawClass() {}

}

// $arg = 'bar';
// byVal($arg);
// byRef($arg);

$obj = (new Factory())->Create('Wanna', 'Add new line');
$obj->Print('ObJ: Hi there!!!');
die;
?>