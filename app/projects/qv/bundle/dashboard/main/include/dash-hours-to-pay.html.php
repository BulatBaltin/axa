<div class="mt-5 mb-3 table_head d-flex">
    <h3 class="mr-3"><? l('Hours to pay') ?></h3>

    <? $hours_form->start() ?>
    <div>
        <? $hours_form->errors() ?>
    </div>

    <div class='d-flex'>
        <?$hours_form->widget('pay_period', ['style'=>'margin-right:1rem;']) ?>
        <?$hours_form->widget('pay_customer')?>
    </div>

    <div hidden>
        <? $hours_form->rest() ?>
    </div>          
    <? $hours_form->end() ?>

</div>

<table id="tb-staff" class="fully_mobile">
    <tr>
        <th class="p-2" width="60%"><?l('Total') ?></th>

        <th class="sort_th">
            <div class="d-flex"><?l('Hours') ?>
            </div>
        </th>
    </tr>

    <tbody id='hours-to-pay-body'>
    <? 
    module_partial('main/include/dash-hours-to-pay-body',
    [
        'company'   => $company,
        'period'    => '3-months',
        'customer_id' => null
    ]) 
    ?>
    </tbody>
</table>
