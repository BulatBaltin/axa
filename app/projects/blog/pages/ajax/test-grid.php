<?
$table_name = REQUEST::getParam('table_name');
$data = REQUEST::getParam('data');
$time = (new DateTime())->format('c');
?>

<table>
    <tr>
    <th>Col 1</th>
    <th>Col 2</th>
    </tr>
    <tr>
    <td><?= $data ?></th>
    <td><?= $table_name . $time ?></th>
    </tr>
</table>

<? exit(); ?>