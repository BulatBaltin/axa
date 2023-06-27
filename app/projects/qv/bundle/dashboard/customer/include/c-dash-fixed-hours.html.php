<div class="mt-5 mb-3 table_head">
    <h3 class="mr-3"><?l('Fixed hour agreements')?></h3>
</div>
    <? $fx_form->start() ?>
    <div>
        <? $fx_form->errors() ?>
    </div>

    <div class='d-flex'>
        <?$fx_form->widget('fixedhours')?>
        <span class='ml-5' style='margin: auto'>
            <? l('All fixed hours') ?>&nbsp;&nbsp;<b>
            <?=$fixedtotal ?>
        </b> 
        </span>          
    </div>

    <div hidden>
        <? $fx_form->rest() ?>
    </div>          
    <? $fx_form->end() ?>

<table id="tb-staff" class="mt-1 fully_mobile">
    <tr>
        <th class="p-2" width="40%"><?l('Task/Project description')?></th>
        <th class="p-2" width="15%"><?l('Start date')?></th>
        <th class="p-2" width="15%"><?l('Due date')?></th>
        <th class="p-2" width="15%"><strong><?l('Fixed hours')?></strong></th>
        <th class="p-2" width="15%"><strong><?l('Completed')?></strong></th>
    </tr>
    <tbody id='fx-hours-body'>
<? include(ROUTER::ModulePath().'customer/include/c-fx-hours-body.html.php') ?>
    </tbody>
</table>
