<? $formPoint->start('points') ?>
<div id='task-box' class="row" style="margin-left: 0;" data-url=''>

    <div>
        <label for="points_name_id" style="width: 300px;"><?l('Point name')?>
        <? $formPoint->widget('name')?>
        </label>
    </div>
    <div style="margin-left: 1rem;">
        <label for="points_point_id"><?l('Point %')?>
        <? $formPoint->widget('point')?>
        </label>
    </div>
</div>
<? $formPoint->end() ?>
