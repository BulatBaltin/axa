<div class='page_wrap'>

    <? $form->start('inv', route('qv.invoice.save')) ?>
    <div>
        <? $form->errors() ?>
    </div>
    <h2 class="mb-3"><?l($Title) ?></h2>

    <div class="row mb-4">

        <div class="col-md-4 ">
            <? if(!empty($index_uri)): ?>
                <? $url_back = $index_uri ?>
            <? else : ?>
                <? $url_back = route('qv.invoice.index') ?>
            <? endif ?>
            <? include_view(DMIGHT.'template/move-button.html.php', [
                'url_back'  => $url_back,
                'url_text'  => ll('Invoice list'),
                'title'     => ll('Back to invoice list page'),
                'url_class' => ''
                ]) ?>

            <? if(!empty($hours_uri)):?>
                <? $url_back = $hours_uri ?>
            <? else : ?>
                <? $url_back = route('qv.t-time.index') ?>
            <? endif ?>
            <? include_view(DMIGHT.'template/move-button.html.php', [
                'url_back'  => $url_back,
                'url_text'  => ll('Tracked time'),
                'title'     => ll('Back to Tracked time page'),
                'url_class' => 'ml-3 mr-2'
                ]) ?>
        </div>
    </div>

    <div class="row">

<div hidden>
<? $form->widget('row_index')?>
<? $form->widget('id')?>
<? $form->widget('invoice_id')?>
<? $form->widget('customer_id')?>
<? $form->widget('currency_code')?>
<? $form->widget('doc_number')?>
<? $form->widget('doc_date')?>
<? $form->widget('quantity',    ['id'=>'grand-quantity','step'=>'0.001'])?>
<? $form->widget('total',       ['id'=>'grand-total',   'step'=>'0.01'])?>
<? $form->widget('vatsum',      ['id'=>'grand-vatsum',  'step'=>'0.01'])?>
<? $form->widget('totalvat',    ['id'=>'grand-totalvat','step'=>'0.01'])?>
<? $form->widget('vatcoeff',    ['id'=>'invoice_vatcoeff_0']) ?>
</div>

    <? if($invoice['id']): ?>
        <div class="col-md-3" style="padding:12px 15px;">
            ID: <b><?= $invoice['id'] ?></b>&nbsp;&nbsp; №: <b><?=$invoice['doc_number']?></b>
            <a style="text-decoration: none;" href="#" id="log-invoice" class="ml-3" title="Invoice log">
                <i class="fas fa-info-circle"></i>
            </a>
            <a style="text-decoration: none;" title='Undo changes and reload invoice' href="#" id="undo-changes" class="ml-3">
                <i class="fas fa-undo"></i>
            </a>
            <span style="color:red;" title="<?l('Unsaved changes')?>">
            <svg style='height: 0.8rem; width: 1rem;margin-left:1rem;margin-bottom:5px;'>
                <use fill="red" xlink:href="/images/icons/sprite2.svg#sun-solid"></use>
            </svg>
            </span>

            <? if($invoice['status1']): ?>
            <? $status = $invoice['status1'] ?>
            <? else : ?>
            <? $status = 'auto'?>
            <? endif ?>
            <br><span><small>(<?=$status?>) <?=$invoice['period']?></small></span>
        </div>

        <div class="col-md-3"  style="padding:12px 0;" >
            <? l('Client') ?>: <b><?= $invoice['customer_name'] ?></b>
        </div>
        <div class="col-md-3">
            <? l('Invoice creation date') ?>: <br><span style="color:grey;"><b><?= date('d/m/Y',strtotime($invoice['doc_date'])) ?></b></span>
        </div>
    <? else : ?>
        <div class="col-md-1">
            <div class="d-flex">
                <span class='mt-2'><strong>#&nbsp;</strong></span><? $form->widget('doc_number')?>
            </div>
        </div>
        <div class="col-md-2 custom_select">
            <? $form->widget('customer')?>
        </div>
        <div class="col-md-4">
            <div class="d-flex">
                <span class='mt-2'><? l('Date/time') ?>:&nbsp;</span>
                <span style="font-size:12px;"><? $form->widget('doc_date')?></span>
            </div>

        </div>

    <? endif ?>
        <div class="col-md-3">
            <? if($invoice['status'] == 'not submitted'): ?>
                <div id='status-doc' class="mb-2 mt-2 pb-3"><span class="frame-rounded status_yellow"><? l('Status') ?>: <b><?= $invoice['status'] ?></b></span></div>
            <? else : ?>
                <div id='status-doc' class="mb-2 mt-2 pb-3"><span class="frame-rounded status_red"><? l('Status') ?>: <b><?= $invoice['status'] ?></b></span></div>
            <? endif ?>
        </div>
    </div>

    <div>
        <table id="grid-items" class="fully_mobile full_width mb-3">
            <? include('include/t-edit.view.php') ?>
        </table>

        <? $dummy_id = "123456" ?>
        <? $dummy_position = "1_2_3_4" ?>

    </div>
    
    <div id="btn-panel" class="mt-3" style="display: flex;">
        <div class="mr-2 mb-2 mt-2">
            <button id="invoice_items_add" name="add-item-line" type="button" class="btn mr-2">
            <? l('Add new')?>&nbsp;&nbsp;
                <i class="fas fa-plus-circle"></i>
            </button>
        </div>

        <div class="d-flex mb-2 mt-2" style="margin-left: auto;">
            <div class="mr-3">
                <button id="save-invoice" name="Save" type="submit" class="btn"><? l('Save invoice')?>&nbsp;&nbsp;
                <i class="fas fa-file-download"></i>
                </button>
            </div>
            <div>
                <button id="save-submit" name="SaveSubmit" type="submit" class="btn"  <? if($invoice['status'] != 'not submitted'): ?>disabled<? endif ?>>
                <? l('Save invoice and submit to accounting software') ?>&nbsp;&nbsp;
                <i class="fas fa-share-square"></i>
                </button>
            </div>

        </div>
    </div>
    <? $form->end() ?>

    <? $form->start('dummy') ?>

    <div hidden id="edit-id"></div>

    <? if(count($form->curritem) > 0): ?>
    <? $curritem = $form->curritem[0]; $curritem->form_name = 'dummy_item'; ?>

