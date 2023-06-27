<? if($Items):?> 
    <? $inx = 0 ?>
<? foreach($Items as $one_item): 
    // $inx   = $one_item['idcache'];
    $one_item_level     = $one_item['level'];
    $one_item_pos       = $one_item['position'];
    $one_item_tid       = $one_item['tid'];
    ?>
    <? $one_row = $form->rows[$inx] ?>

    <tr id="rec<?=$inx?>" class="level<?=$one_item_level?>" data-level="<?=$one_item_level?>" data-id="<?=$inx?>">
    
        <td style='padding: 12px 0px !important;'>
            <div class="table_label_mobile"><? l('Position') ?></div>
            <div id="pos<?=$inx?>">
                <?=$one_item_pos ?><br><small>
                <? if ($inx < 0): ?>
                    <strong><span style='color:green;'><?l('New')?></span></strong>
                <? else : ?>
                    #<?=$one_item['id']?>
                <? endif ?>
                </small>
            </div>
        </td>
        <td style="text-align: left;padding-left:25px !important;">
        <? if ($one_item_level == "="): ?>
            <div>
        <? elseif ($one_item_level == "+"): ?>
            <div id="level<?=$inx?>" data-id="<?=$inx?>" data-node="<?=$inx?>" class='d-flex align-items-center pointer'>
                <div class="table_label_mobile"><? l('Level') ?></div>
                <div class="mr-3">
                    <svg class="svg-green minusyk" id="icon<?=$inx?>">
                        <use xlink:href="/images/icons/sprite.svg#minus-square"></use>
                    </svg>
                </div>
        <? else : ?>
            <div class='d-flex align-items-center pointer'>
                <div class="table_label_mobile"><? l('Level') ?></div>
                <div class="mr-5"></div>
        <? endif ?>
                <div class="table_label_mobile"><? l('Project') ?></div>
                <div id="proj<?=$inx?>"><?=$one_item['project_name'] ?></div>
<div hidden>
<? $one_row->widget('position',     ['name'=>"rows[$inx][position]" ])?>
<? $one_row->widget('id',           ['name'=>"rows[$inx][id]" ])?>
<? $one_row->widget('project_id',   ['name'=>"rows[$inx][project_id]" ])?>
<? $one_row->widget('project_name', ['name'=>"rows[$inx][project_name]", 'value' => $one_item['project_name'] ])?>
<? $one_row->widget('user_id',      ['name'=>"rows[$inx][user_id]" ])?>
<? $one_row->widget('user_name',    ['name'=>"rows[$inx][user_name]", 'value' => $one_item['user_name'] ])?>
<? $one_row->widget('tid',          ['name'=>"rows[$inx][tid]"])?>
<? $one_row->widget('task',         ['name'=>"rows[$inx][task]"])?>
<? $one_row->widget('price',        ['name'=>"rows[$inx][price]", 'step'=>'0.01','id'=>'price_id_'.$inx])?>
<? $one_row->widget('total',        ['name'=>"rows[$inx][total]", 'step'=>'0.01','id'=>'total_id_'.$inx])?>
<? $one_row->widget('quantityplan', ['name'=>"rows[$inx][quantityplan]",'step'=>'0.001','id'=>'quantityplan_'.$inx ])?>
<? $one_row->widget('quantitylost', ['name'=>"rows[$inx][quantitylost]",'step'=>'0.001','id'=>'quantitylost_'.$inx ])?>

