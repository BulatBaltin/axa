<? if( count($Items) > 0 ): ?>
<? foreach( $Items as $atom ): ?>
    <tr id="rec<?=$atom['id']?>" class='tr-data'>
        <td style="text-align:left">
            <? if(!isset($mail_mode)): ?>
            <div class="table_label_mobile"><?l('Task') ?></div>
            <? endif  ?>

            <? if ($site_root and $atom['tid']): ?>
                <a class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$atom['tid']?>">(#<?=$atom['tid']?>)&nbsp;
                <?=$atom['task'] ?>
                </a>
                <? if ($site_root and $atom['parentTid']): ?>
                    &nbsp;(<a style="color:green" class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?$atom['parentTid']?>"><?l('Parent task') ?> #<?=$atom['parentTid']?></a>)
                <? endif ?>
            <? else :?>
                <?=$atom['task'] ?>
            <? endif ?>
        </td>
        <td> 
            <?=$atom['tasklist'] ?>
            <? if ($atom['projecten']): ?>
            / <?=$atom['projecten']?>
            <? endif ?>
        </td>
        <td>
            <?= date('d/m/y H:i', strtotime($atom['stop'])) ?>
        </td>
        <td>
            <?= $atom['TagsHtml'] ?>
        </td>
        <td <? if ($atom['priority'] == 'high'): ?> style="background:#dff;" <? endif ?>>
            <?=$atom['priority'] ?>
        </td>

    </tr>
<? endforeach ?>
<? else : ?>
    <tr>
        <td colspan="4"><?l('Set rules and press Report to view data')?></td>
    </tr>
<? endif ?>
