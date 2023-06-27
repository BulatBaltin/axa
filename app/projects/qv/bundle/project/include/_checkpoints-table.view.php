<table class="table">
    <thead>
    <tr style="background:#eee;">
        <th style='width: 60%;'><?l('Check point name')?>
        <th style='width: 20%;'><?l('Check point %')?>
        <th><?l('Action')?>
    </tr>
    </thead>
    <tbody>
    <? if($points):?>
    <? foreach($points as $point):?>
        <tr>
            <td  style='text-align: left;' ><?= $point['name'] ?></td>
            <td  style='text-align: left;' ><?= $point['point'] ?></td>
            <td>
                <div class="table_label_mobile"><?l('Actions')?></div>
                <a class="del-btn text-danger delete_row_icon do-delete-point" data-id="<?=$point['id']?>" href="<? path('qv.project.delete-point', [
                    'id'=> $proj_id,
                    'pid'=> $point['id']
                    ]) ?>">
                    <svg>
                        <use xlink:href="/images/icons/sprite.svg#bin"></use>
                    </svg>
                </a>
                <span id="name_<?=$point['id']?>" hidden><?=$point['name']?></span>
                <input type="hidden" id="csrf_token<?=$point['id']?>" value="<?csrf_token('delete'.$point['id'])?>">

            </td>
        </tr>
    <? endforeach ?>
    <? else: ?>
        <tr>
            <td colspan="3"><?l('No records found') ?></td>
        </tr>
    <? endif ?>
    </tbody>

</table>
