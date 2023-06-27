// Start Tab-Control <------------ ] =======================
var curr_tab = "1";

$('.tab-item').click(function (event) {
    let tab_id = $(this).data('page');
    //alert("tab "+tab_id);
    if (curr_tab !== tab_id) {
        lolight(curr_tab);
        hilight(tab_id);
        curr_tab = tab_id;
    }
});
$('.fx-tab-item').click(function (event) {
    let tab_id = $(this).data('page');
    //alert("tab "+tab_id);
    if (curr_tab !== tab_id) {
        fx_lolight(curr_tab);
        fx_hilight(tab_id);
        curr_tab = tab_id;
    }
});

function lolight(tab_id) {
    $("#page" + tab_id).addClass('lo-tab-item');
    let tab_hat = $('#page' + tab_id).find('.tab-item-hat');
    let tab_body = $('#page' + tab_id).find('.tab-item-body');
    let tab_bottom = $('#page' + tab_id).find('.tab-item-bottom');
    $(tab_hat).removeClass('tab-item-hat-hi');
    $(tab_hat).addClass('tab-item-hat-lo');
    $(tab_body).removeClass('tab-item-body-hi');
    $(tab_body).addClass('tab-item-body-lo');
    $(tab_bottom).removeClass('visible-yes');
    $(tab_bottom).addClass('visible-no');
}

function fx_lolight(tab_id) {
    $("#page" + tab_id).removeClass('fx-tab-item-hi');
    $("#page" + tab_id + " .fx-tab-item-bottom").removeClass('visible-yes');
    $("#page" + tab_id + " .fx-tab-item-bottom").addClass('visible-no');
}

function showBox(tab_id) {
    $("#box-" + tab_id).removeClass('box-hide');
    $("#box-" + curr_tab).addClass('box-hide');
}
function hilight(tab_id) {
    $("#page" + tab_id).removeClass('lo-tab-item');
    let tab_hat = $('#page' + tab_id).find('.tab-item-hat');
    let tab_body = $('#page' + tab_id).find('.tab-item-body');
    let tab_bottom = $('#page' + tab_id).find('.tab-item-bottom');
    $(tab_hat).addClass('tab-item-hat-hi');
    $(tab_hat).removeClass('tab-item-hat-lo');
    $(tab_body).addClass('tab-item-body-hi');
    $(tab_body).removeClass('tab-item-body-lo');
    $(tab_bottom).removeClass('visible-no');
    $(tab_bottom).addClass('visible-yes');

    showBox(tab_id);
}
function fx_hilight(tab_id) {
    $("#page" + tab_id).addClass('fx-tab-item-hi');
    $("#page" + tab_id + " .fx-tab-item-bottom").removeClass('visible-no');
    $("#page" + tab_id + " .fx-tab-item-bottom").addClass('visible-yes');
    showBox(tab_id);
}
// End Tab-Control <------------ ] =======================
