<div class='page_wrap'>

    <? $form->start() ?>
    <div>
        <? $form->errors() ?>
    </div>

    <div class='row mb-4'>

        <a href="<?path('qv.invoice.index')?>" class="vertical_align_center col-md-4">
        <h2> <?l($Title) ?> </h2>
        </a>
        <div class="col-md-4 mb-3"  style="padding:0;">
        <span style="padding:10px 0;border-bottom:1px solid lightgrey;"><? l('Last invoice created at')?> : <strong style="color:grey;"><?=$timeInvoice ?></strong></span>
        </div>
    </div>
    <div class="table_actions d-flex ">
        <div style='margin-right:10px;'>
            <span><? l('Invoice tags') ?>:</span>
            <? if ($form->tag): ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else : ?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-tag" style='width:150px;<?=$border?>'>
                <? $form->widget('tag') ?>
            </span>
        </div>
        <div style='margin-right:10px;'>
            <span><? l('Period') ?>:</span>
            <? if ($form->period): ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else : ?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-period" style='width:150px;<?=$border?>'>
                <? $form->widget('period') ?>
            </span>
        </div>

        <div>
            <span><? l('Status') ?>:</span>
            <? if ($form->status): ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else : ?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-status" style='<?=$border?>'>
                <? $form->widget('status')?>
            </span>
        </div>
        <div>
            <span><? l('Customer') ?>:</span>
            <? if ($form->customer): ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else : ?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-customer" class="custom_select" style='width:300px;<?=$border?>'><?$form->widget('customer')?></span>
        </div>
        <div>
            <? if ($search_string): ?>
                <? $border = 'border:2px solid orange;border-radius:4px;' ?>
            <? else : ?>
                <? $border = '' ?>
            <? endif ?>
            <div class="search-box" style='<?=$border?>'>
                <input  type="search" id="search-go" name="search-fld" placeholder="<? l('Search string') ?>" value="<?=$search_string ?>">
                <svg class="search_icon" id='go-search'>
                    <use xlink:href="/images/icons/sprite.svg#search"></use>
                </svg>
            </div>
        </div>
    </div>

    <div id="tb-box">
        <? include('include/t-body-index.html.php') ?>
    </div>

    <div hidden>
        <? $form->rest() ?>
    </div>          
    <? $form->end() ?>

    <div class="mt-4 form-group hide_on_mobile">
        <select id="actions" class="p-2 form-control">
            <option value=""><i class="fas fa-angle-double-right mr-2"></i><? l('Actions')?></option>
            <option value="create"><? l('Create a new invoice') ?></option>
            <option value="submit"><? l('Submit the checked to Accounting software') ?></option>
            <option value="archive"><? l('Archive the checked') ?></option>
            <option value="unarchive"><? l('Unarchive the checked') ?></option>
            <option value="mark-del"><? l('Set `deleted` to the checked') ?></option>
            <option value="mark-undel"><? l('Unset `deleted` to the checked') ?></option>
            <option value="remove"><? l('Remove checked invoices')?></option>
        </select>
    </div> 
    <div id='mssg-box' style="padding: 1rem 0;"></div>
</div> 
    
