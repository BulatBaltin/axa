<div class='page_wrap'>

    <? $form_view->start() ?>

    <div class='row mb-4'>

        <a href="<?path('qv.t-time.index')?>" class="vertical_align_center col-md-4">
        <h2> <?l($Title) ?> </h2>
        </a>

        <div class="col-md-4 mb-3"  style="padding:0;">
        <span style="padding:10px 0;border-bottom:1px solid lightgrey;"><? l('Last import time')?> : <strong style="color:grey;"><?=$timeStart ?></strong></span>
        </div>
    </div>

    <div class="mb-3 d-flex justify-content-between">
        <!-- select_no_search  -->
        <div class="hide_on_mobile" style='width:400px;'>
            <select class="actions form-control">
                <option value=""><?l('Actions') ?></option>
                <option value="add-invoices"><? l('Create new invoices')?></option>
                <option value="add-hours-to-one"><? l('Add hours to selected invoice')?></option>
                <option value="add-hours"><? l('Add hours to existing auto-invoices')?></option>
                <option value="non-billable"><? l('Mark hours as non-billable')?></option>
                <option value="feedback"><? l('Ask feedback for selected hours *')?></option>
                <option value="remove"><? l('Remove selected hours')?></option>
                <option value="import"><? l('Import hours from Time Tracking App')?></option>
            </select>
        </div>    

        <a class="modify_rules btn green_btn transparent_btn" href="<?path('rules.index')?>">
            <?l('Modify Import rules') ?>
            <svg class="edit_icon">
                <use xlink:href="/images/icons/sprite.svg#edit"></use>
            </svg>
        </a>
    </div>
    <div class="table_actions d-flex ">
        <div style='margin-right:10px;'>
            <span><? l('Hours tags') ?>:</span>
            <? if ($form_view->tag): // value ?> 
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>
            <!-- class='select_no_search'  -->
            <div id ="pick-tag" style='width:150px;<?=$border?>'>
                <? $form_view->widget('tag') ?>
            </div>
        </div>
        <div style='margin-right:10px;'>
            <span><? l('Period') ?>:</span>
            <? if ($form_view->period): ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>
            <? if ($sincedate): ?>
                <?  $period_display = 'none';
                    $sincedate_display = 'block';
                    $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else :?>
                <? $period_display = 'block' ?>
                <? $sincedate_display = 'none' ?>
            <? endif ?>

            <!-- class='select_no_search'  -->
            <div id ="pick-period" style='display:<?=$period_display?>;width:150px;<?=$border?>'>
                <? $form_view->widget('period') ?>
            </div>
            <div style="display: inline;">
            <div style="display:<?=$sincedate_display?>;width:200px;<?=$border?>" id ="pick-since-date">
                <div style="display:flex;">
                <div style="width:110px;">
                <? $form_view->widget('sincedate') ?>
                </div>
                <button id='go-date' class="btn transparent_btn" style='height:38px;width:30px;padding:0 0;margin-left:5px;'>
                <svg style="fill:white;height:16;width:16;vertical-align: unset;">
            <use xlink:href="/images/icons/sprite2.svg#filter-solid"></use>
                </svg>
                </button>
                <button id='go-period' class="btn transparent_btn" style='height:38px;width:30px;padding:0 0;margin-left:5px;'>
                <svg style="fill:white;height:16;width:16;vertical-align: unset;">
            <use xlink:href="/images/icons/sprite2.svg#calendar-days-solid"></use>
                </svg>
                </button>
                </div>

            </div>
            </div>
        </div>
        <div style='margin-right:10px;'>
            <span><? l('Task list') ?>:</span>
            <? if ($form_view->tasklist): ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-project" class="custom_select" style='width:200px;<?=$border?>'>
                <? $form_view->widget('tasklist') ?>
            </span>
        </div>
        <div style='margin-right:10px;'>
            <span><? l('Customer') ?>:</span>
            <? if ($form_view->customer): ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-customer" class="custom_select" style='width:200px;<?=$border?>'>
                <? $form_view->widget('customer') ?>
            </span>
        </div>
        <div style='margin-right:10px;'>
            <span><? l('Employee') ?>:</span>
            <? if ($form_view->user): ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-user" class="custom_select" style='width:200px;<?=$border?>'>
                <? $form_view->widget('user') ?>
            </span>
        </div>
        <div>
            <? if ($search_string): ?>
                <? $border = 'border:2px solid orange;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>

            <div class="search-box" style='<?=$border?>'>
                <input  type="search" id="search-go" name="search-fld" placeholder="<? l('Search tasks')?>" value="<?=$search_string ?>">
                <svg class="search_icon">
                    <use xlink:href="/images/icons/sprite.svg#search"></use>
                </svg>
            </div>
        </div>
    </div>
    <div id='mssg-spot' class="mt-2 mb-2">
        <? $form_view->errors() ?>
    </div>

    <table id="draft-items" class="full_width fully_mobile mb-4 mt-4">
        <thead>
            <tr class="tr-header">
                <th class='p-0' width="5%">
                    <div class='round-spot' id="i-markall">
                        <i class="far fa-square tb-check-icon"></i>
                    </div>
                    <div hidden>
                        <? $form_view->widget('CheckButton') ?>
                        <? $form_view->widget('UncheckButton') ?>
                    </div>
                </th>
                <th width="100px"><? l('Date') ?><br><span style="color:darkblue;font-size:10px;"><? l('rec ID') ?></span></th>
                <th width="150px"><? l('Task list') ?></th>
                <th width="200px"><? l('Customer') ?><br><span style="color:darkblue;font-size:10px;"><? l('Invoice') ?></span></th>
                <th width="150px"><? l('Employee') ?></th>
                <th><? l('Task description') ?></th>
                <!-- <th hidden><? l('Product Name') ?></th> -->
                <th width="80px">
                    <? l('Hours') ?><br>
                    <button id="items_hours_sum" title="<? l('Total of the page') ?>" name="round-items-sum" type="button" class="calculate_btn btn copy-dn mt-2" height='30px'>
                        <svg class="calculate_icon" style="margin:auto;">
                            <use xlink:href="/images/icons/sprite.svg#calculate"></use>
                        </svg>
                    </button>
                    <div id="total-hours"></div>
                </th>
                <th width="80px">
                    <small><b><? l('init hours') ?></b></small>
                    <button id="items_hours_sum_init" title="<? l('Total of the page') ?>" name="hours-items-sum-init" type="button" class="calculate_btn btn copy-dn mt-2" height='30px'>
                        <svg class="calculate_icon" style="margin:auto;">
                            <use xlink:href="/images/icons/sprite.svg#calculate"></use>
                        </svg>
                    </button>
                    <div id="total-hours-init"></div>
                </th>
                <th width="100px">
                    <small><b><? l('Non-billable') ?></b></small>
                    <button id="items_hours_non_billable" title="<? l('Total of the page') ?>" name="hours-items-non-billable" type="button" class="calculate_btn btn copy-dn mt-2" height='30px'>
                        <svg class="calculate_icon" style="margin:auto;">
                            <use xlink:href="/images/icons/sprite.svg#calculate"></use>
                        </svg>
                    </button>
                    <div id="total-hours-non-billable"></div>

                </th>
                <th hidden>Price</th>
                <th hidden >Total</th>
            </tr>
        </thead>
        <tbody>
        <?  $inx = 0;
            $datarows = $form_view->rows;
         ?>
        <? foreach( $datarows as $one_row ): ?>
            <? $one_item = $listInvoices[ $inx ] ?>
            <? if ($one_item['invoice_id'] == null): ?>
                <? $bkgrnd = '' ?>
                <? $status = '' ?>
                <? $title = '' ?>
                <? $anchor = '#1f00ac' ?>

            <? elseif ($one_item['invoice_status'] == 'submitted'): ?>
                <? $bkgrnd = 'background: green; color:white;' ?>
                <? $anchor = 'lightgreen' ?>
                <? $status = 'fas fa-check-double' ?>
                <? $title = 'Submitted invoice' ?>
            <? else :?>
                <? $bkgrnd = 'background: grey; color:white;' ?>
                <? $anchor = 'lightblue' ?>
                <? $status = 'fas fa-wrench' ?>
                <? $title = 'Not submitted' ?>
            <? endif ?>

            <tr style="<?=$bkgrnd ?>" class="tr-data" data-customer_id=<?=$one_item[ 'customer_id']?>>

                <td class='p-0 hide_on_mobile cell-mark'>
                    <? if ($status): ?>
                        <div>
                        <i class="<?=$status ?>" title="<?=$title ?>"></i>
                        </div>
                    <? endif ?>
                    <span class=
                "td-mark"
                >
                <div style="display: inline-flex;">

                <? if ($one_item['invoice_id'] == null): ?>
                    <div class='round-spot'>
                        <i data-id="<?=$one_item['id']?>" class= "i-mark far fa-square tb-check-icon"
                        ></i>
                    </div>
                    <? if ($one_item['status'] == 'removed'): ?>
                        <div style="color:green;">
                            <i class="far fa-hand-point-left ml-1 mt-2"></i>
                        </div>
                    <? endif ?>
                <? endif ?>
                <? if ($one_item['completed'] == '1'): ?>
                    <div style="color:#FF7D4F;">
                        <i class="fas fa-lock mt-2 ml-1" title='Completed task'></i>
                    </div>
                <? endif ?>
                </div>

                </span>
                </td>
                <td>
                    <div class="table_label_mobile"><? l('Date') ?></div><small>
                    <?=date('d/m/Y', strtotime($one_item['period'] ?? '')) ?><br><?=$one_item['id'] ?></small>
                </td>

                <? if ($one_item[ 'project_id']): ?>
                <td class="td-project" id="project<?=$one_item['id']?>" data-project-id=<?=$one_item['project_id']?> data-project-name=<?=$one_item[ 'project_id']?>>
                    <div class="table_label_mobile"><? l('Task list') ?></div>
                    <?=$one_item[ 'tasklist'] ?>
                </td>
                <? else :?>
                <td class="td-project" id="project<?=$one_item['id']?>" data-project-id="0">
                    <div class="table_label_mobile"><? l('Task list') ?></div>
                    <?=$one_item[ 'tasklist'] ?>
                </td>
                <? endif ?>

                <td class="td-customer" data-href="<?path('qv.t-time.update.customer',['id' => $one_item['id']])?>" data-id="<?=$one_item['id']?>" id="customer<?=$one_item['id']?>">
                    <div class="table_label_mobile"><? l('Customer') ?></div>
                    <div class="mobile_full_width">
                        <div class="custom_select">
                        <? if ($one_item['invoice_id'] == null): ?>
                            <? $one_row->widget('customer_id') ?>
                        <? else : ?>
                            <?=$one_item[ 'customer_name'] ?><br>
                        <a class='row-href' target="_blank" href="<?path('zinvoice.edit', [ 'id' => $one_item['invoice_id']])?>" style="color: <?=$anchor ?>;">
                            <small><?=$one_item['invoice_id'] ?></small>
                        </a>
                        <? endif ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="table_label_mobile"><? l('Employee') ?></div>
                    <?=$one_item['user_name'] ?>
                </td>
                <td class="td-tasknl" data-id="<?=$one_item['id']?>">
                    <div class="table_label_mobile"><? l('Task description') ?></div>
                    <div>
                        <? if ($one_item['invoice_id'] == null): ?>
                            <? $one_row->widget('tasknl')?>
                        <? else : ?>
                            <?=$one_item['tasknl'] ?><br>
                        <? endif ?>

                    <? if ($site_root and $one_item['tid']): ?>
                        <a class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$one_item['tid']?>" style="color: <?=$anchor ?>;">(#<?=$one_item['tid']?>)&nbsp;
                        <?=$one_item['task'] ?>
                        </a>
                    <? else : ?>
                        <?=$one_item['task'] ?>
                    <? endif ?>
                    </div>
                </td>
                <td id="quantity<?=$one_item['id']?>">
                    <div class="table_label_mobile"><? l('Hours') ?></div>
                    <span class="td-quantity"><?=$one_item['quantity'] ?></span>
                </td>
                <td>
                    <div class="table_label_mobile"><? l('Hours (init)') ?></div>
                    <span id="quantity-init<?=$one_item['id']?>" class="td-quantity-init"><?=$one_item['quantityplan'] ?></span>
                </td>
                <td class="quantity-non-billable" data-id="<?=$one_item['id']?>">
                    <div class="table_label_mobile"><? l('Non-billable') ?></div>
                    <? if ($one_item['invoice_id'] == null): ?>
                        <? $one_row->widget('quantitylost') ?>
                    <? else : ?>
                        <?=$one_item['quantitylost'] ?>
                    <? endif ?>
                    <span id="quantity-non-billable<?=$one_item['id']?>" hidden class="td-quantity-non-billable"><?=$one_item['quantitylost'] ?></span>
                </td>
                <td hidden id="price<?=$one_item['id']?>"><?=$one_item['price'] ?></td>
                <td hidden id="total<?=$one_item['id']?>"><?=$one_item['total'] ?></td>
            </tr>
            <? $inx++ ?>
        <? endforeach ?>
        </tbody>
    </table>

    <div hidden>
        <? $form_view->rest() ?>
    </div>    

    <? $form_view->end() ?>

    <? include( DMIGHT.'template/pagination.html.php') ?>

    <div class="mt-4 select_no_search hide_on_mobile">
        <select id="actions" class="p-2 form-control">
            <option value=""><? l('Actions') ?></option>
            <option value="add-invoices"><? l('Create new invoices')?></option>
            <option value="add-hours-to-one"><? l('Add hours to selected invoice')?></option>
            <option value="add-hours"><? l('Add hours to existing auto-invoices')?></option>
            <option value="non-billable"><? l('Mark hours as non-billable')?></option>
            <option value="feedback"><? l('Ask feedback for selected hours *')?></option>
            <option value="remove"><? l('Remove selected hours')?></option>
            <option value="import"><? l('Import hours from Time Tracking App')?></option>
        </select>
    </div>    

    <div id='mssg-box' style="padding: 1rem 0;"></div>
    <div class="p-4"></div>
