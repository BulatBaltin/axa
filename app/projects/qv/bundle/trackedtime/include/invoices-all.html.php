<style>
.custom_select select {
    max-width: 600px;
}
</style>
<div style="margin: 0.5rem;">
    <div style='margin-bottom: 0.5rem;'>
        <? if($dlg_form->customer): ?>
            <? $border = 'border:2px solid green;border-radius:4px;' ?>
        <? else :?>
            <? $border = '' ?>
        <? endif ?>

<? if (!empty($customer)): ?>
        <div  style='padding:5px;border:2px solid green;border-radius:4px;'>
            <?=$customer ?>
        </div>
<? else :?>
        <span><?l('Customer') ?>:</span>
        <? $dlg_form->start() ?>
        <span id ="dlg-pick-customer" class="custom_select" style='<?=$border?>'>
            <?  $dlg_form->widget('customer') ?>
        </span>
        <? $dlg_form->end() ?>
<? endif ?>

    </div>

    <div id='invoice-list' style='overflow-y:auto;max-height:300px;'>
    <? include(ROUTER::ModulePath() . 'include/invoices-customer.html.php') ?>
    </div>

</div>

<script type="text/javascript">
        $('#dlg_customer_customer').change( function(event){
            var customer_id = $('#dlg_customer_customer').val();
            $.ajax({ 
                method: "POST", 
                url: "<? path('qv.invoice.get-invoices') ?>", 
                dataType: 'json',
                data: { 
                    customer_id: $('#dlg_customer_customer').val(),
                    only_list: true },
                success: function (result) {
                    $('#invoice-list').html(result.html);
                }
            });
            return true;
        });    
</script>
