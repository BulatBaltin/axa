<div class='page_wrap'>

    <h2 class="mb-3"><?l($Title) ?></h2>

    <div class="row mb-4">

        <div class="col-md-4">

            <? if (isset($index_host) and $index_host ): ?> 
                <? $url_back = $index_host ?>
            <? elseif( !($index_uri == '')) : ?> 
                <? $url_back = $index_uri ?>
            <? else: ?> 
                <? $url_back = path('qv.invoice.index') ?>
            <? endif ?>

            <? include_view(DMIGHT.'template/move-button.html.php', [
                'url_back'  => $url_back,
                'url_text'  => ll('Invoice list'),
                'title'     => ll('Back to invoice list page'),
                'url_class' => ''
                ]) ?>

            <? if (isset($hours_host) and $hours_host) : ?> 
                <? $url_back = $hours_host ?>
            <? elseif(!($hours_uri == '')) : ?> 
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
        <div class="col-md-3" style="padding:12px 15px;">
            ID: <b><?=$invoice['id'] ?> (<?=$invoice['doc_number']?>) </b>
            <a href="#" id="log-invoice" class="ml-3">
                <i class="fas fa-info-circle"></i>
            </a>

            <a title="<?l('Undo submit and make it editable again') ?>" href="#" id="undo-submit" class="ml-3">
                <i class="fas fa-undo"></i>
            </a>

            <? if ( $invoice['status1'] ): ?>
            <? $status = $invoice['status1'] ?>
            <? else :?>
            <? $status = 'auto'?>
            <? endif ?>
            <br><span><small>(<?=$status?>) <?=$invoice['period']?></small></span>
        </div>

        <div class="col-md-3" style="padding:12px 15px;"><? l('Client') ?>: <b><?=$invoice['customer_name'] ?></b></div>
        <div class="col-md-2">
            <span><?l('Invoice creation date')?>: <br><b><?= date('d/m/Y', strtotime($invoice['doc_date'])) ?></b></span>
        </div>

        <div class="col-md-2">
            <div class="mb-2 mt-2 pb-3">
                <span class="frame-rounded status_green"><? l('Status') ?>: <b><?=$invoice['status'] ?></b></span>
            </div>
        </div>
        <div class="col-md-2">
            <a class="pdf_link" target="_blank" href="<?=$invoice['urlpdfbestand'] ?>">
                <svg>
                    <use xlink:href="/images/icons/sprite.svg#pdf"></use>
                </svg>
                <?l('View pdf document') ?> <?=$invoice['factuurnummer'] ?>
            </a>
        </div>
    </div>

    <div>
        <table id="grid-items" class="fully_mobile full_width mb-3">
            <? include('include/t-view.view.php') ?>
        </table>
    </div>

    <br>

    <table width="100%" class="table mt-4 totals fully_mobile full_width mb-3" >
    <tr>
        <th width="20%"><?l('Hours') ?>
        <th width="20%"><?l('Total (exl.VAT)') ?>
        <th width="20%"><?l('VAT %') ?>
        <th width="20%"><?l('Total VAT') ?>
        <th><?l('Total (incl.VAT)') ?>
    </tr>
    <tr class="cell-total">
        <td>
            <div class="table_label_mobile">Hours</div>
            <mark class="p-2"><?=$invoice['quantity'] ?></mark>
        </td>
        <td>
            <div class="table_label_mobile"><?l('Total (exl.VAT)') ?></div>
            <?=$invoice['total'] ?>
        </td>
        <td>
            <div class="table_label_mobile"><? l('VAT %') ?></div>
            <?=$invoice['vatcoeff'] ?>
        </td>
        <td>
            <div class="table_label_mobile"><?l('Total VAT') ?></div>
            <?=$invoice['vatsum'] ?>
        </td>
        <td>
            <div class="table_label_mobile"><?l('Total (incl.VAT)') ?></div>
            <?=$invoice['totalvat'] ?>
        </td>
    </tr>
    </table>

    <div class="modal-overlay">
        <div class="menu-modal flex-box">
            <div class="bg-bar p-2 flex-fill">
                <span class="close-modal">
                    <i class="far fa-times-circle"></i>
                </span>
                <div id="modal-body" class="mt-2"></div>

                <div class='foot-bar' >
                    <button id="btn-close-modal" class="btn btn-primary" type="Submit"><?l('Close')?>&nbsp;&nbsp;
                    <i class="fas fa-times-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
    
<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript"> 

<? include('js/toolskit/funcs.js') ?>

const not_submitted = 'not submitted';
const not_ready = 'not ready';
const invoice_id = "<?=$invoice['id']?>"; 

$(document).ready(function(){

        $('#undo-submit').click(function() {
            dmDialog({
                title: "<?l('Make it editable again')?>",
                text: "<?l('Undo submit action and make the invoice editable again?')?>",
                ok: function() {
                    UndoSubmit();
                }
            });
        });

        function UndoSubmit() {
            ShowProcess();
            let url = "<? path('qv.invoice.undosubmit', ['id' => $invoice['id']])?>";

            $.ajax({ // POST works
                type: "POST", url: url,
                dataType: 'json',
                data: {
                    invoice_id: invoice_id
                },
                success: function (result) { 
                    url = "<?path('qv.invoice.index')?>";
                    window.location.href = url;
                }
            });
            return false;
        }

        $('#log-invoice').click(function() {
            //alert('Here - there');
            $('.modal-overlay').addClass('visible-yes');

            $.ajax({
                type: "POST", url: "<?path('qv.invoice.logging')?>",
                dataType: 'html',
                data: {
                    invoice_id: invoice_id
                },
                success: function (result) { 
                    //alert(result);
                    $("#modal-body").html( result );

                }
            });
            return false;
        });

        $('.close-modal,#btn-close-modal').click(function() {
            $('.modal-overlay').removeClass('visible-yes');
            return false;
        });

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
        });
    });

</script>




