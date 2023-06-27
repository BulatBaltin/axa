<div class='page_wrap'>
<div class="mb-4 mt-3" style='display:flex; align-items: center;'>
    <? $url_back = route('qv.user.index') ?>
    <? include_view(DMIGHT.'template/move-button.html.php', ['url_back'=> $url_back]) ?>

    <h2 style="margin:0 4rem;"><?l($profile)?></h2>
</div>

    <h4><?=$user['name'] ?></h4>

    <? $form->start('user') ?>
    <? $form_company->start('company_profile') ?>
    <div>
        <? $form->errors() ?>
    </div>

    <div class="tabs_wrapper">

        <div class="tabs">
            <span class="tab active"><? l('Overview') ?></span>
            <span class="tab"><? l('Activate') ?></span>
            <span class="tab"><? l('Password') ?></span>
            <span class="tab"><? l('Time tracking') ?> <span class="time_tracking_icon">✔</span></span>
        </div>
        <div class="tab_content">
            <div class="tab_item">
                <div id="success-error-1">
                </div>
                <h2><?l('Overview')?></h2>
                <div class="row">
                    <div class='col-md-4 mb-5'>
                        <div class="user_profile_photo">
                            <!-- <div style="background: url('<?=$avatarfile ?>') center / cover no-repeat"></div> -->

                            <img id="user-avatar" src="<?=$avatarfile?>" alt="" style="width:inherit;">
                        </div>
                        <div style="margin-top:1.5rem;">
                            <? $form->widget('avatarimage',['id' => 'avatarimage_id']) ?>
                        </div>
                    </div>
                    <div class='col-md-6 mb-5'>
                        <div style="margin-top:1.5rem;">
                            <button id="btn-upload-avatar" type="button" data-button-id="upload_avatar"
                            class="btn"><? l('Upload') ?>
                                <svg class="upload_icon">
                                    <use xlink:href="/images/icons/sprite.svg#uploadfile"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-5">
                        <h3>
                            <?l('Basic information') ?>
                        </h3>
                        <span hidden><? $form->row('id') ?></span>
                        <? $form->row('username') ?>
                        <? $form->row('name') ?>
                        <? $form->row('sirname') ?>

                        <button id="update-1" type="button" class="btn mr-2 mb-2">
                            <? l('Update') ?>
                            <svg class="update_icon">
                                <use xlink:href="/images/icons/sprite.svg#undo"></use>
                            </svg>
                        </button>
                    </div>
                    <div class="col-md-6 mb-5">
                        <div>
                            <h3>
                                <?l('Contact') ?>
                            </h3>

                            <? $form->row('telephone') ?>
                            <div class="custom_select">
                                <? $form->row('lingo_id') ?>
                            </div>
                            <div class="custom_select">
                                <? $form->row('country_id') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab_item">
                <div id="success-error-2">
                </div>
                <h2><?l('Activate')?></h2>
                <div class="row">

                    <div class="col-md-6 mb-5">
                        <div>
                            <h3>
                                <?l('Email Addresses') ?>
                            </h3>
                            <? $form->row('email') ?>
                            <? $form->row('chatemail') ?>
                            <h3>

                            <button id="update-2" type="button" class="btn mb-2">
                                <?l('Update') ?>
                                <svg class="update_icon">
                                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab_item">
                <div id="success-error-3">
                </div>
                <h2><?l('Password')?></h2>
                <div class="row">

                    <div class="col-md-6 mb-5">
                        <div>
                            <? if ($isnew == true): ?>
                                <?l('Set password') ?>
                            <? else :?>
                                <?l('Change password') ?>
                            <? endif ?>
                            </h3>
                            <? if ($isnew == false): ?>
                                <? $form->row('password0') ?>
                            <? endif ?>
                            <? $form->row('password1') ?>
                            <? $form->row('password2') ?>

                            <button id="update-3" type="button" class="btn mb-2">
                                <?l('Update') ?>
                                <svg class="update_icon">
                                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                </svg>
                            </button>
                            <button id="log-out-in" type="button" class="btn ml-2 mb-2">
                                <?l('Login as this user') ?>
                                <svg class="logout_icon">
                                    <use xlink:href="/images/icons/sprite.svg#logout"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab_item">
                <div id="success-error-4">
                </div>
                <h2>
                    <?l('Time tracking') ?>
                </h2>
                <? $form->row('sendmail') ?>
                <? $form->row('dailygoal') ?>
                <button id="update-4" type="button" class="btn mb-2">
                    <?l('Update') ?>
                    <svg class="update_icon">
                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                    </svg>
                </button>

                <ul class="accordion">
                <? $inx = 0 ?>
                <? foreach( $form->timerows as $account): ?>
                    <li>
                        <a href="javascript:void(0)" class="toggle">
                            <svg class="arrow_down">
                                <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                            </svg>
                            <img height='50' src="<?=$account->logofile ?>"
                            alt="<?=$account->name?>"
                            title="<?=$account->name?>"
                            style='margin-right:3rem;'
                            >
                            <? if ($account->greencheck == '1'): ?>
                                <i class="ml-2 fas fa-check-circle big-icon-green"></i>
                            <? endif ?>
                        </a>
                        <div class="inner">
                            <? foreach($timelabels as $ix => $row): ?>
                            <div class="input_row">
                                <?$row_name = $row['name'];
                                //   $row_id   = $account->$row_name .'_id';
                                  $row_id   = 'user_timerows_'.$inx.'_'.$row_name;
                                    ?>
                                <label for="<?=$row_id ?>">
                                <i class="<?=$row['icon'] ?>"></i> <?=$row['label'] ?>
                                </label>
                                <? $account->widget($row_name, ['id' => $row_id ] ) ?>
                            </div>
                            <? endforeach ?>

                            <div id="result-<?=$inx ?>" class="mb-4"></div>
                            <div>
                                <button id="btn-time-up-<?=$inx ?>"
                                data-tracking="<?=$user['Timerows'][ $inx ]['tracking'] ?>"
                                data-id="<?=$inx ?>" type="button"
                                class="btn mb-2"><?l('Update') ?>
                                    <svg class="update_icon">
                                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                    </svg>
                                </button>

                                <button id="btn-time-in-<?=$inx?>"
                                data-tracking="<? $user['Timerows'][ $inx ]['tracking'] ?>"
                                data-id="<?=$inx ?>" type="button"
                                class="btn mb-2"><?l('Connect') ?>
                                    <svg class="link_icon">
                                        <use xlink:href="/images/icons/sprite.svg#link"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>
                <? $inx++ ?>
                <? endforeach ?>
                </ul>
            </div>
        </div>
    </div>

    <div hidden >
    <? $form->rest() ?>
    <? $form_company->rest() ?>
    </div>

    <? $form_company->end()?>
    <? $form->end()?>

