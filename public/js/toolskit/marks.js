$('#i-markall').click( function () {
    // var checked = $(this).hasClass('fa-square');
    let checkbox = $(this).children()[0];
    let checked = $(checkbox).hasClass('fa-square');
    // var checked = $(this).hasClass('fa-check-square');
    if (checked) {
        $(checkbox).removeClass('fa-square');
        $(checkbox).addClass('fa-check-square');
    } else {
        $(checkbox).removeClass('fa-check-square');
        $(checkbox).addClass('fa-square');
    }

    if (checked) {
        $('.i-mark').removeClass('fa-square');
        $('.i-mark').addClass('fa-check-square');
    } else {
        $('.i-mark').removeClass('fa-check-square');
        $('.i-mark').addClass('fa-square');
    }
});

// $('.i-mark').on('click', function () {
$('td').on('click','.i-mark', function () {
// alert('click ' + $(this).hasClass('fa-check-square'));    
    if ($(this).hasClass('fa-check-square')) {
        $(this).removeClass('fa-check-square');
        $(this).addClass('fa-square');
    } else {
        $(this).removeClass('fa-square');
        $(this).addClass('fa-check-square');
    }
});

// $('.tr-data').on('click', '.cell-mark', function () {
//     let that = $(this).find('.i-mark');
//     if ($(that).hasClass('fa-check-square')) {
//         $(that).removeClass('fa-check-square');
//         $(that).addClass('fa-square');
//     } else {
//         $(that).removeClass('fa-square');
//         $(that).addClass('fa-check-square');
//     }
// });

