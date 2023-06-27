;( function ( $ ) {
    $( function () {
        $( '#notes' ).on( 'hover', function() {
            $( this ).addClass( 'notes-hover' );
        } );
    } );
} )( jQuery );

// + --------------------- Service funcs -------------------------- + // 
function showResult(result, successFunc) {
    $("#notes").removeClass('notes-hover');
    $("#notes").removeClass("red-box");
    $("#notes").removeClass("green-box");

    if (result["success"]) {
        $("#notes").addClass("green-box");
        $("#notes").html(result['success']);
        // alert('(1) success');
        if (successFunc) successFunc();
    }
    else if (result["error"]) {
        $("#notes").addClass("red-box");
        $("#notes").html(result['error']);
    }
}

function renderResult(result, successFunc) {
    $("#notes").removeClass('notes-hover');
    $("#notes").removeClass("red-box");
    $("#notes").removeClass("green-box");

    if (result["success"]) {
        $("#notes").addClass("green-box");
        $("#notes").html(result['success']);
        // alert('(1) success');
        if (successFunc) successFunc();
    }
    else if (result["error"]) {
        $("#notes").addClass("red-box");
        $("#notes").html(result['error']);
    }

}

function showReturn(result, successFunc) {
    $("#notes").removeClass('notes-hover');
    $("#notes").removeClass("red-box");
    $("#notes").removeClass("green-box");

    if (result["return"] === "success") {
        $("#notes").addClass("green-box");
        $("#notes").html(result['mssg']);
        // alert('(1) success');
        if (successFunc) successFunc();
    }
    else if (result["return"] === "error") {
        $("#notes").addClass("red-box");
        $("#notes").html(result['mssg']);
    }
}

function showReturnError(result, successFunc) {

    if (result["return"] === "error") {
        $("#notes").removeClass('notes-hover');
        $("#notes").removeClass("red-box");
        $("#notes").removeClass("green-box");

        $("#notes").addClass("red-box");
        $("#notes").html(result['mssg']);
    }
}