</div>
<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">

/// Attn: the identifiers are taken from actual page
    var select_val;
    var trigger_val = true;

    const select_tag_id     = '#select_tag_id';
    const select_period     = "#select_period_id";
    const select_project    = "#select_tasklist_id";
    const select_customer   = "#select_customer_id";
    const select_user       = "#select_user_id";
    const select_invoice    = "#z_invoice_hours_invoice";

    const select_filter = "#select_tag_id,#search-go,#select_customer_id,#select_user_id,#select_tasklist_id";

    <? include('js/toolskit/funcs.js') ?>
    <? include('js/toolskit/marks.js') ?>

    $(document).ready(function(){

        initSelect2();
        // $('.custom_select select').select2();
        // $('.custom_select_wrap select').select2();
        // $('.select_no_search select').select2({
        //     minimumResultsForSearch: -1
        // });

        $('#items_hours_sum').on('click', function(event){ //change((event)=> {
            let ahours = $('.td-quantity');
            let total = 0;
            $.each(ahours, function(ix, xvalue){
                total += parseFloat($(xvalue).text());
            });
            $('#total-hours').html('<div style="margin-top:0.4rem;">'+total.toFixed(3)+'</div>');
            return false;
        });
        $('#items_hours_sum_init').on('click', function(event){ //change((event)=> {
            let ahours = $('.td-quantity-init');
            let total = 0;
            $.each(ahours, function(ix, xvalue){
                total += parseFloat($(xvalue).text());
            });
            $('#total-hours-init').html('<div style="margin-top:0.4rem;">'+total.toFixed(3)+'</div>');
            return false;
        });
        $('#items_hours_non_billable').on('click', function(event){ //change((event)=> {
            let ahours = $('.td-quantity-non-billable');
            let total = 0;
            $.each(ahours, function(ix, xvalue){
                total += parseFloat($(xvalue).text());
            });
            $('#total-hours-non-billable').html('<div style="margin-top:0.4rem;">'+total.toFixed(3)+'</div>');
            return false;
        });

        function ShowResultBox(result) {
            $('#mssg-box').html(result.mssg);
            setTimeout(function(){
                if(result.return == 'success') {
                    window.location.href = "<? path('qv.t-time.index') ?>";                            
                } else {
                    $('#mssg-box').html('');
                }
            }, 4000);
        }

        function onAddCreateInvoices(action) {
            ShowProcess();

            var cfilter     = $('#pick-customer select').val();
            var isrounded   = $('#isrounded input[type="checkbox"]').prop("checked");
            var iscreated   = $('#iscreated input[type="checkbox"]').prop("checked");
            var id_invoice  = $('#pick-invoice select').val();
            var id_list = getCheckedEntries( cfilter );
            let url = "<? path('qv.t-time.makeinvoices') ?>";
// alert(cfilter+'; '+isrounded+', '+iscreated+'; '+id_invoice+'# '+id_list+', '+action);
            $.ajax({ method: "POST", url: url, dataType: 'json',
                data: { 
                    action:     action, 
                    id_list:    id_list, 
                    isrounded:  isrounded, 
                    iscreated:  iscreated, 
                    id_invoice: id_invoice
                },
                success: function (result) {
                    if(result.return == 'error') {
                        $('#mssg-spot').html(result.mssg);
                    } else {
                        window.location.href = result.invoice;     
                    }
                    // showReturn(result, function(){
                    // } );  
                    // alert(result.invoice);
                }
            }); 

        }
        function onMarkNonBillable( list ) {
            ShowProcess();

            $.ajax({ method: "POST", url: "<? path('qv.t-time.mark-non-billable') ?>", dataType: 'json',
                data: { 
                    id_list: list
                },
                success: function (result) {
                    if(result.return == 'error') {
                        dmInfoDialog({ title: "<? l('Error')?>", text: result.mssg });
                    } else {
                        window.location.href = "<? path('qv.t-time.index') ?>";                            
                    }
                }
            }); 
        }

        $('.actions').change(function(){
            var action = $(this).find('option:selected').val();
            var list = "";

            $(this).val('');

            $('.i-mark').each(function(){
                if($(this).hasClass('fa-check-square')) {
                    let id = $(this).data('id');
                    list += id+',';
                }
            });

// alert('list='+list);

            if(list !== "" && (action == 'add-invoices' || action == 'add-hours') ) {

                dmDialog({
                    title: 'Quickvoice',
                    text: '<? l("Confirm invoice creation/update on selected items")?>',
                    ok: function() {
                        onAddCreateInvoices(action);
                    }
                });
                return false;

            } else if(list !== "" && (action == 'non-billable') ) {
                dmDialog({
                    title: 'Non-billable hours',
                    text: '<? l("Mark hours as non-billable for selected items")?>',
                    ok: function() {
                        onMarkNonBillable(list);
                    }
                });
                return false;

            } else if(list !== "" && (action == 'add-hours-to-one') ) {
// alert('add-hours-to-one', list );
                $.ajax({ method: "POST", url: "<? path('qv.t-time.get-invoices') ?>", dataType: 'json',
                    data: { id_list: list },
                    success: function (result) {
                        if(result.return == 'success') {
                            dmDialog({
                                title: 'Select invoice to add hours to',
                                text: result.html,
                                load: function() { 
                                    $('#dlg-pick-customer').focus();
                                },
                                ok: function() {
                                    let id_invoice = $('#invoice-list option:selected').val();
                                    // ShowProcess();
                                    $.ajax({ method: "POST", url: "<? path('qv.t-time.makeinvoices') ?>", dataType: 'json',
                                        data: { 
                                            action: 'add-hours', 
                                            id_list: list, 
                                            id_invoice: id_invoice
                                        },
                                        success: function (result) {
                                            window.location.href = result.invoice;     
                                        }
                                    }); 
                                }
                            });
                        } else {
                            dmInfoDialog({
                                title: "Invoices empty list",
                                text: result.mssg
                            });
                        }
                    }
                }); 
                return false;

            } else if(list !== "" && action == 'remove') { // DELETE RECORDS
                dmDialog(
                    {
                        title: "<? l('Remove hours')?>",
                        text: '<? l("Confirm removal of selected hours entries")?>',
                        ok: function() {
                            ShowProcess();

                            $.ajax({ method: "POST", url: "<? path('qv.t-time.deletelist') ?>", dataType: 'json',
                                data: { hourslist: list },
                                success: function (result) {
                                    HideProcess();
                                    ShowResultBox(result);                        
                                }
                            }); 

                        }
                    }
                );

                return false;

            } else if(action == 'import') {
                dmDialog(
                    {
                        title: "<? l('Import hours')?>",
                        text: '<? l("Confirm import hours from Time Tracking App")?>',
                        ok: function() {
                            ShowProcess();
                            $.ajax({ method: "POST", url: "<? path('qv.t-time.import') ?>", dataType: 'json',
                                success: function (result) {
                                    HideProcess();
                                    showReturn(result, function(){
                                    window.location.href = "<? path('qv.t-time.index') ?>";     
                                    } );  
                                }
                            }); 

                        }
                    }
                );
                return false;
            }
            return false;
        });

        function getCheckedEntries( cfilter ) {
            var list = '';
            // var list2 = '';
            var checked = false;
            $('.tr-data').each( function(){
                if( cfilter == '0' || $(this).find('.td-customer select').val() == cfilter ) {
                    checked = $(this).find('.i-mark').hasClass('fa-check-square');
// list2 += 'checked='+checked+';';                    
                    if(checked) {
                        list += $(this).find('.i-mark').data('id')+',';
                    }
                }
            });
// alert('list(*)='+list+'; filter='+cfilter+'; list2='+list2);
            return list;
        }

        $('.td-tasknl').change(function(){
            var url_path = "<?path('qv.t-time.change.tasknl')?>";
            var data_id = $(this).data('id');
            var task_nl = $(this).find('input').val();

            // alert("Boom: "+data_id+"  "+task_nl);
            $.ajax({
                type: "POST", 
                url: url_path,
                dataType: 'json',
                data: {
                    data_id: data_id,
                    task_nl: task_nl
                },
                success: function (result) {
                    showResult(result, function(){} );  
                }
            }); 

        });
        $('.quantity-non-billable').change(function(){
            var url_path = "<?path('qv.t-time.change.nonebill')?>";
            var data_id = $(this).data('id');
            var nonebill_input = $(this).find('input');
            var nonebill = $(this).find('input').val();
            var maxi = $('#quantity-init'+data_id).text();
            $.ajax({
                type: "POST", 
                url: url_path,
                dataType: 'json',
                data: {
                    data_id: data_id,
                    maxi: maxi,
                    nonebill: nonebill
                },
                success: function (result) {
                    if(result.return == 'success') {
                        $(nonebill_input).val(result.nonebill);
                        $('#quantity-non-billable'+data_id).text(result.nonebill);
                    }
                }
            }); 

        });

        $('#go-period').click(function(event){
            $('#pick-since-date').hide();
            $('#pick-period').show();
            $(select_period).val(''); 
            goFilters();
            return false;
        });
        $('#go-date').click(function(event){
            goFilters();
            return false;
        });

        $(select_period).change( function(event){
            // alert('HERE');
            let period = $(select_period).val(); 
            if(period == 'since-date') {
                $('#pick-period').hide();
                $('#pick-since-date').show();
            } else {
                goFilters();
            }
            return true;
        });    
        $(select_filter).change( function(event){
            // alert('TAG');
            goFilters();
            return true;
        });    

        $('#search-go').on('keypress',function(e) {
            if(e.which == 13) {
                goFilters();
                return false;
            }
        });        

        function goFilters() {
            let tag = $(select_tag_id).val(); 
            var invoice_id = $(select_invoice).val(); 
            var customer_id = $(select_customer).val(); 
            var user_id = $(select_user).val(); 
            var project_id = $(select_project).val(); 
            var sincedate;
            var period;
            if ($('#pick-since-date').css('display') == 'none') {
                // {# alert('HERE-1'); #}
                sincedate = ''; 
                period = $(select_period).val(); 
            } else {
                // {# alert('HERE-2'); #}
                sincedate = $('#z_invoice_hours_sincedate').val(); 
                period = '';
            }

            var search = $('#search-go').val(); 

            if(tag == 'N') tag = ''; // default behavour - not invoiced

            let url;
            if(!tag && !period && !sincedate && !project_id && !user_id && !customer_id && !search) {
                url = "<? path('qv.t-time.xindex')?>";
                // alert(url+ ' '+ tag )
            }  else {
            <? // if(isset($autoescape) and $autoescape == 'js'): ?>
                url = "<? path('qv.t-time.filter', ['tag' =>'p-tag', 'search'=>'p-search', 'period' =>'p-period', 'sincedate'=>'p-sincedate', 'customer_id' => 'p-customer_id', 'project_id' =>'p-project_id', 'user_id' => 'p-user_id', 'page' => 1]) ?>";
            <? // endif ?>  
            // alert(url);
                url = removeEmptyParts(url, 
                ['tag','search','period','sincedate', 'customer_id', 'project_id', 'user_id'], 
                [ tag, search, period, sincedate, customer_id, project_id, user_id]);

                url = url.replace('p-tag', tag); 
                url = url.replace('p-search', search); 
                url = url.replace('p-period', period); 
                url = url.replace('p-sincedate', sincedate); 
                url = url.replace('p-project_id', project_id); 
                url = url.replace('p-user_id', user_id); 
                url = url.replace('p-customer_id', customer_id); 
            // alert(url);
            }

            window.location.href = url;                            
        }
        // #customer
        $('#draft-items').on('click', '.td-customer', function(event){
            select_val = $(this).find('select').val();
        });
        $('#draft-items').on('change', '.td-customer', function(event){
            if(trigger_val == false) {
                trigger_val = true;
                return false;
            }
            var data_id = $(this).data('id');
            var url_path = $(this).data('href');
            var selectBox = $(this).find('select');
            var customer_name = event.target.selectedOptions[0].label;            
            var customer_id = event.target.selectedOptions[0].value;            
            var project_id = $("#project"+data_id).data('project-id');
            var project_name = $("#project"+data_id).data('project-name');

            dmDialog({
                title: "<? l('Link a customer to the project') ?>",
                text: "<? l('Link globally a customer to the project') ?><br>"+
                "<? l('Customer')?> : " + customer_name + "<br>"+"<? l('Project')?>: " + project_name,
                ok: function () {
                    onLinkProj2Client(data_id, project_id,  customer_id, url_path);
                },
                cancel: function () {
                    trigger_val = false;
                    $(selectBox).val(select_val).change();
                }
            });
            return false;
        });

        function onLinkProj2Client(data_id, project_id,  customer_id, url_path) {
            if(project_id !== '0') {
                var back_uri = window.location.href;
                mapToProject(customer_id, project_id);           
                ShowProcess();
                $.ajax({
                    type: "POST", 
                    url: url_path,
                    dataType: 'json',
                    data: {
                        item_id: data_id,
                        customer_id: customer_id,
                        project_id: project_id
                    },
                    success: function (result) { // alert('Back fire');
                        window.location.href = back_uri;
                    }
                });
            }
            return false;
        }

        $('#draft-items').on('change', '.td-artikul', function(event){ //change((event)=> {

            let data_id = event.target.parentElement.dataset.id; // Ok
            let product_v = event.target.selectedOptions[0].value;
            let product_l = event.target.selectedOptions[0].label;            

            set_rate_total(data_id, product_l);
            return false;
        });
        // + ------------------------------ // Delete // ---------------------- +
        $('#grid-hours').on("click", ".row-delete", function(event){
            const atom_id = $(this).data("id");
            const atom_name = $("#name"+atom_id).text();
            const url_path = $(this).data('href');
            const csrf_token = $("#csrf_token"+atom_id).val();
            dmDialog(
                {
                    title: "<? l('Delete the object') ?>",
                    text: '<? l("Are you sure you want to delete this object?")?>'+"<br>"+"id/<? l('name') ?>",
                    ok: function() {
                        ShowProcess();
                        $.post(url_path, {
                                _token: csrf_token
                            }, function (result) {
                                showResult( result, function(){
                                    $("#rec"+atom_id).remove();
                                    });    
                            },'json');
                    }
                }
            );
            return false;
        });

    }); // end document ready

