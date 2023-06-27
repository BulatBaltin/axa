function onDeleteObject(atom_id, url_path, csrf_token) {
    $.post(url_path, {
        _token: csrf_token
    }, (result) => { // 
        //renderResult( result, function(){
        renderResult(result, function () {
            // alert('Back fire ?');
            $("#rec" + atom_id).remove();
        });
    }, 'json');
}

$('#grid-data').on("click", ".del-btn", function (event) {
    const atom_id = $(this).data("id");
    const atom_name = $("#name" + atom_id).text();
    const url_path = $(this).attr('href');
    const csrf_token = $("#csrf_token" + atom_id).val();

    dmDialog({
       title: "<? l('Delete object') ?>",
       text: '<? l("Are you sure you want to delete this object?") ?>' + "<br>id: " + atom_id + "<br>name: " + atom_name,
       ok: function() { onDeleteObject(atom_id, url_path, csrf_token) } 
    });
    return false;
});
