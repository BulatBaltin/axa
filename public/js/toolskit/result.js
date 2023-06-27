function showResult(result, succsessFunc) {
    $("#notes").removeClass("red-box");
    $("#notes").removeClass("green-box");

    if (result["success"]) {
        $("#notes").addClass("green-box");
        $("#notes").html(result['success']);
        // alert('(1) success');
        succsessFunc();
    }
    else if (result["error"]) {
        $("#notes").addClass("red-box");
        $("#notes").html(result['error']);
    }
}