<div hidden>
<? $curritem->widget('position',    ['name'=>"plus_position" ])?>
<? $curritem->widget('id',          ['name'=>"plus_id" ])?>
<? $curritem->widget('tid',         ['name'=>"plus_tid"])?>
<? $curritem->widget('quantityplan',['name'=>"plus_quantityplan",'step'=>'0.001'])?>
<? $curritem->widget('quantitylost',['name'=>"plus_quantitylost",'step'=>'0.001'])?>
<? $curritem->widget('status',      ['name'=>"plus_status"])?>
<? $curritem->widget('level',       ['name'=>"plus_level"])?>
<? $curritem->widget('score',       ['name'=>"plus_score"])?>
<? $curritem->widget('tag',         ['name'=>"plus_tag"])?>
</div>

    <div id="update-box" class="update-box" style="display: none;">
        <div style="display: flex; justify-content: space-between;">

            <button id="invoice_items_Update" name="aupdate-item-line" type="button" class="btn btn-info">
            <? l('Update')?>&nbsp;&nbsp;
                <i class="fas fa-edit"></i>
            </button>

            <button hidden id="invoice_items_plus" name="aupdate-item-line" type="button" class="btn btn-info">
            <? l('Add new')?>&nbsp;&nbsp;
                <i class="fas fa-plus-circle"></i>
            </button>
            
            <span id="update-close">
                <i class="far fa-times-circle" style="font-size:2rem;"></i>
            </span>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label><? l('Project') ?></label>
                    <div class="custom_select_wrap" id='customer_projects'>
                        <? $curritem->widget( 'project',['name' => 'plus_project_id'] ) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><? l('User') ?></label>
                    <div class="custom_select_wrap">
                        <? $curritem->widget( 'user',['name' => 'plus_user_id'] ) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><? l('Task (en)') ?></label>
                    <? $curritem->widget( 'task',['name' => 'plus_task'] ) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><? l('Task (NL)') ?></label>
                    <? $curritem->widget( 'tasknl',['name'=>'plus_tasknl'] ) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group custom_select_wrap">
                    <label><? l('Product') ?></label>
                    <? $curritem->widget( 'artikul',['name'=>'plus_artikul_id'] ) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><? l('Hours') ?></label>
                    <? $curritem->widget( 'quantity',['name'=>'plus_quantity'] ) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><? l('Price') ?></label>
                    <? $curritem->widget( 'price', ['name'=>'plus_price']) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><? l('Total') ?></label>
                    <? $curritem->widget( 'total',['name'=>'plus_total'] ) ?>
                </div>
            </div>
        </div>
    </div>
    <? endif ?>

    <br>

    <table width="100%" class="table mt-4 totals" >
    <tr>
    <th width="20%"><? l('Hours') ?>
    <th width="20%"><? l('Total (exl.VAT)') ?>
    <th width="20%"><? $form->label('vatcoeff') ?>
    <th width="20%"><? l('Total VAT') ?>
    <th><? l('Total (incl.VAT)') ?>
    </tr>
    <tr class="bg-white doc-header">
    <td class="cell-total" id="t-quantity"><mark class="p-2"><?= roundEx($invoice['quantity'],3) ?></mark>
    <td class="cell-total" id="t-total"><?= $invoice['total'] ?>
    <td id="t-vatcoeff"><? $form->widget('vatcoeff',['id' => 'invoice_vatcoeff']) ?>
    <td class="cell-total" id="t-vatsum"><?= $invoice['vatsum'] ?>
    <td class="cell-total" id="t-totalvat"><?= $invoice['totalvat'] ?>
    </tr>
    </table>
    <div hidden>
        <? $form->rest() ?>
    </div>
    <? $form->end() ?>
    
    <? include('include/downpayment.html.php') ?>
    
    <div class='p-2'></div>
