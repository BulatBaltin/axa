<? $formTask->start('task') ?>
<div id='task-box' class="row" style="margin-left: 0;" data-url=''>

    <? $formTask->row('tid')?>
    <div class="update_icon_link mr-3" id="find_task" style="margin: 1.6rem 1rem;">
        <svg class="update_icon">
            <use xlink:href="/images/icons/sprite.svg#update"></use>
        </svg>
    </div>
    <? $formTask->row('task')?>
</div>
<? $formTask->end() ?>
