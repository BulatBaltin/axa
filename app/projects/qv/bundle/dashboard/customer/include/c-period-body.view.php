<? if ((count($periodReport) - 1) > 0): ?>
    <tr style="background: #ddd; font-size:1rem;font-weight: 600;">
        <td>
            <strong><?=$periodReport[0]['total'] ?></strong>
        </td>
        <td style='text-align: left;'>
            <? l('Total') ?> 
        </td>
    </tr>
<? for($i=1; $i< count($periodReport);$i++) : ?>
    <tr>
        <td>
            <strong><?=$periodReport[$i]['total'] ?></strong>
        </td>
        <td style='text-align: left;'>
            <? if ($lang == 'en'): ?>
                <?=$periodReport[$i]['task'] ?> 
            <? else :?>
                <?=$periodReport[$i]['tasknl'] ?> 
            <? endif ?>
        </td>
    </tr>
<? endfor ?>
<? endif ?>