<thead>
    <tr class='tr-header'>
        <th style="width:50px;"><?l('Pos') ?></th>
        <th style="width:250px;"><?l('Project') ?></th>
        <th style="width:150px;"><?l('User') ?></th>
        <th><?l('Task (NL)') ?></th>
        <th><?l('Product') ?></th>
        <th width="105px"><?l('Hours') ?></th>
        <th width="70px"><?l('Price')?></th>
        <th width="70px"><?l('Total')?></th>
        <th width="70px">
            <small><b><?l('init hours') ?></b></small>
        </th>
        <!-- <th width="70px">
           <small><b><? l('Non-billable') ?></b></small>
        </th> -->
    </tr>
</thead>
<tbody>
<? if( count($Items) > 0) : ?>
<? $inx = 0 ?>
<? foreach( $Items as $one_item ): ?>

    <tr id="rec<?=$one_item['id']?>" class="level<?=$one_item['level']?>" data-level="<?=$one_item['level']?>" data-position="<?=$one_item['position']?>"
        <? if ($one_item['level'] == "=" or $one_item['level'] == "+"): ?>
        <? else :?>
            style="display:none;"
        <? endif ?>
       >
        <td>
            <div class="table_label_mobile"><?l('Position') ?></div>
            <div id="pos<?=$one_item['id']?>">
                <?=$one_item['position'] ?>
            </div>
        </td>
        <td style="text-align: left;padding-left:25px !important;">
        <? if ($one_item['level'] == "="): ?>
            <div>
        <? elseif ($one_item['level'] == "+"): ?>
            <div id="level<?=$one_item['id']?>" data-id="<?=$one_item['id']?>" data-node="<?=$inx?>" class='d-flex align-items-center pointer'>
                <div class="table_label_mobile"><?l('Level') ?></div>
                <div class="mr-3">
                    <svg class="svg-green plusyk" id="icon<?=$one_item['id']?>">
                        <use xlink:href="/images/icons/sprite.svg#plus-square"></use>
                    </svg>
                </div>
        <? else :?>
            <div class='d-flex align-items-center pointer'>
                <div class="table_label_mobile"><?l('Level') ?></div>
                <div class="mr-5"></div>
        <? endif ?>
                <div class="table_label_mobile"><?l('Project') ?></div>
                <div id="proj<?=$one_item['id']?>"><?=$one_item['project_name'] ?></div>
            </div>
        </td>
        <td>
            <div class="table_label_mobile"><?l('User') ?></div>
            <div id="empl<?$one_item['id']?>">
                <?=$one_item['user_name'] ?>
            </div>
        </td>
        <td>
            <div class="table_label_mobile"><?l('Task (NL)') ?></div>
            <div id="tasknl<?=$one_item['id']?>" class="td-tasknl" data-id="<?=$one_item['id']?>">
                <?=$one_item['tasknl'] ?> <span><?=$one_item['task'] ?></span>
            </div>
        </td>
        <td>
            <div class="table_label_mobile"><?l('Product') ?></div>
            <?=$one_item['artikul_name'] ?>
        </td>
        <td>
            <div class="table_label_mobile"><?l('Hours') ?></div>
            <?=$one_item['quantity'] ?>
        </td>
        <td>
            <div class="table_label_mobile"><?l('Price') ?></div>
            <?=$one_item['price'] ?>
        </td>
        <td>
            <div class="table_label_mobile"><?l('Total') ?></div>
        <? if ($one_item['level'] == '+'): ?>
            <div id="subtotal<?=$one_item['position']?>" class="nowrap">
        <? else :?>
            <div id="total<?=$one_item['id']?>" class="td-total nowrap">
        <? endif ?>
                <?=$one_item['total'] ?>
            </div>
        </td>
        <td class="nowrap">
            <div class="table_label_mobile"><?l('init hours') ?></div>
            <div id="quantityplan<?=$one_item['id']?>">
                <?=$one_item['quantityplan'] ?>
            </div>
        </td>
    </tr>
    <? $inx++ ?>
    <? endforeach ?>

<? else : ?>
    <tr id="no-rows">
        <td colspan="8">
            <?l('No row items') ?>
        </td>
    </tr>
<? endif ?>
</tbody>
