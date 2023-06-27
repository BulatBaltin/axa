<div class="mb-3 table_head">
    <h3 class="mr-3"><?l('Hours to pay') ?> &nbsp;&nbsp; <span style="font-weight: 600;"><?=$payhours[6]['hours'] ?></span></h3><br>
</div>
<table id="tb-staff" class="fully_mobile">
    <tr>
        <th class="p-2" width="60%"><?l('Total') ?></th>

        <th class="sort_th">
            <div class="d-flex"><?l('Hours') ?>
            </div>
        </th>
    </tr>

    <tbody>
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
    </tbody>
</table>
