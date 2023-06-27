// https://jqueryui.com/draggable/#visual-feedback
// https://jqueryui.com/droppable/

var target = '';
var source = '';
var countInvoices = 0;
var target_invoice_id = 0;
var source_list = '';
var invoice_id = 0;
var target_customer_id = 0;
var customer_id = 0;
var base_flag = false;

$( "#modal-rack" ).draggable({
    start: function( event, ui ) { base_flag = true; },
    stop: function( event, ui ) { },
});
$( ".tr-drag" ).draggable(
{
    // grid: [200, 25],
    // cursor: "crosshair",
    // cursorAt: { top: 5, left: 5 },
    // helper:"clone",
    // axis: 'y',
    // containment: "parent",
    cursor: "move", 

    helper: function( event ) {
        if(!source) {
            invoice_id = $(this).data('invoice-id');
            customer_id = $(this).data('customer-id');
            source = "<?l('Source invoice')?> #"+invoice_id + " " + $(this).find('.doc-date').text() + " " + $(this).find('.row-href').text();
        }
        return $( "<div style='margin-left:2rem;padding:0.5rem;background:white; border: 2px solid grey;z-index:300;'>"+source+"</div>" );
    },

    start: function( event, ui ) { 
        let status = $(this).data('status-id');
        if(status == 'submitted') return false;
        invoice_id = $(this).data('invoice-id');
        customer_id = $(this).data('customer-id');
        source = "<?l('Source invoice')?> #"+invoice_id + " " + $(this).find('.doc-date').text() + " " + $(this).find('.row-href').text();
    }, 
    drag: function( event, ui ) { 
        // alert('HERE');
    },
    stop: function( event, ui ) { 
        // alert('HERE -stop'+source);
    }
});

$(".tr-drop,#modal-rack-source").droppable({
    accept: ".tr-drag",
    drop: function() {
        // alert($('#modal-rack').css('display') == 'none');
        let invisible = $('#modal-rack').css('display') == 'none';
        if( base_flag && !invisible ) {
            base_flag = false;
            return false;
        }
        if(invisible) {
            let target_id = $(this).data('invoice-id');
            let status = $(this).data('status-id');
            target = "<?l('Invoice')?> #"+target_id + " " + $(this).find('.row-href').text();
            $('#dlg-rack-title').html("<?l('Merge source invoices into the target one')?>");

            $('#modal-rack-target').html("<div  style='background:grey;color:white;padding:5px;' ><?l('Target') ?> : <b>" +target+'</b></div>');
            $('#modal-rack').show();
            if(status == 'submitted') {
                sayError("<?l('You cannot use submitted invoices') ?>");
                return false;
            }
            $('#modal-rack-source-caption').html("<small><?l('Drag and drop invoices') ?></small>");
            $('#modal-rack-source').html('');
            target_invoice_id = target_id;
            // target_customer_id = customer_id;
            target_customer_id = $(this).data('customer-id');
            source_list = '';
            func_ok = function() { onMergeInvoices(target_invoice_id, source_list)}
        }

        if( verifyInvoice(invoice_id, customer_id)) {

            $('#modal-rack-source').append('<div>' +source+'</div>');
        }
        source = '';
    }
});

function verifyInvoice(invoice_id, customer_id) {

    if(customer_id !== target_customer_id) {
        sayError("<?l('Wrong customer')?>");
        return false;
    }
    if(invoice_id == target_invoice_id) {
        sayError("<?l('The target invoice cannot be the source one')?>");
        return false;
    }
    if(source_list.includes(invoice_id+',')) {
        // sayError('the source invoice is there already');
        return false;
    }
    noError();
    source_list += invoice_id+',';
    return true;
}

function sayError( text ) {
    $('#modal-rack-warning').html("<div style='border-left:4px solid red;padding:5px;background:#FFDCDC;'><?l('Warning')?>: "+text+'</div>');
}
function noError() {
    $('#modal-rack-warning').html('');
}
function onMergeInvoices(target_id, source_list) {

    let url = "<? path('qv.invoice.merge-invoices') ?>";
    
    ShowProcess();
    // alert('MergeInvoices '+ url);

    $.ajax({
        method: "POST", 
        url: url, 
        dataType: 'json',
        data: { 
            target: target_id,
            invoices: source_list
        },
        success: function (result) {
            if(result.return == 'success') {
                window.location.href = result.invoice;     
            } else {
                window.location.href = "<? path('qv.invoice.index') ?>";     
            }
        }
    });
}    
    // $( "#table_tbody" ).sortable();
// $( "#table_tbody" ).disableSelection();