<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript"> 
        
    <? include('js/toolskit/funcs.js') ?>
    <? include('js/toolskit/marks.js') ?>

    $(document).ready(function(){

        initSelect2();

        <? include('js/toolskit/invoice-drag-drop.js') ?>

        function getCheckedEntries( cfilter ) {
            var list = '';
            var checked = false;
            $('.tr-data').each( function(){
                if( cfilter == '' || $(this).find('#customer'+cfilter) ) {
                    checked = $(this).find('.i-mark').hasClass('fa-check-square');
                    if(checked) {
                        list += $(this).find('.i-mark').data('id')+',';
                    }
                }
            });
            return list;
        }
        $('#refresh').on('click', function(){ submitToAccounting(); });

        $('#actions').change(function(){
            var action = $('#actions option:selected').val();
            $('#actions').val('');

            if(action == 'submit') submitToAccounting();
            else if(action == 'remove') deleteInvoices();
            else if(action == 'create') createNewInvoice();
            else if(action == 'archive' || action == 'unarchive') createArchive(action);
            else if(action == 'mark-del' || action == 'mark-undel') createMarkDelete(action);
        });
        function createMarkDelete( action ){
            var invoices = getCheckedEntries('');
            if(invoices) {
                dmDialog({
                    title: 'Invoice Mark deleted',
                    text: "<? l('Set checked invoices as deleted / undeleted (active)?' )?>",
                    ok: function() { 
                        doCreateMarkDelete(action, invoices); 
                    }
                });
            } else {
                dmInfoDialog('No checked invoices');
            }
            return false;
        }
        function doCreateMarkDelete(action, invoices ) {
            ShowProcess();
            $.ajax({
                method: "POST", 
                url: "<? path('qv.invoice.markdel') ?>", dataType: 'json',
                data: { 
                    action: action,
                    invoices: invoices
                },
                success: function (result) { 
                    window.location.href = "<? path('qv.invoice.index') ?>";     
                }
            });
            return true;
        }
        function createArchive( action ){
            var invoices = getCheckedEntries('');
            if(invoices) {
                dmDialog({
                    title: 'Invoice Archive',
                    text: "<? l('Set checked invoices as archived / unarchived (active)?' )?>",
                    ok: function() { 
                        doCreateArchive(action, invoices); 
                    }
                });
            } else {
                dmInfoDialog('No checked invoices');
            }
            return false;
        }
        function doCreateArchive(action, invoices ) {
            ShowProcess();
            $.ajax({
                method: "POST", 
                url: "<? path('qv.invoice.archive') ?>", dataType: 'json',
                data: { 
                    action: action,
                    invoices: invoices
                },
                success: function (result) { 
                    window.location.href = "<? path('qv.invoice.index') ?>";     
                }
            });
            return true;
        }
        function createNewInvoice(){
            dmDialog({
                title: 'Quickvoice',
                text: "<? l('Create a new invoice?' )?>",
                ok: function() { 
                    doCreateNewInvoice(); 
                    }
            });
            return false;
        }
        function doCreateNewInvoice(){
            let customer_id = "<?=$form->customer?>";
        <? //autoescape 'js' ?>
            window.location.href = "<? path('qv.invoice.create',[ 'new'=> 'new', 'customer_id' => $form->customer ]) ?>";
        <? //endautoescape ?>            
            return true;
        }

        function submitToAccounting(){

            var cfilter = $('#pick-customer select').val();
            var invoices = getCheckedEntries( cfilter );
            if(invoices) {
                dmDialog({
                    title: "<? l('Submit invoices to Accounting system')?>",
                    text: "<? l('Invoices should have \'not submitted\' status')?>"+"<br>"+"<? l('One green mark!')?>",
                    ok: function() { doSubmitToAccounting( invoices ); }
                });
            }
        }
        function doSubmitToAccounting( invoices ) {
            ShowProcess();
            $.ajax({
                method: "POST", 
                url: "<? path('qv.invoice.submitlist') ?>", dataType: 'json',
                data: { 
                    invoices: invoices
                },
                success: function (result) { 
                    HideProcess();
                    ShowResult(result);
                }
            });
            return true;
        }
        function deleteInvoices(){
            var cfilter = $('#pick-customer select').val();
            var invoices = getCheckedEntries( cfilter );
            if(invoices) {
                dmDialog({
                    title: "<? l('Delete invoices')?>",
                    text:  "<? l('Are you sure you want to delete selected invoices?')?>",
                    ok: function() { doDeleteInvoices( invoices ); }
                });
            }
            return false;
        }
        function doDeleteInvoices( invoices ) {
            ShowProcess();
            $.ajax({
                method: "POST", url: "<? path('qv.invoice.deletelist') ?>", dataType: 'json',
                data: { 
                    invoices: invoices
                },
                success: function (result) { 
                    HideProcess();
                }
            });

            return true;
        }
        function delInvoice(invoice_id, url) {
            alert(invoice_id + ' '+ url);

            $.ajax({
                method: "POST", 
                url: url, 
                dataType: 'json',
                data: { 
                    invoice_id: invoice_id // it is not used
                },
                success: function (result) { 
                    $("#rec"+invoice_id).remove();
                }
            });

            // $.post(url, {
            //         invoice_id: invoice_id
            //     }, function (result) { // 
            //         $("#rec"+invoice_id).remove();
            //     },'json');
        }

        function ShowResult(result) {
            $('#mssg-box').html(result.mssg);
            setTimeout(function(){
                if(result.return == 'success') {
                    let prevUrl = window.location.href;
                    window.location.href = prevUrl; // your current as previous url/ just reload";                            
                } else {
                    $('#mssg-box').html('');
                }
            }, 2000);
        }

        $('.tr-data').on("click", ".do-submit", function (event) {
            const doc_num = $(this).data("num");
            const atom_id = $(this).data("id");
            const url_path = $(this).attr('href');
            dmDialog({
                title: "<? l('Submit invoice to Accounting system ?') ?>",
                text: "<? l('Invoice')?>" + "<br>ID: "+atom_id+"<br>No: "+doc_num,
                ok: function() { doSubmit1Invoice(atom_id, url_path); }
            });
            return false;
        });
        function doSubmit1Invoice( atom_id, url_path ) {
            ShowProcess();
            $.ajax({
                method: "POST", url: url_path, dataType: 'json',
                data: { 
                    data_id: atom_id // it is not used
                },
                success: function (result) { 
                    HideProcess();
                    ShowResult(result);
                }
            });
            return true;
        }

        $('.tr-data').on("click", ".del-btn", function (event) {
            const doc_num = $(this).data("num");
            const atom_id = $(this).data("id");
            const url_path = $(this).attr('href');
            dmDialog({
                title: "<? l('Delete invoice') ?>",
                text: "<? l('Are you sure you want to delete this invoice?') ?> <br>" + "ID: "+atom_id+"<br>No: "+doc_num,
                ok: function() { delInvoice(atom_id, url_path); }
            });
            return false;
        });

        $('#pick-customer').change( function(event){
            goFilters();
            return true;
        });
        $('#pick-status').change( function(event){
            goFilters();
            return true;
        });
        $('#pick-period').change( function(event){
            goFilters();
            return true;
        });
        $('#pick-tag').change( function(event){
            // alert('TAG');
            goFilters();
            return true;
        });
        $('#search-go').change(function(){
            goFilters();
            return false;
        });
        $('#search-go').on('keypress',function(e) {
            if(e.which == 13) {
                goFilters();
                return false;
            }
        });        
        function goFilters() {
            let tag = $('#pick-tag select').val(); 
           
            let period = $('#pick-period select').val(); 
            let customer_id = $('#pick-customer select').val(); 
            let status = $('#pick-status select').val(); 
            var lookfor = $('#search-go').val();
            let url;
            if(!customer_id && !status && !lookfor && !period && !tag) {
                url = "<? path('qv.invoice.index') ?>";
            } else {

            <? //autoescape 'js' ?>
                url = "<? path('qv.invoice.filter',['tag'=>'p_tag','period'=> 'p_period', 'search'=> 'p_search', 'customer_id'=> 'p_customer', 'status'=> 'p_status', 'page'=> 1]) ?>";
// alert(url);
            <? //endautoescape ?>            
                url = removeEmptyParts(url, ['tag','period','search','customer_id','status'], [tag,period,lookfor,customer_id,status]);
                url = url.replace('p_tag', tag); 
                url = url.replace('p_period', period); 
                url = url.replace('p_status', status); 
                url = url.replace('p_customer', customer_id); 
                url = url.replace('p_search', lookfor); 
            }
// alert(url);

            window.location.href = url;                            
        } 

        function onCustomerChange (cFilter, sfilter) {
            $(".tr-data").each(function(){
                if(
                    (cFilter == "" || $(this).data("customer-id") == cFilter) &&
                    (sfilter == "All" || $(this).data("status-id") == sfilter) 
                    ){
                    $(this).show();
                }
                else{
                    $(this).hide();
                }
            });
        }

    }); // end ready function
</script>

