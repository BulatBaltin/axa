<table class="table">
    <thead>
    <tr style="background:#eee;">
        <th style='width: 80%;'><?l('Tasks')?>  (<?= count($tasks) ?>)
        <th><?l('Action')?>
    </tr>
    </thead>
    <tbody>
    <? if($tasks): ?>
    <? foreach($tasks  as $task): ?>
        <tr>
            <td  style='text-align: left;' ><?=$task['task']?></td>
            <td>

                <div class="table_label_mobile"><?l('Actions')?></div>
                <a title="<?l('Edit task')?>" target="_blank" href="<? path('qv.tasks.update', ['id'=> $task['id']]) ?>" class="edit_row_icon">
                    <svg>
                        <use xlink:href="/images/icons/sprite.svg#edit"></use>
                    </svg>
                </a>
                <a class="del-btn text-danger delete_row_icon do-delete-task" data-tid="<?=$task['tid']?>" data-projecten_id="<?=$project['id']?>" href="#">
                    <svg>
                        <use xlink:href="/images/icons/sprite.svg#bin"></use>
                    </svg>
                </a>
                <span id="name_<?=$task['tid']?>" hidden><?=$task['task']?></span>
                <input type="hidden" id="csrf_token_<?=$task['tid']?>" value="<?csrf_token('delete'.$task['tid'])?>">

            </td>
        </tr>
    <? endforeach ?>
    <? else: ?>
        <tr>
            <td colspan="2"><?l('No records found')?></td>
        </tr>
    <? endif ?>
    </tbody>

</table>
