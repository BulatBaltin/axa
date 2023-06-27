<div class="row" style="margin-top:2rem;margin-bottom:3rem;">
    <div class="col-md-12">
        <div class="mb-3 table_head">
            <h3 class="mr-3"><?l('Hour validation')?></h3>
        </div>

        <? $bal_period_form->start('bal_period') ?>

        <div class='d-flex mb-1'>
            <?$bal_period_form->widget('bal_period',['id' => 'id_bal_period'])?>
            <div style='margin: auto 20px;padding-bottom:1rem; font-weight: 600;'>
            <span id='show-period'><?= $say_period ?></span>
            </div>
        </div>

        <? $bal_period_form->end() ?>

        <div id="tb-box-dis">
            <table id="tb-staff" class="fully_mobile">
                <tr>
                    <th class="sort_th" width='10%'>
                    1. <? l('Time tracking hours') ?>
                    </th>
                    <th class="sort_th" width='10%'>
                    2. <? l('Invoiceable initial hours') ?>
                    </th>
                    <th class="sort_th" width='10%' style="background: #eee;">
                    <? l('Disbalance') ?><br>(1. - 2.)
                    </th>
                    <th class="sort_th" width='10%'>
                    3. <? l('Invoiceable hours') ?>
                    </th>
                    <th class="sort_th" width='10%' style="background: #eee;">
                    <? l('Disbalance') ?><br>(1. - 3.)
                    </th>
                    <th class="sort_th" width='10%'>
                    4. <? l('Submitted hours') ?>
                    </th>
                    <th class="sort_th">
                    <? l('Task') ?>
                    </th>
                    <th class="sort_th">
                    <? l('Customer') ?>
                    </th>
                </tr>
                <tbody id='period-body'>
                    <? include('dash-disbalance-body.html.php') ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
