<div>
    <select id="quick2dlg-select" size="<?=count($invoices)?>" style='text-indent: 15px;width:100%;padding:5px;'>
    <? $selected = 'selected' ?>
    <? foreach( $invoices as $invoice): ?>
        <option style='padding:5px;' value="<?=$invoice['id']?>" <?= $selected ?> >&nbsp;#<?= $invoice['id'] ?>&nbsp;&nbsp;<?= $invoice['invoice']?>&nbsp;&nbsp;</option>
        <? $selected = '' ?>
    <? endforeach ?>
    </select>
</div>
