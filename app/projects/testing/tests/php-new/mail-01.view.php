<style>
    .box-1 {
        margin: 1rem;
    }
    .box {
        margin: 2rem;
    }
    .li-box {
        padding-bottom: 0.5rem;
    }
    td, th {
        border: 1px solid lightgrey;
        padding: 0.5rem 2rem;
        text-align: left;
    }
    p {
        margin: 1rem auto;
    }
</style>

<div class="box">
<h4><?= $consts['HALLO'] . ' ' . $vars['HALLO']['user_name']?></h4>
    <?= nl2p($consts['TEXT'])?>
</div>

<div class="box">
<div style="border: 1px solid lightgrey;text-align: left;background-color: #eee;padding: 1rem; font-size: 1.2rem;"><?= strtoupper($consts['TRIP'] . ' ' . $vars['TRIP']['trip'])?></div>
    <table style="border-collapse: collapse;">
        <tbody>

<tr><td width="25%"><b><?= $consts['ORDER']?></b></td><td><?=$vars['ORDER']['order_id']?></td></tr>
<tr><td><b><?= $consts['DATE']?></b></td><td><?=$vars['DATE']['date']?></td></tr>
<tr><td><b><?= $consts['TIME']?></b></td><td><?=$vars['TIME']['time']?></td></tr>
<tr><td colspan="2" style="text-align: left;background-color: #eee;padding: 1rem; font-size: 1.2rem;"><?= $consts['TOTAL']?> € <b><?=$vars['TOTAL']['total']?></b></td></tr>
<tr><td><b><?= $consts['TICKETS']?></b></td><td>€ <?=$vars['TICKETS']['tickets']?></td></tr>
<tr><td><b><?= $consts['DISCOUNT']?></b></td><td>€ <?=$vars['DISCOUNT']['discount']?></td></tr>
<tr><td><b><?= $consts['SEATS']?></b></td><td>€ <?=$vars['SEATS']['seats']?></td></tr>
<tr><td><b><?= $consts['FOOD'] .' ' . $vars['FOOD']['food_included']?></b></td><td>€ <?=$vars['FOOD']['food']?></td></tr>

        </tbody>
    </table>
</div>

<div class="box">
    <ul style="margin-left: 1rem;">
    <li class='li-box'><b><?= $consts['PERSONS'] .' ' .$vars['PERSONS']['persons']?></b></li>
    <div style="margin: 0.5rem 1rem;">
        <ul>
        <li class='li-box'>
        <?= $consts['ADULTS'] .' ' .$vars['ADULTS']['adults']?>
        </li>
        <li class='li-box'>
        <?= $consts['CHILDREN'] .' ' .$vars['CHILDREN']['children']?>
        </li>
        <li class='li-box'>
        <?= $consts['COUPONS'] .' ' .$vars['COUPONS']['coupon_persons']?>
        </li>
        </ul>
    </div>
    </ul>
</div>

<h4 style="margin-left: 2rem;"><?= $consts['OPTIONS']?></h4>
<div class="box">

    <? foreach($options as $title => $opty) :?>
        <ul style="margin-left: 1rem;">
            <li class='li-box'><b><?=$title?></b></li>
            <div style="margin: 0.5rem 1rem;">
                <ul>
                <? foreach($opty as $option) :?>
                    <li class='li-box'><?=$option?></li>
                <? endforeach ?>
                </ul>
            </div>
        </ul>
    <? endforeach ?>
</div>

<div class="box">
    <span><?= $consts['FOOTER']?></span>
    <h4 style="margin-top: 1rem;"><?=$vars['FOOTER']['project_name']?></h4>
</div>

