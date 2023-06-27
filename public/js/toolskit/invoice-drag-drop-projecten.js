// https://jqueryui.com/draggable/#visual-feedback
// https://jqueryui.com/droppable/

var target = '';
var source = '';
var countInvoices = 0;
var target_invoice_id = 0;
var source_list = '';
var task_id = 0;
var target_customer_id = 0;
var customer_id = 0;
var action = 0;
var href = '';
var base_flag = false;

initDragNDrop();

function initDragNDrop() {

$( ".tr-drag" ).draggable(
{
    cursor: "move", 

    helper: function( event ) {
        if(!source) {
            task_id = $(this).data('task-id');
            action = $(this).data('action');
            href = $(this).data('href');
            customer_id = $(this).data('customer-id');
// this is taken !
            source = "<?l('Task')?>" +
            $(this).data('task-name');
        }
        return $( "<div style='margin-left:2rem;padding:0.5rem; border: 2px solid grey;z-index:300;border-radius:6px;-webkit-transform:rotate(2deg);max-width:280px;background:rgba(230,250,200, 0.8);'>"+source+"</div>" );
    },

    start: function( event, ui ) { 

        // action = $(this).data('action');
        // href = $(this).data('href');
        // task_id = $(this).data('task-id');
        // customer_id = $(this).data('customer-id');

        // source = "<?'Source invoice'|trans?> #" +
        // task_id + " " +
        // $(this).data('task-date') + " " +
        // $(this).data('task-name');
    }, 
    drag: function( event, ui ) { 
        // alert('HERE');
    },
    stop: function( event, ui ) { 
        // alert('HERE -stop'+source);
    }
});

$("#modal-rack-source,#modal-rack-target").droppable({
    accept: ".tr-drag",
    drop: function() {

        $.ajax({
            method: 'POST', dataType: 'json',
            url: href,
            data: {action: action},
            success: function(result) {
                if(result.return=='success') {
                    TwinTables(result);
                }
            }
        });
        source = '';
    }
});

}

function sayError( text ) {
    $('#modal-rack-warning').html("<div style='border-left:4px solid red;padding:5px;background:#FFDCDC;'><?l('Warning')?>: "+text+'</div>');
}
function noError() {
    $('#modal-rack-warning').html('');
}
function onMergeInvoices(target_id, source_list) {
    ShowProcess();
    $.ajax({
        method: "POST", 
        url: "<? path('zinvoice.merge.invoices') ?>", 
        dataType: 'json',
        data: { 
            target: target_id,
            invoices: source_list
        },
        success: function (result) { 
            window.location.href = "<? path('zinvoice.index') ?>";     
        }
    });
}    
function TwinTables(result) {

    // alert(result.btnCreate == 0);
    $('#table-body-1').html(result.htmlTable1);
    $('#total-1').html(result.total1);
    $('#table-body-2').html(result.htmlTable2);
    $('#total-2').html(result.total2);
    $('#create-invoice').attr('disabled', result.btnCreate == 0);
    initDragNDrop();
}
    