<div class="p-2"></div>
<? include_view(DMIGHT.'template/move-button.html.php', ['url_back'=> $url_back]) ?>
<div class="p-3"></div>    
</div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<script src="/js/up/jquery.ui.widget.js"></script>
<script src="/js/up/jquery.iframe-transport.js"></script>
<script src="/js/up/jquery.fileupload.js"></script>
<script src="/js/Chart.bundle.min.js"></script>
<script src="/js/dmight/password_eye.js"></script>

<script src ="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script src ="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
<script src ="/js/toolskit/tabs-ctrl.js"></script>

<script type="text/javascript">
$(document).ready(function(){

    bsCustomFileInput.init();

// Start Ajax Events

    $('#log-out-in').click(function(){
        window.location.href = '<?path('app_logout')?>';                            
        return false;
    });

// Update 4 block of General info - Time tracking
    $('#update-4').click(function(){

        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var url = "<? path('qv.user.update',['part' => 4]) ?>";
alert(url);
        $.ajax({
            type: "POST", dataType: 'json', url: url, data: data_form,
            contentType:false, processData:false, cache:false,
            success: function (result) {
                $('#success-error-4').html(result.mssg);
            }
        });
        return false;
    });
// Update 3 block of General info - Password (Activate)
    $('#update-3').click(function(){

        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var url = "<? path('qv.user.update',['part' => 3]) ?>";
// alert(url+' >'+$('#user_password1_id').val()+'<');
        if( $('#user_password1_id').val() == '' ) {
            dmDialog (
                {title :"<?l('Empty password') ?>",
                    text :"<?l('Are you sure you want to set the Empty password?') ?>",
                    ok: function() {
                        UpdatePassword(url, data_form); 
                    }
                }
            );
        } else {
            UpdatePassword(url, data_form);
        }
        return false;
    });

    function UpdatePassword(url, data_form) {
        $.ajax({
            type: "POST", dataType: 'json', url: url, data: data_form,
            contentType:false, processData:false, cache:false,
            success: function (result) {
                $('#success-error-3').html(result.mssg);
            }
        });
    }
// Update 2-st block of General info - Activate and emails
    $('#update-2').click(function(){

        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var url = "<? path('qv.user.update',['part' => 2]) ?>";

        $.ajax({
            type: "POST", dataType: 'json', url: url, data: data_form,
            contentType:false, processData:false, cache:false,
            success: function (result) {
                $('#success-error-2').html(result.mssg);
            }
        });
        return false;
    });

// Update 1-st block of General info
    $('#update-1').click(function(){
        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var url = "<? path('qv.user.update',['part' => 1]) ?>";
        $.ajax({
            type: "POST", dataType: 'json', url: url, data: data_form,
            contentType:false, processData:false, cache:false,
            success: function (result) { 
                $('#success-error-1').html(result.mssg);
                //renderErrorResult(result); 
                }
        });
        return false;
    });

    $('#avatarimage_id').change(function(e){
        var fileName = e.target.files[0].name;
        return readURL(this, '#user-avatar');
    });
// -----------------------
    function readURL(input, file_src) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $(file_src).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            return false;
        } else {
            return true;
        }
    }

    $('#btn-upload-avatar').click(function(){

        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var button = $(this).data('button-id');
        var url = "<? path('qv.user.upload_avatar', ['id'=> $user['id'] ]) ?>";
        // alert(url);
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: url,
            data: data_form,

            contentType:false,
            processData:false,
            cache:false,
            
            success: function (result) {
// alert(result.mssg);
                $('#success-error-1').html(result.mssg);
// alert('Back here');
// renderErrorResult(result);
            }
        });
        return false;
    });



