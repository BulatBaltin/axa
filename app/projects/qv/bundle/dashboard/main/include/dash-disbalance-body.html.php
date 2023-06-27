<? if (count($disbalance) > 0 ): ?>
<? foreach($disbalance as $disbal) : ?>
    <tr>
        <td>
            <strong><?=$disbal['hours0'] ?></strong>
        </td>
        <td>
            <strong><?=$disbal['hours1'] ?></strong>
        </td>
        <td style="color:
        <? if ($disbal['delta1'] > 0.25): ?>
        darkgreen
        <? elseif ($disbal['delta1'] < -0.25): ?>
        red
        <? else : ?>
        green
        <? endif ?>
        ;">
            <strong><?=$disbal['delta1'] ?></strong>
        </td>
        <td>
            <strong><?=$disbal['hours2'] ?></strong>
        </td>
        <td style="color:
        <? if ($disbal['delta2'] > 0.25): ?>
        darkgreen
        <? elseif ($disbal['delta2'] < -0.25): ?>
        red
        <? else: ?>
        green
        <? endif ?>
        ;">
            <strong><?=$disbal['delta2'] ?></strong>
        </td>
        <td style="background: #eee;">
            <strong><?=$disbal['submitted'] ?></strong>
        </td>
        <td>
            <?=$disbal['task'] ?>
        </td>
        <td>
        <? if ($disbal['customer_name'] == '()'): ?>
            (<? l('Empty Customer or Project') ?>)
        <? else: ?>
            <?=$disbal['customer_name'] ?>
        <? endif ?>
        </td>
    </tr>
<? endforeach ?>
<? else: ?>
    <tr>
        <td colspan='8'>
            <? l('No disbalance between Time tracking hours and Invoiceable hours') ?>
        </td>
    </tr>
<? endif ?>
