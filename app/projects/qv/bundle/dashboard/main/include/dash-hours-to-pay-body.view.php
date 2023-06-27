<? if (count($payhours)): ?>
    <? foreach($payhours as $payhour): ?>
        <tr>
            <td style='text-align: left;'>
                <span style='padding:<?=$payhour['padding']?>rem;'><?l($payhour['title'])?></span>
            </td>
            <td style='color:<?=$payhour['color']?>'>
                <?=$payhour['hours'] ?>
            </td>
        </tr>
    <? endforeach ?>
<? else: ?>
    <tr>
        <td colspan='2'>
            <?l('No estimated hours for the filter') ?>
        </td>
    </tr>
<? endif ?>
