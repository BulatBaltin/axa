<div class="row" style="margin-top:2rem;">
    <div class="col-md-12">
        <div class="mb-3 table_head">
            <h3 class="mr-3"><?l('Hour registration')?></h3>
        </div>

        <? $period_form->start() ?>

        <div class='d-flex mb-1'>
            <?$period_form->widget('period')?>
            <div style='margin: auto 20px; font-weight: 600;'>
            <span id='show-period'><?=$say_period ?></span>
            </div>
        </div>

        <? $period_form->end() ?>

        <div id="tb-box">
            <table id="tb-staff" class="fully_mobile">
                <tr>
                    <th class="sort_th" width='30%'>
                    <?l('Hours')?>
                    </th>
                    <th class="sort_th">
                    <?l('Task')?>
                    </th>
                </tr>
                <tbody id='period-body'>
                    <? include('c-period-body.view.php') ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
