<?
// try {

$block1 = REQUEST::getParam("block1",false,true);
if($block1 === false) {
    echo 'Wrong parameter';
    exit;
}
$block2 = REQUEST::getParam("block2",false,true);
if($block2 === false) {
    echo 'Wrong parameter';
    exit;
}
$block1 = intval($block1);
$block2 = intval($block2);

list($result, $text, $color) = survey::define_result($block1, $block2);
$record = survey::calc_result($result);

// } catch(Exception $e) {
//     echo $e->getMessage();
//     exit();
// }
?>

<div style="border: 1px solid lightgrey;padding: 1rem; text-align:center;">
<h2 style="color:<?= $color ?>; "><?= $text?></h2>
<p>
Пройшли тест: <?= $record['total']?>
</p>
<p>
Високий рівень: <?= $record['high']?>%
</p>
<p>
Середній рівень: <?= $record['middle']?>%
</p>
<p>
Низький рівень: <?= $record['low']?>%
</p>
</div>

<? exit() ?>