<? $one_row->widget('status',       ['name'=>"rows[$inx][status]"])?>
<? $one_row->widget('level',        ['name'=>"rows[$inx][level]"])?>
<? $one_row->widget('score',        ['name'=>"rows[$inx][score]"])?>
<? $one_row->widget('tag',          ['name'=>"rows[$inx][tag]"])?>
</div>
            </div>
        </td>
        <td style='padding: 12px 5px !important;'>
            <div class="table_label_mobile"><? l('User') ?></div>
            <div id="empl<?=$inx?>">
                <?=$one_item['user_name'] ?>
            </div>
        </td>
        <td style='padding: 12px 5px !important;'>
            <div class="table_label_mobile"><? l('Task (NL)') ?></div>

            <div id="tasknl<?=$inx?>" class="td-tasknl" data-id="<?=$inx?>">
                <? $one_row->row('tasknl', [
                    'id'=>'tasknl_'.$inx, 
                    'name'=>"rows[$inx][tasknl]"
                    ]) ?>
                <span>
                <? if ($site_root and $one_item_tid): ?>
                    <a class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$one_item_tid?>">(#<?=$one_item_tid?>)&nbsp;
                    <?=$one_item['task'] ?>
                    </a>
                <? else : ?>
                    <?=$one_item['task'] ?>
                <? endif ?>
                </span>
            </div>

        </td>
        <td>
            <div class="table_label_mobile"><? l('Product') ?></div>
            <div class='d-flex'>

        <? if ($one_item_level == "+"): ?>
            <div>
                
            </div>
        <? else : ?>
            <div id="artikul<?=$inx?>" class="td-artikul custom_select_wrap_" data-id="<?=$inx?>" data-level="<?=$one_item_level?>">
                <? $one_row->widget('artikul',[
                    'id'=> 'artikul_' . $inx, 
                    'name'=>"rows[$inx][artikul_id]"
                    ]) ?>
            </div>
            <button id="copy-dn-<?=$inx?>" data-id="<?=$inx?>" type="button" class="btn ml-1 pl-1 pr-1 copy-dn">
                <i class="fas fa-chevron-down color-grey"></i>
            </button>
        <? endif ?>

            </div>
        </td>
        <td>
            <div class="table_label_mobile"><? l('Hours') ?></div>
            <? if ($one_item_level == "+"): ?>
                <? $one_row->widget('quantity',[
                        'id'    =>'quantity_'.$inx,
                        'name'  =>"rows[$inx][quantity]",
                        'step'  =>'0.001', 
                        'hidden'=>'hidden'])
                ?>
                <div id="subquantity<?=$inx?>">
                    <?=$one_item['quantity'] ?>
                </div>
            <? else : ?>
                <div id="quantity<?=$inx?>" class="td-quantity" data-id="<?=$inx?>" data-level="<?=$one_item_level?>" style="display: flex;" >
                    <div id="edit-quantity<?=$inx?>" style="margin: auto 3px auto 0;">
                        <? if ($one_item['status'] == 'fixed'): ?>
                            <i title="<? l('Fixed hours from Task list') ?>" class="fas fa-thumbtack color-grey"></i>                            
                        <? elseif ($one_item['status'] == 'edited'): ?>
                            <i title="<? l('The value was edited') ?>" class="fas fa-edit color-grey"></i>
                        <? endif ?>
                    </div>
                    <? $one_row->widget('quantity',[
                        'id'    =>'quantity_' . $inx, 
                        'name'  =>"rows[$inx][quantity]",
                        'step'  =>'0.001',
                    ]) ?>
                </div>
            <? endif ?>

        </td>
        <td>
            <div class="table_label_mobile"><? l('Price') ?></div>
            <? if ($one_item_level == "+"): ?>
                <div  id="price-row<?=$inx?>" class="nowrap">
                    <?=$one_item['price'] ?>
                </div>
            <? else : ?>
                <div id="price-row<?=$inx?>" class="nowrap">
                    <?=$one_item['price'] ?>
                </div>
            <? endif ?>
        </td>
        <td>
            <div class="table_label_mobile"><? l('Total') ?></div>
        <? if ($one_item_level == '+'): ?>
            <div id="subtotal<?=$inx?>" class="nowrap">
        <? else : ?>
            <div id="total<?=$inx?>" class="td-total nowrap">
        <? endif ?>
                <?=$one_item['total'] ?>
            </div>
        </td>
        <td class="nowrap">
            <div class="table_label_mobile"><? l('Hours(init)') ?></div>
            <div id="quantityplan<?=$inx?>">
                <?=$one_item['quantityplan'] ?>
            </div>
        </td>
        <!-- <td class="nowrap">
            <div class="table_label_mobile"><? l('Non-billable') ?></div>
            <div id="quantitylost<?=$inx?>">
                <?=$one_item['quantitylost'] ?>
            </div>
        </td> -->
        <td id="icon-edit<?=$inx?>">
            <? if ($one_item_level != "+"): ?>
            <div class="table_label_mobile"><? l('Actions') ?></div>
            <i class="edit_row_icon btn-edit pointer" title="Edit" data-id="<?=$inx?>">
                <svg>
                    <use xlink:href="/images/icons/sprite.svg#edit"></use>
                </svg>
            </i>
            <? endif ?>
            <i class="delete_row_icon btn-delete pointer" title="Delete" data-id="<?=$inx?>">
                <svg>
                    <use xlink:href="/images/icons/sprite.svg#bin"></use>
                </svg>
            </i>
        </td>
    </tr>
    <? $inx++ ?>
    <? endforeach ?>

<? else : ?>
    <tr id="no-rows">
        <td colspan="10">
            <? l('No row items') ?>
        </td>
    </tr>
<? endif ?>