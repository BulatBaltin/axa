<table class="full_width fully_mobile mt-4 mb-4">
    <thead>
    <tr>
        <th class="bg-bar p-0" width='5%'>
            <div class='round-spot' id="i-markall">
                <i class="far fa-square tb-check-icon"></i>
            </div>
        </th>
        <th><? l('ID') ?></th>
        <th><? l('Date') ?></th>
        <th><? l('Customer') ?></th>
        <th><? l('Hours') ?></th>
        <th><? l('Total') ?></th>
        <th><? l('Status') ?></th>
        <th><? l('Actions') ?></th>
    </tr>
    </thead>
    <tbody id='table_tbody'>
    <? $inx = 0 ?>
    <? foreach( $invoices as $invoice ):  ?>
        <? $one_row = $form->rows[$inx] ?>

        <? if (strpos($invoice['tag'],'A') !== false): ?>
            <? $bkgrnd = 'background: lightgrey;' ?>
            <? $state_icon = 'background: lightgrey;' ?>
        <? elseif (strpos($invoice['tag'],'D') !== false): ?>
            <? $bkgrnd = 'background: orange;' ?>
        <? else : ?>
            <? $bkgrnd = '' ?>
        <? endif ?>

        <tr style="<?=$bkgrnd ?>" id="rec<?=$invoice['id']?>" class="tr-data tr-drag tr-drop" data-invoice-id="<?=$invoice['id']?>" data-customer-id=<?=$invoice['customer_id']?> data-status-id="<?$invoice['status']?>">
            <td class="p-0 hide_on_mobile cell-mark">
                <div style="display: inline-flex;">
                    <? if ($invoice['status'] == 'not submitted' or $invoice['status'] == 'not ready' or $invoice['status'] == 'not sent'): ?>
                        <div class='round-spot'>
                            <i data-id="<?=$invoice['id']?>" class="i-mark far fa-square tb-check-icon"></i>
                        </div>
                        <span hidden><? //$form->widget($one_row['mark']) ?></span>
                    <? else : ?>
                        <span hidden><? //$form->widget($one_row['mark']) ?></span>
                    <? endif ?>

                    <? if (strpos($invoice['tag'], 'A') !== false):?>
                    <span style="color:grey;">
                        <i class="fas fa-cubes ml-1 mt-2"></i>
                    </span>
                    <? endif ?>
                    <? if (strpos($invoice['tag'], 'D') !== false): ?>
                    <span style="color:red;">
                        <i class="fas fa-minus-circle  ml-1 mt-2"></i>
                    </span>
                    <? endif ?>
                </div>
            </td>
            <td>
                <div class="table_label_mobile"><? l('ID') ?></div>
                <?=$invoice['doc_number']?>
                <? if ($invoice['status1']): ?>
                    <? $status = $invoice['status1'] ?>
                <? else : ?>
                    <? $status = 'auto'?>
                <? endif ?>
                <br><span><small>(<?=$status?> #<?=$invoice['id']?>) <?$invoice['period']?></small></span>

            </td>
            <td class='doc-date'>
                <div class="table_label_mobile"><? l('Date') ?></div>
                <?=date('d/m/Y', strtotime($invoice['doc_date']))?>
            </td>
            <td id='customer<?=$invoice['id']?>'>
                <div class="table_label_mobile"><? l('Customer') ?></div>
                <a class="row-href" href="<? path('customer.site', ['id' => $invoice['customer_hash']]) ?>">
                    <?=$invoice['customer_name']?>
                </a>
            </td>
            <td>
                <div class="table_label_mobile"><? l('Hours') ?></div>
                <?=$invoice['quantity']?>
            </td>
            <td>
                <div class="table_label_mobile"><? l('Total') ?></div>
                <?=$invoice['total']?>
            </td>
            <td>
                <div class="table_label_mobile"><? l('Status') ?></div>
                <? if ($invoice['status'] == 'not submitted'): ?>
                    <i class="fas fa-check-circle big-icon-green"></i>
                <? elseif ($invoice['status'] == 'not ready' or $invoice['status'] == 'not sent'):  ?>
                    <i class="fas fa-exclamation-circle big-icon-red"></i>
                <? else : ?>
                    <i class="fas fa-check-circle big-icon-green"></i>
                    <i class="fas fa-check-circle big-icon-green"></i>
                <? endif ?>
            </td>

            <td>
                <div class="table_label_mobile"><? l('Actions') ?></div>
                <? if ($invoice['status'] == 'not submitted' or $invoice['status'] == 'not ready' or $invoice['status'] == 'not sent'):  ?>

                    <a class="edit_row_icon" href="<? path("qv.invoice.edit", ['id' => $invoice['id']]) ?>">
                        <svg>
                            <use xlink:href="/images/icons/sprite.svg#edit"></use>
                        </svg>
                    </a>
                    <? if ($invoice['status'] == 'not submitted'): ?>                    
                        <a class='do-submit share_row_icon' data-id="<?=$invoice['id']?>" data-num="<?=$invoice['doc_number']?>" href="<? path('qv.invoice.sendOne2account', ['id' => $invoice['id']]) ?>">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#share"></use>
                            </svg>
                        </a>
                    <? endif ?>                    
                    <a class="del-btn delete_row_icon" data-id="<?=$invoice['id']?>" data-num="<?$invoice['doc_number']?>" href="<? path('qv.invoice.delete', ['id' => $invoice['id']]) ?>">
                        <svg>
                            <use xlink:href="/images/icons/sprite.svg#bin"></use>
                        </svg>
                    </a> 
                <? else : ?>

                    <a class="view_row_icon" href="<? path('qv.invoice.view', ['id' => $invoice['id']]) ?>">
                        <svg>
                            <use xlink:href="/images/icons/sprite.svg#eye"></use>
                        </svg>
                    </a>
                    <a target="_blank" class="download_row_icon" href="<?=$invoice['urlpdfbestand'] ?>">
                        <svg class="search_icon">
                            <use xlink:href="/images/icons/sprite.svg#archive"></use>
                        </svg>
                        <span style="font-size:0.7rem;"><?=$invoice['factuurnummer'] ?></span>
                    </a>

                <? endif ?>

            </td>
            <td hidden class="td-customer" >
                <?$invoice['customer_id']?>
            </td>
            <td hidden class="td-status">
                <?$invoice['status']?>
            </td>
        </tr>
        <? $inx++ ?>
    <? endforeach ?>
    </tbody>
</table>

<? include( DMIGHT.'template/pagination.html.php') ?>