// ====================================================
// Save translation settings
    $('button[id^="btn-trans-up-"]').click(function(){
        let id = $(this).data('id');
        let root = '#user_transrows_'+id+'_';
        var translation_id = $(this).data('translation');;

        var parm1 = $(root+'parm1').val();
        var parm2 = $(root+'parm2').val();
        var parm3 = $(root+'parm3').val();
        // alert(translation_id+"\n\r"+parm1);
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<? path('company.translation') ?>",
            data: {
                translation_id : translation_id,
                parm1 : parm1,
                parm2 : parm2,
                parm3 : parm3,
            },
            success: function (result) {
                //alert(result.mssg);

                if( result['return'] == "error"){
                    $('#modal-header').html( "<?l('Error updating data') ?>" );
                    $('#modal-body').html(result.mssg);

                }
            }
        });
        return false;
    });

// Test tracking settings
    $('button[id^="btn-trans-in-"]').click(function(){
        
        let id = $(this).data('id');
        let root = '#user_transrows_'+id+'_';
        var translation_id = $(this).data('translation');;

        var parm1 = $(root+'parm1').val();
        var parm2 = $(root+'parm2').val();
        var parm3 = $(root+'parm3').val();

        // alert( accounting_id +'\n\r'+key2+'\n\r'+login );

        $('.modal-overlay').addClass('visible-yes');
        $('#spinner').show();

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<? path('company.test.translation') ?>",
            data: {
                translation_id : translation_id,
                parm1 : parm1,
                parm2 : parm2,
                parm3 : parm3,
            },
            success: function (result) {
                    // alert("result: "+result['return']);
                    // console.log(result);
                    $('#spinner').hide();
                    $('.menu-modal').removeClass('visible-no');

                    if(result['return'] == "success" || result['return'] == "error"){
                        $('#modal-header').html( "<?l('Testing Translation App Connection') ?>" );
                        $('#modal-body').html(result.mssg);
                    }
                    //$("#notes").html("<strong>" + result + "</strong>");
                }
        });
        return false;
    });

