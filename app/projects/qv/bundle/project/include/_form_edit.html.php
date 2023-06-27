<? $form->start() ?>

<div class="row">
    <div class="col-md-4 mb-4">
        <? $form->row('name') ?>
        <? $form->row('description') ?>
    </div>
    <div class="col-md-4 mb-4">
    <div class="select_no_search">
        <? $form->row('customer') ?>
    </div>
        <? $form->row('budget') ?>
    </div>
    <div class="col-md-4 mb-4">
<a class="text-danger delete_row_icon" data-id="<?= $projecten['id'] ?>" 
href="#"
data-token="<?= csrf_token('delete'.$projecten['id']) ?>"
data-projecten-name="<?= $projecten['name'] ?>"
>
<svg>
<use xlink:href="/images/icons/sprite.svg#bin"></use>
</svg>
</a>

    </div>
</div>
    <button class="btn"><?= $button_label ?? ll('Save'); ?></button>
<? $form->end() ?>

<hr>
<div>
<h2><? l('Project tasks') ?></h2>

    <div id='_tasks-table'>
        <? module_partial('include/_tasks-table', [
            'project' => $projecten
        ])?>
    </div>
</div>
<div id='add-row' data-proj='<?= $projecten['id'] ?>' class="row" style="margin-left: 0;">
    <div id='add-task-to-grid'>
        <? include('_form_add_task.html.php')?>
    </div>
    <div>
        <button id='do-add-task'class="btn" style='height: var(--editHeight);margin: 1.6rem 2rem'><? l('Add task')?></button>
    </div>
</div>

<hr>
<div>
<h2><? l('Project checkpoints') ?></h2>
    <div id='_points-table'>
        <? 
        module_partial('include/_checkpoints-table', [
            'project' => $projecten
        ]);        
        ?>
    </div>
</div>
<div id='add-row-point' data-proj='<?= $projecten['id'] ?>' class="row" style="margin-left: 0;">
    <div id='add-point-to-grid'>
        <? include('_form_add_point.html.php')?>
    </div>
    <button id='do-add-point'class="btn" style='height: var(--editHeight);margin: 1.3rem 2rem'><? l('Add point')?></button>
</div>

