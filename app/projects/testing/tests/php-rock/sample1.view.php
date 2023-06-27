<div>
Non-static call<br>
</div>
<?
$x = new Foo();
[$x, "non" . "StaticCall"](); // Non-static call
?>
<div>
Static call<br>
</div>
<?
['Foo', "static" . "Call"](); // Static call
?>
<div>
Step-2<br>
</div>
<?
$get = 'GetName';
echo $x->{$get}(); // Static call

$post = 'GetAny';
// $class = 'Foo';
echo (get_class($x))::{$post}('<br>Hallo there'); // Static call
echo get_class($x)::{$post}('<br>Hallo there-2'); // Static call
echo [get_class($x), $post]('<br>Hallo there again'); // Static call
?>