// Save tracking settings
    $('button[id^="btn-time-up-"]').click(function(){
        let user_id = <?=$user_id?>;
        let id = $(this).data('id');
        let root = '#user_timerows_'+id+'_';
        var tracking_id = $(this).data('tracking');;
        var company_token = $(root+'companytogglname').val();
        var togglid = $(root+'togglid').val();
        var usertoken = $(root+'usertoken').val();
        var startdate = $(root+'startdate').val();
        //  +"-"+
        //     $(root+'startdate_date_month').val() +"-"+
        //     $(root+'startdate_date_day').val()+" "+
        //     ("0"+$(root+'startdate_time_hour').val()).slice(-2)+":"+
        //     ("0"+$(root+'startdate_time_minute').val()).slice(-2);
        var stopdate = $(root+'stopdate').val();
        //  +"-"+
        //     $(root+'stopdate_date_month').val() +"-"+
        //     $(root+'stopdate_date_day').val()+" "+
        //     ("0"+$(root+'stopdate_time_hour').val()).slice(-2)+":"+
        //     ("0"+$(root+'stopdate_time_minute').val()).slice(-2);

        let url = "<? path('qv.user.tracking') ?>"; 
// alert(root+' '+root+'startdate'+' '+ startdate);
        $.ajax({
            type: "POST",
            dataType: 'html',
            url: url,
            data: {
                id : user_id,
                company_token : company_token,
                tracking_id : tracking_id,
                togglid : togglid,
                usertoken : usertoken,
                startdate : startdate,
                stopdate : stopdate,
            },
            success: function (result) {
                $('#result-'+id).html(result);             
            }
        });
        return false;
    });

// Test tracking settings
    $('button[id^="btn-time-in-"]').click(function(){
        
        let id = $(this).data('id');
        let root = '#user_timerows_'+id+'_';
        var tracking_id = $(this).data('tracking');;

        var togglid = $(root+'togglid').val();
        var usertoken = $(root+'usertoken').val();
        var startdate = $(root+'startdate').val();

        // alert( accounting_id +'\n\r'+key2+'\n\r'+login );

        $('.modal-overlay').addClass('visible-yes');
        $('#spinner').show();

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<? path('company.test.tracking') ?>",
            data: {
                tracking_id : tracking_id,
                togglid : togglid,
                usertoken : usertoken,
                startdate : startdate,
            },
            success: function (result) {
                    // alert("result: "+result['return']);
                    // console.log(result);
                    $('#spinner').hide();
                    $('.menu-modal').removeClass('visible-no');

                    if(result['return'] == "success" || result['return'] == "error"){
                        $('#modal-header').html( "<?l('Testing Time Tracking App Connection') ?>" );
                        $('#modal-body').html(result.mssg);
                    }
                    //$("#notes").html("<strong>" + result + "</strong>");
                }
        });
        return false;
    });

// Save accounting settings
    $('button[id^="btn-acc-up-"]').click(function(){
        let id = $(this).data('id');
        let root = '#user_accrows_'+id+'_';
        var accounting_id = $(this).data('accounting');;

        var login = $(root+'login').val();
        var password = $(root+'password').val();
        var key1 = $(root+'key1').val();
        var key2 = $(root+'key2').val();
        var parm1 = $(root+'parm1').val();
        var parm2 = $(root+'parm2').val();

        //alert( accounting_id +'\n\r'+key2+'\n\r'+login );
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<? path('company.accounting') ?>",
            data: {
                accounting_id : accounting_id,
                login : login,
                password : password,
                key1 : key1,
                key2 : key2,
                parm1 : parm1,
                parm2 : parm2
            },
            success: function (result) {
                //alert(result.return);
                showReturnError(result);
                }
        });
        return false;
    });
