$(document).ready(
function() {
    const img_default = $('.img-preview').html();
    $('#submarine').change(function(e){
// https://stackoverflow.com/questions/4459379/preview-an-image-before-it-is-uploaded            
        var file = e.target.files[0];
        $('#image-id').attr('src', URL.createObjectURL(file));
        $('#file-to-upload').val(file.name);
        $('#file-to-upload').addClass('disabled');
    });
    
    $('.img-cancel-icon').on('click', function(){
        $('.img-preview-box').removeClass('imgActive');
        $('#button').removeClass('active');
        $('#file-to-upload').removeClass('disabled');
        $('.img-preview img').remove();
        $('.img-preview').html(img_default);
        $('#file-to-upload').val('');
    });

    $('#file-to-upload').on('focusout',function(){
        var imgUrl = $('#file-to-upload').val();
        if(imgUrl != '') {
            var regP = /\.(jpe?g|png|gif|bmp)$/i;
            if(regP.test(imgUrl)) {
                var imgTag = '<img src="'+imgUrl+'" >';
                $('.img-preview img').remove();
                $('.img-preview').append(imgTag);
                $('.img-preview-box').addClass('imgActive');
                $('#button').addClass('active');
                $('#file-to-upload').addClass('disabled');
            }else{
                $('#file-to-upload').val('');
            }
        }
    });
}
);
