<table id="tb-staff" class="fully_mobile">
    <tr>
        <th rowspan="2" id="pie-cap-1" class="p-2" width="40%">
<?l('Employee')?></th>

        <th colspan="6" class="sort_th">
            <div class="d-flex">
<?l('Worked hours') ?>
            </div>
        </th>
    </tr>
    <tr>
        <th class="sort-th">
<?l('Total') ?>
        </th>
        <th class="th-small">
            
            <? if(isset($totalday)) : ?>
            <strong><?l('This day') ?><br><?=$periods['this_day'] ?></strong>
            <? else: ?>
            <? l('This day') ?><br><?=$periods['this_day'] ?>
            <? endif ?>
            
        </th>
        <th class="th-small">
            <div class="d-flex">
            <? if (isset($totalweek)):?>
            <strong><?l('This week') ?><br><?=$periods['this_week'] ?></strong>
            <? else :?>
            <? l('This week') ?><br><?=$periods['this_week'] ?>
            <? endif ?>
            </div>
        </th>
        <th class="th-small">
            <div class="d-flex">
            <? if (isset($totalmonth)): ?>
            <strong><? l('This month') ?><br><?=$periods['this_month'] ?></strong>
            <? else :?>
            <? l('This month') ?><br><?=$periods['this_month'] ?>
            <? endif ?>
            </div>
        </th>
        <th class="th-small">
            <div class="d-flex">
            <? if(isset($totalmonthlast)):?>
            <strong><? l('Last month') ?><br><?=$periods['last_month']?></strong>
            <? else :?>
            <? l('Last month') ?><br><?=$periods['last_month']?>
            <? endif ?>
            </div>
        </th>
        <th class='th-small'>
            <? l('The month before last')?><br><?=$periods['last2_month'] ?>
        </th>
    </tr>

    <tbody>
    <? $inx = 0; ?>
    <? foreach($employees as $person): ?>
        <? if ($inx == 0): ?>
        <tr style="background:lightgrey; font-size:1rem;">
            <td>
                <strong><? l('Total') ?></strong>
            </td>
            <td>
                <strong><?=$person['total'] ?></strong>
            </td>
            <td>
                <?=$person['sum_TD'] ?> 
            </td>
            <td>
                <?=$person['sum_TW'] ?>
            </td>
            <td>
                <?=$person['sum_TM'] ?>
            </td>
            <td>
                <?=$person['sum_LM'] ?>
            </td>
            <td>
                <?=$person['sum_LM2'] ?>
            </td>
        <? else: ?>
        <tr>
            <td>
                <? if($person['hash']): ?>
                    <a title='<?l("Developer's profile page")?>' class="row-href" 
href="<? path('qv.dash-dev.site', ['id' => $person['hash']]) ?>">
                        <?=$person['person'] ?>
                    </a>
                <? else :?>
                    <?=$person['person'] ?>
                <? endif ?>
            </td>
            <td>
                <?=$person['total'] ?>
            </td>
            <td>
                <?=$person['sum_TD'] ?> 
            </td>
            <td>
                <?=$person['sum_TW'] ?>
            </td>
            <td>
                <?=$person['sum_TM'] ?>
            </td>
            <td>
                <?=$person['sum_LM']?>
            </td>
            <td>
                <?=$person['sum_LM2'] ?>
            </td>
        </tr>
        <? endif ?>
    <? $inx = 1; ?>
    <? endforeach ?>
    </tbody>
</table>