// Test accounting settings
    $('button[id^="btn-acc-in-"]').click(function(){
        
        let id = $(this).data('id');
        let root = '#user_accrows_'+id+'_';
        var accounting_id = $(this).data('accounting');;

        var login = $(root+'login').val();
        var password = $(root+'password').val();
        var key1 = $(root+'key1').val();
        var key2 = $(root+'key2').val();
        var parm1 = $(root+'parm1').val();
        var parm2 = $(root+'parm2').val();

        // alert( accounting_id +'\n\r'+key2+'\n\r'+login );

        $('.modal-overlay').addClass('visible-yes');
        $('#spinner').show();

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<? path('company.test.accounting') ?>",
            data: {
                accounting_id : accounting_id,
                login : login,
                password : password,
                key1 : key1,
                key2 : key2,
                parm1 : parm1,
                parm2 : parm2
            },
            success: function (result) {
                    // alert("result: "+result['return']);
                    // console.log(result);
                    $('#spinner').hide();
                    $('.menu-modal').removeClass('visible-no');

                    if(result['return'] == "success" || result['return'] == "error"){
                        $('#modal-header').html( "<?l('Testing Accounting App Connection') ?>" );
                        $('#modal-body').html(result.mssg);
                    }
                    //$("#notes").html("<strong>" + result + "</strong>");
                }
        });
        return false;
    });

//    
// End Ajax Events

    $("[class^='tab-angle']").click(function(){
        var page = $(this).data('page');
        var ctrlID = $(this).data('control-id');

        if($(this).find('i').hasClass('fa-angle-down')) {
            $(this).find('i').removeClass('fa-angle-down');
            $(this).find('i').addClass('fa-angle-right');
            $('.tab-page' + ctrlID).each(function(){
                if(!$(this).attr('hidden')) {
                    $(this).attr('hidden', true);
                }
            });
        } else {

            $('.tab-angle' + ctrlID ).find('i').each(function(){
                if($(this).hasClass('fa-angle-down')) {
                    $(this).removeClass('fa-angle-down');
                    $(this).addClass('fa-angle-right');
                }
            });
        
            $(this).find('i').removeClass('fa-angle-right');
            $(this).find('i').addClass('fa-angle-down');

            $('.tab-page' + ctrlID).each(function(){
                if($(this).data('page') == page) {
                    $(this).attr('hidden',false);
                } else if(!$(this).attr('hidden')) {
                    $(this).attr('hidden',true);
                }
            });
        } 
    });

// Modal dialog    <------------ ] =======================
    $('.close-modal,#btn-close-modal').click(function() {
        $('.menu-modal').addClass('visible-no');
        $('.modal-overlay').removeClass('visible-yes');
        return false;
    });
// End Modal dialog <------------ ] =======================

// Service functions
    function renderResult(result){
        $('.modal-overlay').addClass('visible-yes');
        $('.menu-modal').removeClass('visible-no');
        if( result['return'] == "error"){
//            alert('ERROR');
            $('#modal-header').html( "<?l('Error uploading file') ?>" );
            $('#modal-body').html(result.mssg);
        } else {
//            alert('SUCCESS');
            $('#modal-header').html( "<?l('Result') ?>" );
            $('#modal-body').html(result.mssg);
        }
    }
    function renderErrorResult(result){
        if( result['return'] == "error"){
            $('.modal-overlay').addClass('visible-yes');
            $('.menu-modal').removeClass('visible-no');
            $('#modal-header').html( "<?l('Error uploading file') ?>" );
            $('#modal-body').html(result.mssg);
        } 
    }


}); // end doc ready
</script>