// Modal dialog    <------------ ] =======================
$('.close-modal,#btn-close-modal,#btn-nope').click(function () {
    $('.menu-modal').removeClass('visible-yes');
    $('.modal-overlay').removeClass('visible-yes');
    $('.dlg-overlay').removeClass('visible-yes');
    return false;
});