// + -------------------------- Service functions ---------------------- +
    function mapToProject (customer_id, project_id) {
        $(".tr-data").each(function(){
            let curr_customer = $(this).find('.td-customer select').val();
            let curr_project = $(this).find('.td-project').data("project-id");
            if (curr_project == project_id) {
                if(customer_id == "") {
                    $(this).find('.td-mark').addClass('visible-no');
                    $(this).find('.td-mark').find('input[type="checkbox"]').prop("checked", false);
                } else {
                    $(this).find('.td-mark').removeClass('visible-no');
                    $(this).find('.td-mark').find('input[type="checkbox"]').prop("checked", true);
                }
                if(curr_customer !== customer_id) {
                    $(this).find('.td-customer select').val(customer_id);
                    //alert("(x): Customer: "+customer_id+"  Project: "+project_id);
                }
            }
        });
    }

    function set_marks_to( xbool ){
        $(".td-mark").each(function(){
            $(this).find('input[type="checkbox"]').prop("checked", xbool);
        });
    }

    function updateCustomerChoice( customer_id ){
        $('#pick-customer select').val(customer_id).change();
    }
    function updateInvoiceChoice0( invoice_id ){
        $('#pick-invoice select').val(invoice_id).change();
    }
    function updateInvoiceChoice(values, labels){
        let pickup = $('#pick-invoice select');
        let first = $(pickup).find('option:first');

        let vals = values.split(';');
        let labs = labels.split(';');
        let i = 0;

        $(pickup).empty();
        $(pickup).append(first);
        vals.forEach( value => {
            if(labs[i] !== ""){
                let opt = '<option value="'+value+'">'+labs[i]+'</option>';
                $(pickup).append(opt);
            }
            i++;
        }
        );
        $(pickup).find('option:last').attr("selected","selected");
    }

    function showRowsFilter2( cFilter ){
        $(".tr-data").each(function(){
            if(cFilter == "" || $(this).data("customer_id") == cFilter){
                $(this).show();
            }
            else{
                $(this).hide();
            }
        });
    }
    function showRowsFilter( cFilter ) {
        // I dont use it so far ... but the code is useful ;)
        var rows = $('#draft-items > tbody > tr');
        rows.each( function(){
            let option = $(this).find('td select option:selected').text();
            if (option.includes(cFilter)) {
                $(this).removeAttr('hidden');
            } else {
                $(this).attr('hidden', 'hidden');
            }
        });
    }

    function showResult( result, successFunc){
        $("#notes").removeClass("red-box");
        $("#notes").removeClass("green-box");
        $("#notes").addClass("visible-yes");

        if(result["success"]){
            $("#notes").addClass("green-box");
            $("#notes").html(result['success']);
            // alert('(1) success ' + result['success']);

            successFunc();

        }
        else if(result["error"]){
            $("#notes").addClass("red-box");
            $("#notes").html(result['error']);
        }
    }
    function set_rate_total(data_id, artikul) {
        var url_path = "<?path('qv.t-time.itemsplan.totals')?>";
        var id_quantity = "#quantity"+data_id;
        let quantity = $(id_quantity).html();
        var id_price = "#price"+data_id;
        var id_total = "#total"+data_id;

        $.ajax({
            type: "POST", 
            url: url_path,
            dataType: 'json',
            data: {
                item_id: data_id,
                artikul: artikul,
                quantity: quantity,
            },
            success: function (result) { // alert('Back fire');
                // alert(result.mssg);
                $(id_price).html( result.price);
                $(id_total).html("<mark>"+result.total+"</mark>");
            }
        });
    }
    </script>
