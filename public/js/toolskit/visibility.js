$('#user-list').on('click', '.del-worker', function () {
    var id = $(this).data('id');
    $('#user-list').find('#worker-' + id).remove();
});

$(list_adduser).change(function () {

    var id = $(list_adduser + ' option:selected').val();
    if(id == 0) return;
    var title = $(list_adduser + ' option:selected').text();
    if ($('#worker-' + id).length > 0) return;
    var newWorker = "<div class='mt-2' id='worker-" + id + "' data-id='" + id + "'>\
            <i class='del-worker fas fa-user-check pointer' style='color:grey;' data-id='"+ id + "'></i>\
            <span class='ml-1'>"+ title + "</span>\
            </div>";

    $('#user-list').append(newWorker);
});