</div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript"> 

<? include('js/toolskit/funcs.js') ?>

const dummy_id  = "123456";
const dummy_pos = "1_2_3_4";
const not_submitted = 'not submitted';
const not_ready     = 'not ready';

const artikul_current   = "#dummy_item_artikul_id";
const quantity_current  = "#dummy_item_quantity_id";
const quantityplan_current = "#dummy_item_quantityplan_id";
const price_current     = '#dummy_item_price_id';
const total_current     = "#dummy_item_total_id";
const tid_current       = "#dummy_item_tid_id";
const task_current      = "#dummy_item_task_id";
const tasknl_current    = "#dummy_item_tasknl_id";
const project_current   = "#dummy_item_project_id";
const user_current      = "#dummy_item_user_id";
const invoice_customer  = "#z_invoice_customer";

const invoice_id = <?=$invoice['id']?>; 
var item_id; 
var artikul; 
var project; 
var customer; 
var user;
var task;    
var tasknl;  
var quantity;
var quantityplan = 0;
var price;
var product;
var total = 0;
var next_pos = <?=$count ?>;
var position = <?=$count ?>;

String.prototype.replaceAll = function(search, replacement) {
let target = this;
return target.replace(new RegExp(search, 'g'), replacement);
};

$(document).ready(function(){

    initSelect2();

    // jQuery('#x-datetimepicker').datepicker({
    //     dateFormat: "dd/mm/yy"
    // });
// ------------------------]

    $(quantity_current).change(function () {
        total = parseFloat($(quantity_current).val()) * parseFloat($(price_current).val());
        total = total.toFixed(2);
        $(total_current).val(total);
    });
    $(price_current).change(function () {
        total = parseFloat($(quantity_current).val()) * parseFloat($(price_current).val());
        total = total.toFixed(2);
        $(total_current).val(total);
    });
    $(total_current).change(function () {
        var price = parseFloat($(price_current).val());
        var quantity = parseFloat($(quantity_current).val());
        total = parseFloat($(total_current).val());

        if (quantity !== 0) {
            price = (total / quantity).toFixed(2);
            $(price_current).val(price);
        } else {
            $(total_current).val(0);
        }
    });

    function SaveToGridRow(Add) {

        // alert(lAdd);

        let url = "<?path('qv.invoice.refreshgrid')?>";

        let formUp      = $('form[name="inv"]')[0];
        let form_inv    = new FormData(formUp);

        let formDn      = $('form[name="dummy"]')[0];
        let form_dummy  = new FormData(formDn);

        for (const pair of form_dummy.entries()) {
            form_inv.append(pair[0], pair[1]);
        }        
        form_inv.append('add', Add);
        // ShowProcess();
        $.ajax({
            method: "POST", url: url, dataType: 'json',
            cache: false, processData: false, contentType: false,
            data: form_inv,
            success: function(result) {
                // HideProcess();
                set_zero_data();
                updateClose();
                $('#grid-items').html(result.html_table);
                setGrandTotals(result.invoice);
                // fetchGrandTotals();                
            }
        });
    }    
    // + --------------- Press button Edit item --------------------- + //
    $('#grid-items').on('click', '.btn-edit', function(event){ //change((event)=> {
        // alert('PLUS');
        let flds = [
            'position','id','tid','project_id','user_id','task','tasknl','artikul_id','price','total','quantity','quantityplan','quantitylost','status','level','score','tag'
        ];
        let tr_id = $(this).data('id');
        let fld, val;

        for (let index = 0; index < flds.length; index++) {
            fld = flds[index];
            val = $('form [name="rows['+tr_id+']['+fld+']"]').val();
            $('form [name="plus_'+fld+'"]').val(val); 
        }

        $('form [name="plus_artikul_id"]').change();

        HilightRowOn(tr_id);

        $('#btn-panel').prop('hidden', true);
        $('#update-box').show('slow');

        scroll2Id('#update-box');

    });

    $(artikul_current).change(function(){
        let artikul_id = $(this).val();

        $.ajax({
            url: "<?path('qv.invoice.artikul.price')?>",
            type: "POST", 
            dataType: 'json',
            data: {
                artikul_id : artikul_id // id
            },
            success: function(result) {
                $(price_current).val(result.price);
                $(price_current).change();
            }
        });
    });

    // + --------------- delete row remove row ------------------- + //

    $('#grid-items').on('click', '.btn-delete', function(event){ //change((event)=> {
        var data_id = $(this).data('id');
        dmDialog({
            title: "<? l('Delete invoice item')?>",
            text: "<? l('Delete invoice item? It has an effect after Save action')?>",
            ok: function() {
                onDeleteItem(data_id);   
            }
        });
        return false;
    });    

    function onDeleteItem(data_id) {    

        let url = "<?path('qv.invoice.delete-item')?>";

        $('#row_position').val(data_id);

        ShowProcess();
        let formUp      = $('form[name="inv"]')[0];
        let form_data   = new FormData(formUp);

        $.ajax({
            method: "POST", url: url, dataType: 'json',
            data: form_data,
            cache: false, processData: false, contentType: false,
            success: function(result) {
                HideProcess();
                $('#grid-items').html(result.html_table);
                setStatus();
                setGrandTotals(result.invoice);
                // fetchGrandTotals();                
            }
        });
    }

//+:Change + --------------- product artikul ------------- + //

    let func_totals = function(event){ //change((event)=> {<--$(this)doesn't work ?

        let tr      = $(this).closest('tr');
        let tr_id   = $(tr).data('id');
        let level   = $(this).data('level');
        let url     = "<?path('qv.invoice.artikul.totals')?>";

        $('#row_position').val(tr_id);

        let formUp      = $('form[name="inv"]')[0];
        let form_data   = new FormData(formUp);
        // If you want to add an extra field for the FormData
        // form_data.append("CustomField", "This is some extra data, testing");

        $.ajax({
            type: "POST", url: url, dataType: 'json',
            data: form_data,
            cache: false, processData: false, contentType: false,
            success: function (result) {
                $('#grid-items').find('td #price-row'+tr_id).html( "<mark>"+result.price+"</mark>");
                setSubtotalRow(result, level, tr_id);
                setGrandTotals(result);
            }
        });

        setStatus();
        return false;
    }

    $('#grid-items').on('change', '.td-artikul',    func_totals ); 
    $('#grid-items').on('change', '.td-quantity',   func_totals );

    function setSubtotalRow(result, tr_level, tr_id) {
    if(result.subtotal == true) {

        $('#grid-items').find('td #subquantity'+tr_level).html(result.subtotal_quantity);
        $('#grid-items').find('td #subtotal'+tr_level).html(result.subtotal_total);
        $('#grid-items').find('td #price-row'+tr_level).html(result.subtotal_price);
        $('form [name="rows['+tr_level+'][quantity]"]').val(result.subtotal_quantity);            
        $('form [name="rows['+tr_level+'][total]"]').val(result.subtotal_total);            
        $('form [name="rows['+tr_level+'][price]"]').val(result.subtotal_price);            

    } 
    $('form [name="rows['+tr_id+'][total]"]').val(result.total);            
    $('form [name="rows['+tr_id+'][price]"]').val(result.price);            

    // $('#grid-items').find('td #total_id_'+tr_id).val(result.total);            
    $('#grid-items').find('td #total'+tr_id).html(result.total);            
    $('#grid-items').find('td #quantitylost'+tr_id).html(result.lost);            
    $('#grid-items').find('td #edit-quantity'+tr_id).html('<i title="<? l('The value was edited')?>" class="fas fa-edit color-grey"></i>');            
    // fetchGrandTotals();
    }

    $("#invoice_vatcoeff").change(function () {
        let vat;
        vat = setTotalTotals();

        $('#invoice_vatcoeff_0').val(vat);
        
        $.ajax({
            type: "POST", url: "<?path('qv.invoice.vatcoeff')?>",
            dataType: 'json',
            data: {
                vatcoeff: vat,
                invoice_id: invoice_id
            },
            // beforeSend: function () {
            //     $('#themediv').append();
            // },
            success: function (result) { 
                $("#notes").html("<strong>" + result + "</strong>");
            }
        });
    });

// ------------------------]
// ------------------------]
        $(invoice_customer).change(function(){
            let url = "<? path('qv.invoice.new.customer')?>";
            $('#customer_projects').load(
                url, 
                {id: $(invoice_customer).val() },
                function(){
                });
        });

        //$("form[name~='invoice_items']").submit(function (event) {  called.");
        //    event.preventDefault();
        //});

        // $('#save-submit,#save-invoice').click(function(){
        //     // alert('SAVE');
        //     ShowProcess();
        //     return true;
        // });

        $('#grid-items').on('click', "[id^='level']", function(event){ //change((event)=> {
            var data_node = $(this).data('node');
            let id = $(this).data('id');
            if($("#icon"+id).hasClass('plusyk')) {
                $("#icon"+id).html('<use xlink:href="/images/icons/sprite.svg#minus-square"></use>');                    
                $("#grid-items").find( "[data-level='"+data_node+"']").show("slow");
                $("#icon"+id).removeClass('plusyk');
                $("#icon"+id).addClass('minusyk');

            } else {
                $("#icon"+id).html('<use xlink:href="/images/icons/sprite.svg#plus-square"></use>');                    
                $("#grid-items").find( "[data-level='"+data_node+"']").hide("slow");
                $("#icon"+id).removeClass('minusyk');
                $("#icon"+id).addClass('plusyk');
            }

            // $("#grid-items [data-level='"+data_node+"']").hide();
            // $("#grid-items").find( "[data-level='"+data_node+"']").toggle("slow");

        });

        $('#grid-items').on('click', ".copy-dn",  function(){
            let id = $(this).data('id');
            var value = $('#artikul'+id+' select').val();
            var title = $('#artikul'+id+' option:selected').text();
            if(value == '') {
                alert( "<? l('Empty product value') ?>"); 
                return false;
            }
            dmDialog({
                title: "<? l('Fill empty cells') ?>",
                text: "<? l('Fill empty product column values with this value?') ?>"+"<br>"+title,
                ok: function() {
                    $('.td-artikul select').each( function(){
                        if($(this).val() == '' || $(this).val() == 0 ) {
                            $(this).val(value).change();     
                        }
                    });
                }
            });
        });

        //+:Change + --------------- Tsknl ------------- + //
        $('#grid-items').on('change', '.td-tasknl', function(event){ //change((event)=> {

            var data_id = $(this).data('id');
            var tasknl = $(this).find('input').val();
            $.ajax({
                method: "POST", 
                url: "<? path('qv.invoice.tasknl.edit') ?>", dataType: 'json',
                data: { 
                    data_id: data_id,
                    tasknl: tasknl,
                },
                success: function (result) { showResult( result ); }
            });
            return false;
        });

        $('#undo-changes').click(function() {
            dmDialog({
                title: "<? l('Reload the invoice?')?>",
                text: "<? l('Load the invoice without current changes')?>",
                ok: function() {
                    LoadInvoiceFromDb();
                }
            });
        });

        function LoadInvoiceFromDb() {
            ShowProcess();
            let url = "<?path('qv.invoice.reload', ['id' => $invoice['id']])?>";
            $.ajax({ // POST works
                type: "POST", url: url,
                dataType: 'json',
                data: {
                    invoice_id: invoice_id
                },
                success: function (result) { 
                    let url = "<?path('qv.invoice.edit', ['id' => $invoice['id']] ) ?>";
                    // url = url.replace('123456789', invoice_id );
                    window.location.href = url;
                }
            });
            return false;

        }

        $('#log-invoice').click(function() {
            $('#modal-dlg').addClass('visible-yes');
            // Bad: $('.modal-overlay').prop('hidden', false);
            // Bad: $('.modal-overlay').show();
            //$('.menu-modal').addClass('visible-yes');
            //menuDOM.classList.add('showMenu');
            $.ajax({ // POST works
                type: "POST", url: "<?path('qv.invoice.logging')?>",
                dataType: 'html',
                data: {
                    invoice_id: invoice_id
                },
                // beforeSend: function () {
                //     $('#themediv').append();
                // },
                success: function (result) { 
                    $('#modal-header').html('Invoice id: '+invoice_id+' log records');
                    $("#modal-body").html( result );

                }
            });
            return false;
        });

        $('.close-modal,#btn-close-modal').click(function() {
            $('.modal-overlay').removeClass('visible-yes');
            return false;
        });


        // + --------------- edit item ------------------- + //
        $('#update-close').on('click', function(event){ //change((event)=> {
            updateClose();
        });    
        function updateClose() { //change((event)=> {

            $('#update-box').hide('slow');
            $('#invoice_items_Update').prop('hidden', false);
            $('#invoice_items_plus').prop('hidden', true);
            $('#btn-panel').prop('hidden', false);
            HilightRowOff(); // in case it was an update :)
        };    

        // + --------------- Press button Update item ------------------- + //
        $("#invoice_items_Update").click(function () {
            SaveToGridRow('update');
            return false;
        });

        // + --------------- Press button Add item --------------------- + //
        $("#invoice_items_add").click(function () {

            set_zero_data();
            
            $('#btn-panel').prop('hidden', true);
            $('#invoice_items_Update').prop('hidden', true);
            $('#invoice_items_plus').prop('hidden', false);
            $('#update-box').show('slow');

            scroll2Id( '#update-box' )

            return false;
        });

        function scroll2Id( id ) {
            let point = $(id).offset();
            $('html,body').animate({ scrollTop: point.top - 80}, 'slow');
        }

        $("#invoice_items_plus").click(function () {

            SaveToGridRow('add');
            return false;
        });


    function load_grid_contents(data_id) {
        ShowProcess();
        $('#grid-items').load( 
            "<?path('qv.invoice.refreshgrid')?>",
            {
                invoice_id  : invoice_id, // id
                data_id  : data_id, // id
                position : position,
                artikul  : artikul, // id
                project  : project, // id  
                customer_id : customer, // id  
                user : user, // id
                task : task,
                tasknl : tasknl,
                quantity : quantity,
                price : price,
                total : total
            },
            function() {
                HideProcess();
                set_zero_data();
                updateClose();
                setTotalsRows();                

               // scroll2Id( '#rec'+result.data_id);
               // $("#notes").html("<strong>" + result + "</strong>");
            }
        );
    }    


    function update_row_server(data_id) {
        $.ajax({
            type: "POST", 
            url: "<?path('qv.invoice.updateitem')?>",
            dataType: 'json',
            data: {
                data_id  : data_id, // id
                position : position,
                artikul  : artikul  , // id
                project  : project  , // id  
                user : user , // id
                task     : task     ,
                tasknl   : tasknl   ,
                product: product,
                quantity: quantity,
                price: price,
                total: total
            },
            // beforeSend: function () {
            //     $('#themediv').append();
            // },
            success: function (result) { // 
                refreshDataID(result.data_id, false);
                set_zero_data();
                updateClose();

                scroll2Id( '#rec'+result.data_id);

                $("#notes").html("<strong>" + result + "</strong>");

            }
        });
    }

    function refreshDataID( data_id, lAdd ) {
        let container = $("#rec"+dummy_id).html();
        container = container.replaceAll(dummy_id, data_id); // data_id
        container = container.replaceAll(dummy_pos, ""+position);

        if( lAdd === true) {

            if($('#no-rows').length) {
                $('#no-rows').prop('hidden',true);
            }
            let row = `<tr id="rec`+data_id+`">` + container + "</tr>";
            $("#grid-items").append(row); 
        } else {
            $("#rec"+data_id).html(container);
        }

        // these values are not copied (why?)
        $("#mark"+data_id+" input").prop("checked", true); // id used
        $("#artikul"+data_id+" select").val(artikul); // id used
        $("#tasknl"+data_id+" input" ).val(tasknl); // id used
        $("#quantity"+data_id+" input").val(quantity);

        setTotalsRows();
    }

    function HilightRowOn( tr_id ) {
            let prev_edit = $('#edit-id').text();
            if(prev_edit !== '') {
                $("#icon-edit"+prev_edit).removeClass('bg-edit');
            }
            $("#edit-id").text(tr_id);
            $("#icon-edit"+tr_id).addClass('bg-edit');
    }
    function HilightRowOff() {
            let prev_edit = $('#edit-id').text();
            if(prev_edit !== '') {
                $("#icon-edit"+prev_edit).removeClass('bg-edit');
            }
            $("#edit-id").text("");
    }


        // + --------------- items fixed hours ----------------- + //
        //$('#items_fixed_hours').on('click', function(event){ //change((event)=> {
        $('#grid-items').on('click','#items_fixed_hours', function(event) { //change((event)=> {

            dmDialog({
                title: "<? l('Set fixed hours')?>",
                text: "<? l('Set fixed hours values (min or max)? They should be set for tasks in Tasks section')?>",
                ok: function() {
                    ShowProcess();
                    let url = "<?path('qv.invoice.items-fixed-hours', ['id' => $invoice['id'] ])?>";
                    $('#grid-items').load(
                        url, 
                        { id: invoice_id },
                        function(){
                            HideProcess();
                        });
                    return false;
                }
            });
            return false;
        });
        // + --------------- round hours ----------------- + //
        $('#items_hours_round').on('click', function(event){ //change((event)=> {
            let ahours = $('.td-quantity input');
            $.each(ahours, function(ix, xvalue){
                let value = $(xvalue).val();
                value = roundHours(value);
                $(xvalue).val(value);

                let data_id = $(xvalue).parent("td").data('id');
                let quantity = getQuantity(data_id);

                $.ajax({
                    type: "post", url: "<?path('qv.invoice.artikul.quantity')?>", dataType: 'json',
                    data: {
                        item_id: data_id,
                        quantity: quantity,
                    },
                    // success: function (result) {}
                });

            });

            // recalculate totals

            return false;
        });


    // + --------------- Service functions ------------------- + //
    function getQuantity(data_id) {
        let quantity = $('#grid-items').find('td #quantity'+data_id+" input").val();
        return quantity;

    }
    function php_round(number, precision) {
        var factor = Math.pow(10, precision);
        var tempNumber = number * factor;
        var roundedTempNumber = Math.round(tempNumber);
        return roundedTempNumber / factor;
    }
    function roundHours( hDec) {
        let hBase = Math.floor(hDec);
        let hMod = hDec - hBase;
        if (hMod == 0) {
            hMod = 0;
        } else if(hMod < 0.38) {
            hMod = 0.25;
        } else if(hMod < 0.63) {
            hMod = 0.50;
        } else if(hMod < 0.88) {
            hMod = 0.75;
        } else {
            hMod = 1.00;
        }
        hBase += hMod;
        return hBase;
    }

    // + ----------------------------------- + //
    function setGrandTotals( result ) {
// {# alert("Grand >> "+result.grand_quantity + ' ' + result.grand_total); #}
        $("#t-total").html(result.grand_total);
        $("#grand-total").val(result.grand_total);
        $("#t-quantity mark").html(result.grand_quantity);
        $("#grand-quantity").val(result.grand_quantity);
        setTotalTotals();
    }
    
    // + ----------------------------------- + //
    function setTotalsRows() {

        var sum = 0;
        var hours = 0;
        $("#grid-items .td-total").each(function () {
            // let total = $(this).find("td:eq(8)").text(); 
            let total = $(this).text();
            // let total = parseFloat($(this).cells().item('total').val());
            if ($.isNumeric(total)) {
                total = parseFloat(total);
                sum += total;
                // console.log(total);
            }

        });
        sum = php_round(sum, 2);

        $("#grid-items").find(".td-quantity input").each(function () {
            let total = $(this).val();
            //console.log(total);
            if ($.isNumeric(total)) {
                total = parseFloat(total);
                hours += total;
                // console.log(total);
            }
            hours = php_round(hours, 3);

        });

        //hours = php_round(hours, 2);
        $("#t-quantity mark").html(hours);
        $("#grand-quantity").val(result.grand_quantity);

        setTotalTotals();
        return sum;
    }
    function setTotalTotals() {
        let vat_coeff = parseFloat($("#t-vatcoeff input").val());
        let vat_percent = vat_coeff;

        vat_coeff /= 100;
        let total = parseFloat($("#t-total").text());
        total = php_round(total, 2);
        let vat_sum = parseFloat((total * vat_coeff).toFixed(2));
        vat_sum = php_round(vat_sum, 2);
        total += vat_sum;
        total = php_round(total, 2);
        $("#t-vatsum").html(vat_sum);
        $("#t-totalvat").html(total);
        $("#grand-vatsum").val(vat_sum);
        $("#grand-totalvat").val(total);

        return vat_percent;
    }
    function set_zero_data() {

        $(project_current).val(null).trigger('change');
        $(user_current).val(null).trigger('change');
        $(artikul_current).val(null).trigger('change');

        $(tid_current).val('');
        $(task_current).val('');
        $(tasknl_current).val('');

        $(quantityplan_current).val('0');
        $(quantity_current).val('0');
        $(price_current).val('0');
        $(total_current).val('0');
    }

    // + --------------- End of Update item       ------------------- + //

    function setStatus() {
        let a_art = $('#grid-items .td-artikul');
        let status = not_submitted;
        if(a_art.length) {
            a_art.each(function(){
                $art = $(this).find('select').val();
                if($art === "") {
                    status = not_ready;
                }
            });
        } else {
            status = not_ready;
        }
        if(status === not_submitted) {
            status_bl = `<span class="frame-rounded status_yellow">Status: <b>${status}</b></span>`;
            $('#save-submit').removeAttr("disabled");
        } else {
            status_bl = `<span class="frame-rounded status_red">Status: <b>${status}</b></span>`;
            $('#save-submit').prop("disabled","disabled");
        }
        $('#status-doc').html(status_bl);
    }
    // + --------------- end of Add item ------------- + //
});  
// end ready function
//1289052(3)->644526->322262(3)->161130(1)->8564(5) 4282 2140(1) 170 84(5) 42 20(1) 10 4(5) 2 1
//           101010101011101
</script>

