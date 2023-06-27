<? if (count($fixedtasks) > 0): ?>
<? foreach($fixedtasks as $task) :?>
    <tr>
        <td>
        <a class='row-href' 
href="<? path('qv.tasks.update', ['id' => $task['id'] ])?>">
            <?=$task['task']?>
        </a>
        </td>
        <td>
            <?=$task['start']?>
        </td>
        <td>
            <?=$task['due']?>
        </td>
        <td>
            <?=$task['hours']?>
        </td>
        <td>
        <? if($task['completed']): ?>
            <?l('YES')?>
        <? else: ?>
            <?l('No')?>
        <? endif ?>
        </td>
    </tr>
<? endforeach ?>
<? else :?>
    <tr>
        <td colspan='5'>
            <? l('No estimated hours agreement for the filter') ?>
        </td>
    </tr>
<? endif ?>
