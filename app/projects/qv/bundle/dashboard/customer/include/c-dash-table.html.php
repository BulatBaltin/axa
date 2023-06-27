<table id="tb-staff" class="fully_mobile">
    <tr>
        <th rowspan="2" id="pie-cap-1" class="p-2" width="40%"><?l('Project (task)') ?></th>

        {# <th colspan="6" class="sort_th"> #}
        <th colspan="5" class="sort_th">
            <div class="d-flex"><?l('Worked hours') ?>
            </div>
        </th>
    </tr>
    <tr>
        <th id="pie-cap-2" class="sort_th">
            <div class="d-flex"><a class="total-row" id="total-all" href="javascript:void(0)"><?l('Total') ?></a>
                <div id="i-sort" class='mr-2 round-spot-sort ml-1'>
                    <svg class="arrow_down mt-2">
                        <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                    </svg>
                </div>
            </div>
        </th>
        <th class="sort_th">
            
            <? if( isset($totalday)): ?>
            <strong><?l('This day') ?><br><?=$periods['this_day'] ?></strong>
            <? else :?>
            <a class="total-row" id="total-day" href="javascript:void(0)"><? l('This day') ?><br><?=$periods['this_day'] ?></a>
            <? endif ?>
            
        </th>
        <th class="sort_th">
            <div class="d-flex">
            <? if( isset($totalweek)): ?>
            <strong><?l('This week') ?><br><?=$periods['this_week'] ?></strong>
            <? else :?>
            <a class="total-row" id="total-week" href="javascript:void(0)"><? l('This week') ?><br><?=$periods['this_week'] ?></a>
            <? endif ?>
            </div>
        </th>
        <th class="sort_th">
            <div class="d-flex">
            <? if(isset($totalmonth)): ?>
            <strong><?l('This month') ?><br><?=$periods['this_month'] ?></strong>
            <? else : ?>
            <a class="total-row" id="total-month" href="javascript:void(0)"><?l('This month') ?><br><?=$periods['this_month'] ?></a>
            <? endif ?>
            </div>
        </th>
        <th class="sort_th">
            <div class="d-flex">
            <? if (isset($totalmonthlast)): ?>
            <strong><?l('Last month') ?><br><?=$periods['last_month'] ?></strong>
            <? else :?>
            <a class="total-row" id="total-month-last" href="javascript:void(0)"><? l('Last month') ?><br><?=$periods['last_month']?></a>
            <? endif ?>
            </div>
        </th>
        <th hidden class="sort_th">
            <div class="d-flex">
            <? l('The rest of time') ?>
            </div>
        </th>
    </tr>

    <tbody>
    <? $inx = 0 ?>
    <? foreach($projects as $project): ?>
        <? if ($inx == 0) : ?>
        <tr style="background:lightgrey; font-size:1rem;">
            <td>
                <strong><? l('Total') ?></strong>
            </td>
            <td>
                <strong><?=$project['total'] ?></strong>
            </td>
            <td>
                <?=$project['sum_TD'] ?> 
            </td>
            <td>
                <?=$project['sum_TW'] ?>
            </td>
            <td>
                <?=$project['sum_TM'] ?>
            </td>
            <td>
                <?=$project['sum_LM'] ?>
            </td>
            <td hidden>
                <?=$project['sum_Rest'] ?>
            </td>
        <? else :?>
        <tr>
            <td>
                <?=$project['task']?>
            </td>
            <td>
                <?=$project['total'] ?>
            </td>
            <td>
                <?=$project['sum_TD'] ?> 
            </td>
            <td>
                <?=$project['sum_TW'] ?>
            </td>
            <td>
                <?=$project['sum_TM'] ?>
            </td>
            <td>
                <?=$project['sum_LM'] ?>
            </td>
            <td hidden>
                <?=$project['sum_Rest'] ?>
            </td>
        </tr>
        <? endif ?>
    <? $inx = 1 ?>
    <? endforeach ?>
    </tbody>
</table>
