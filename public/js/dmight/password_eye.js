$(document).ready(function(){
    $('.pass-box').on('click','[id^=tog-pass]', function(e){
        let pass_id = '#'+$(this).data('id');
        // alert('HERE '+pass_id);
        let type = $(pass_id).attr('type');
        if(type == 'password' ) {
            $(pass_id).attr('type','text');
            // $(pass_id).attr('placeholder','');
            $(this).attr('class','fa-eye-slash')
        } else {
            $(pass_id).attr('type','password');
            // $(pass_id).attr('placeholder','');
            $(this).attr('class','fa-eye')
        }
    });
})