<!-- <link rel="stylesheet" href="/css/jquery.fileupload.css"> -->
<div class='page_wrap'>

    <h1><? l('Profile') ?></h1>

    <div class="tabs_wrapper">
        <div class="tabs">
            <span class="tab"><? l('Overview')?></span>
            <span class="tab"><? l('Subscription')?></span>
            <span class="tab"><? l('Payment')?></span>
            <span class="tab"><? l('Accounting')?> <span class="accounting_icon">!</span></span>
            <span class="tab"><? l('Time tracking')?> <span class="time_tracking_icon">✔</span></span>
            <span class="tab"><? l('Translation services')?></span>
        </div>
        <? $form->start('user') ?>
        <? $form_company->start('company') ?>
        <div>
            <? $form->errors() ?>
        </div>
        <div class="tab_content">

            <div class="tab_item" style="display: block">
                <div id="success-error-1">
                </div>
                <h2><? l('Overview')?></h2>

                <div class='row'>
                    <div class="col-md-6 mb-5" style='display:flex;align-items: center;'>
                        <div class="user_profile_photo" style="background: url(<?=$logofile ?>) center / contain no-repeat">
                            <div style="background: url(<?=$logofile ?>) center / cover no-repeat"></div>
                        </div>
                        <? $form_company->widget('logoimage') ?>
                        <div style='margin-left:1rem;'>
                            <button id="btn-upload-logo" type="button" class="btn" data-button-id="upload_logo"
                                    class="rb-button"><? l('Logo') ?>
                                <svg class="upload_icon">
                                    <use xlink:href="/images/icons/sprite.svg#uploadfile"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5" style='display:flex;align-items: center;'>
                        <div class="user_profile_photo" style="background: url(<?=$avatarfile ?>) center / contain no-repeat">
                            <div style="background: url(<?=$avatarfile ?>) center / cover no-repeat"></div>
<img id="user-avatar" src="<?=$avatarfile ?>" alt="User Avatar" style="height:90px; width:90px; border-radius: 50%;">
                        </div>
                        <? $form->widget('avatarimage') ?>
                        <div style='margin-left:1rem;'>
                            <button id="btn-upload-avatar" class="btn" type="button" data-button-id="upload_avatar"
                                    class="rb-button ml-2 mt-4"><? l('Avatar') ?>
                                <svg class="upload_icon">
                                    <use xlink:href="/images/icons/sprite.svg#uploadfile"></use>
                                </svg>
                            </button>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <!-- {# Basic info ------- #} -->
                    <div class="col-md-6">
                        <h3><? l('Basic information') ?></h3>
                        <? $form->row('username') ?>
                        <? $form_company->row('business') ?>
                        <span hidden><? $form->row('id') ?></span>
                        <? $form->row('name') ?>
                        <? $form->row('sirname') ?>
                        <? $form_company->row('address') ?>
                        <? $form_company->row('postcode') ?>
                        <? $form_company->row('city') ?>

                        <button id="update-1" type="button" class="btn">
                            <? l('Update') ?>
                            <svg class="update_icon">
                                <use xlink:href="/images/icons/sprite.svg#undo"></use>
                            </svg>
                        </button>
                    </div>
                    <!-- {# Password   ------- #} -->
                    <div class="col-md-6">
                        <div>
                            <h3><? l('Change password') ?></h3>
                            <? $form->row('password0') ?>
                            <? $form->row('password1') ?>
                            <? $form->row('password2') ?>

                            <button id="update-2" type="button" class="btn  mb-5">
                                <? l('Update') ?>
                                <svg class="update_icon">
                                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                </svg>
                            </button>

                            <h3><? l('Language / country') ?></h3>
                            <div class="custom_select">
                                <? $form->row('lingo_id') ?>
                            </div>
                            <div class="custom_select">
                                <? $form->row('country_id') ?>
                            </div>

                            <button id="update-3" type="button" class="btn">
                                <? l('Update') ?>
                                <svg class="update_icon">
                                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="tab_item">

                <h2><? l('Subscription')?></h2>
                <div>
                    <h3>Don't miss out on new business resourses</h3>
                    <p>Get the latest business resourses on the market delivered to your inbox. Unsubscribe at any time</p>
                    <div style="margin-top: 3rem;">
                        <? $form->row('chatemail') ?>
                        <button id="profile-subscribe" data-method="subscription" type="button" class="btn">
                            <? l('Subscribe') ?>
                            <svg class="notification_icon">
                                <use xlink:href="/images/icons/sprite.svg#notification"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="tab_item">

                <h2><? l('Payment')?></h2>

                <? include('include/payment.html.php')?>
            </div>

            <div class="tab_item">

                <h2><? l('Accounting') ?></h2>

                <ul class="accordion">
                    <?$inx = 0 ?>
                    <? foreach ($form->accrows as $account): ?>
                        <li>
                            <a class="toggle" href="javascript:void(0);">
                                <svg class="arrow_down">
                                    <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                                </svg>
                                <img src="<?=$account->logofile ?>"
                                     alt="<?=$account->name?>"
                                     title="<?=$account->logofile?>"
                                >
                                <!--</div>-->
                            </a>
                            <div class="inner">
                                <div class='tab-page1' data-page="<?=$inx ?>">
                                    <? foreach($page30 as $row): 
                                        $input_id = $form->form_name . $row['name'] .'_'.$inx.'_id';
                                        ?>

                                        <?$show = $object['acclabels'][ $inx ][$row['name']] ?>
                                        <div <? if ($show != true): ?>hidden<? endif ?> class="input_row">
                                            <label for="<?=$input_id ?>">
                                                <i style="color:grey;" class="<?=$row['icon'] ?>"></i> 
<?= $object['acclabels'][ $inx ][$row['name']] ?>
                                            </label>
<? $account->widget($row['name'],['id'=>$input_id]) ?>
                                        </div>
                                    <? endforeach ?>
                                    <div>
                                        <button id="btn-acc-up-<?=$inx ?>" data-accounting="<?=$object['acclabels'][ $inx ]['accounting'] ?>" data-id="<?=$inx ?>" type="button"
                                                class="btn mb-2"><? l('Update') ?>
                                            <svg class="update_icon">
                                                <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                            </svg>
                                        </button>
                                        <button id="btn-acc-in-<?=$inx ?>" data-accounting="<?=$object['acclabels'][ $inx ]['accounting'] ?>" data-id="<?=$inx ?>" type="button"
                                                class="btn mb-2"><? l('Connect') ?>
                                            <svg class="link_icon">
                                                <use xlink:href="/images/icons/sprite.svg#link"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?$inx++ ?>
                    <? endforeach ?>
                </ul>
            </div>

            <div class="tab_item">

                <h2>
                    <? l('Time tracking') ?>
                </h2>

                <ul class="accordion">
                    <?$inx = 0 ?>
                    <? foreach($form->timerows as $account): ?>
                        <li>
                            <a class="toggle" href="javascript:void(0);">
                                <svg class="arrow_down">
                                    <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                                </svg>
                                <img src="<?=$account->logofile ?>"
                                     alt="<?=$account->name ?>"
                                     title="<?=$account->name ?>"
                                    style='margin-right:3rem;'
                                >
                                <? if ($account->greencheck == '1'): ?>
                                    <i class="ml-2 fas fa-check-circle big-icon-green"></i>
                                <? endif ?>
                            </a>
                            <div class="inner">
                                <div class='tab-page2' data-page="<?=$inx ?>">
                                    <? foreach($timelabels as $row): 
                                        $input_id = $row['name'] .'_'.$inx.'_id';
                                        ?>
                                        <div  class="input_row">
                                            <label for="<?=$input_id ?>">
                                                <i class="<?=$row['icon'] ?>"></i> <?=$row['label'] ?>
                                            </label>
                <? $account->widget($row['name'],['id'=>$input_id]) ?>
                                        </div>
                                    <? endforeach ?>

                                    <div id="result-<?=$inx ?>" class="mb-4"></div>
                                    <div>
                                        <button id="btn-time-up-<?=$inx ?>"
                                                data-tracking="<?=$object['timerows'][ $inx ]['tracking'] ?>"
                                                data-id="<?=$inx ?>" type="button"
                                                class="btn mb-2"><? l('Update') ?>
                                            <svg class="update_icon">
                                                <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                            </svg>
                                        </button>

                                        <button id="btn-time-in-<?=$inx ?>"
                                                data-tracking="<?=$object['timerows'][ $inx ]['tracking'] ?>"
                                                data-id="<?=$inx ?>" type="button"
                                                class="btn mb-2"><? l('Connect') ?>
                                            <svg class="link_icon">
                                                <use xlink:href="/images/icons/sprite.svg#link"></use>
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <?$inx++ ?>
                    <? endforeach ?>
                </ul>
            </div>

            <div class="tab_item">

                <h2>
                    <? l('Translation services')?>
                </h2>
                <ul class="accordion">
                    <?$inx = 0 ?>
                    <? foreach($form->transrows as $account): ?>
                        <li>
                            <a class="toggle" href="javascript:void(0);">
                                <svg class="arrow_down">
                                    <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                                </svg>
                                <img src="<?=$account->logofile ?>"
                                     alt="<?=$account->name?>"
                                     title="<?=$account->name?>"
                                >
                            </a>
                            <div class="inner">
                                <div class='tab-page3' data-page="<?=$inx ?>">
                                    <? foreach( $translabels as $row ): 
                                        $input_id = $row['name'] .'_'.$inx.'_id';
                                        ?>

                                        <div  class="input_row">
                                            <label for="<?=$input_id ?>">
                                                <i class="<?=$row['icon'] ?>"></i> <?=$row['label'] ?>
                                            </label>
            <? $account->widget($row['name'],['id' => $input_id]) ?>
                                        </div>
                                    <? endforeach ?>

                                    <div>
                                        <button id="btn-trans-up-<?=$inx ?>"
                                                data-translation="<?=$object['transrows'][ $inx ]['translation'] ?>"
                                                data-id="<?=$inx ?>" type="button"
                                                class="btn mb-2"><? l('Update') ?>
                                            <svg class="update_icon">
                                                <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                            </svg>
                                        </button>

                                        <button id="btn-trans-in-<?=$inx ?>"
                                                data-translation="<?=$object['transrows'][ $inx ]['translation'] ?>"
                                                data-id="<?$inx ?>" type="button"
                                                class="btn mb-2"><? l('Connect') ?>
                                            <svg class="link_icon">
                                                <use xlink:href="/images/icons/sprite.svg#link"></use>
                                            </svg>
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <?$inx++ ?>
                    <? endforeach ?>
                </ul>
            </div>

            <div hidden >
                <? $form->rest() ?>
                <? $form_company->rest() ?>
            </div>

        </div>
        <? $form_company->end()?>
        <? $form->end()?>
    </div>
</div>
<!-- {# End Main flex #} -->

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>

<script src="/js/up/jquery.ui.widget.js"></script>
<script src="/js/up/jquery.iframe-transport.js"></script>
<script src="/js/up/jquery.fileupload.js"></script>
<!-- <script src="/js/tabcontrol.js"></script> -->
<script src="/js/toolskit/tabs-ctrl.js"></script>
<script src="/js/Chart.bundle.min.js"></script>
<script src="/js/dmight/password_eye.js"></script>

<script type="text/javascript">

$(document).ready(function(){

    bsCustomFileInput.init();
// Start Ajax Events

// Subscribe
    $('#profile-subscribe,#profile-payment').click(function(){
        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var method = $(this).data('method');
        var url = "<? path('user.subscription') ?>";
        url = url.replace('subscription', method );
        $.ajax({
            type: "POST", dataType: 'json', url: url, data: data_form,
            contentType:false, processData:false, cache:false,
            success: function (result) { renderErrorResult(result); }
        });
        return false;
    });

// Update 3-st block of General info - Country Language
    $('#update-3').click(function(){
        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var url = "<? path('user.update3') ?>";
        $.ajax({
            type: "POST", dataType: 'json', url: url, data: data_form,
            contentType:false, processData:false, cache:false,
            success: function (result) { renderErrorResult(result); }
        });
        return false;
    });

// Update 2-st block of General info - Password
    $('#update-2').click(function(){

        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var url = "<? path('user.update2') ?>";

        $.ajax({
            type: "POST", dataType: 'json', url: url, data: data_form,
            contentType:false, processData:false, cache:false,
            success: function (result) {
                renderErrorResult(result);
            }
        });
        return false;
    });

// Update 1-st block of General info
    $('#update-1').click(function(){
        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var url = "<? path('user.update1') ?>";
        $.ajax({
            type: "POST", dataType: 'html', url: url, data: data_form,
            contentType:false, processData:false, cache:false,
            success: function (result) { 
                $('#success-error-1').html(result); }
        });
        return false;
    });

    $('#company_profile_logoimage').change(function(e){
        var fileName = e.target.files[0].name; 
        return readURL(this, '#company-logo');
    });
    $('#user_avatarimage').change(function(e){
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

    $('#btn-upload-logo,#btn-upload-avatar').click(function(){

        var formUp = $('form[name="user"]')[0];
        var data_form = new FormData(formUp);
        var button = $(this).data('button-id');
        var url = "<? path('qv.company.upload', [ 'button' => 'upload_logo' ]) ?>";

        url = url.replace('upload_logo', button);

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: url,
            data: data_form,

            contentType:false,
            processData:false,
            cache:false,
            
            success: function (result) {
                renderErrorResult(result);
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
                    $('#modal-header').html( "<? l('Error updating data') ?>" );
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
                        $('#modal-header').html( "<? l('Testing Translation App Connection') ?>" );
                        $('#modal-body').html(result.mssg);
                    }
                    //$("#notes").html("<strong>" + result + "</strong>");
                }
        });
        return false;
    });

// Save tracking settings
    $('button[id^="btn-time-up-"]').click(function(){
        let id = $(this).data('id');
        let root = '#user_timerows_'+id+'_';
        var tracking_id = $(this).data('tracking');;

        var company_token = $(root+'companytogglname').val();
        var togglid = $(root+'togglid').val();
        var usertoken = $(root+'usertoken').val();
        var startdate = $(root+'startdate_date_year').val() +"-"+
            $(root+'startdate_date_month').val() +"-"+
            $(root+'startdate_date_day').val()+" "+
            $(root+'startdate_time_hour').val()+":"+
            $(root+'startdate_time_minute').val();

        $.ajax({
            type: "POST",
            dataType: 'html',
            url: "<? path('company.tracking') ?>",
            data: {
                company_token : company_token,
                tracking_id : tracking_id,
                togglid : togglid,
                usertoken : usertoken,
                startdate : startdate,
            },
            success: function (result) {
                $('#result-'+id).html(result);             
            }
        });
        return false;
    });

// Test PUT function
    $('button[id^="btn-time-put-"]').click(function(){
        
        let id = $(this).data('id');
        let root = '#user_timerows_'+id+'_';
        var tracking_id = $(this).data('tracking');;

        var company_token = $(root+'companytogglname').val();
        var togglid = $(root+'togglid').val();
        var usertoken = $(root+'usertoken').val();
        var startdate = $(root+'startdate').val();

        // alert( accounting_id +'\n\r'+key2+'\n\r'+login );

        $('.modal-overlay').addClass('visible-yes');
        $('#spinner').show();

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<? path('company.test-put.tracking') ?>",
            data: {
                company_token : company_token,
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
                        $('#modal-header').html( "<? l('Testing Time Tracking App Connection') ?>" );
                        $('#modal-body').html(result.mssg);
                    }
                    //$("#notes").html("<strong>" + result + "</strong>");
                }
        });
        return false;
    });
// Test tracking settings
    $('button[id^="btn-time-in-"]').click(function(){
        
        let id = $(this).data('id');
        let root = '#user_timerows_'+id+'_';
        var tracking_id = $(this).data('tracking');;

        var company_token = $(root+'companytogglname').val();
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
                company_token : company_token,
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
                        $('#modal-header').html( "<? l('Testing Time Tracking App Connection') ?>" );
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
                        $('#modal-header').html( "<? l('Testing Accounting App Connection') ?>" );
                        $('#modal-body').html(result.mssg);
                    }
                    //$("#notes").html("<strong>" + result + "</strong>");
                }
        });
        return false;
    });

//    
// End Ajax Events

    $('.p-page').click(function(){
        var page = $(this).data('page');
        $('.p-page').removeClass('active');
        $(this).addClass('active');

        $('.box-page').each(function(){
            if($(this).data('page') == page) {
                $(this).removeClass('box-hide');
            } else if(!$(this).hasClass('box-hide')) {
                $(this).addClass('box-hide');
            }
        });
    });

    /*$("[class^='tab-angle']").click(function(){
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
    });*/

// Modal dialog    <------------ ] =======================
    $('.close-modal,#btn-close-modal').click(function() {
        $('.menu-modal').addClass('visible-no');
        $('.modal-overlay').removeClass('visible-yes');
        return false;
    });
// End Modal dialog <------------ ] =======================

    $("#btn-upload1").click(function() {

        // var formUp = document.getElementById("myform");
        // or with jQuery

        // var formUp = $("#myform")[0];
        // var formUp = $('form[name="user"]')[0];
        var formUp = $('form[name="user"]')[0];

        var data_form = new FormData(formUp);
        data_form.button = "Apply";
        
//        console.log(data_form);
//        alert('Upload');

        $.ajax({
          url:"<?path('qv.company.upload',['button'=>'Apply'])?>",
          type:"post",
          dataType:"json", // Change this according to your response from the server.
        //  url:"<?path('user.profile')?>",
          data: data_form,
//              button: 'Apply-1',// the formData function is available in almost all new browsers.
//              forms: 'data_form',// the formData function is available in almost all new browsers.
//          },    

          contentType:false,
          processData:false,
          cache:false,

          error:function(err){
                console.log('error!!!');
                console.error(err);
          },
          success:function(result){
            renderResult(result)
          },
          complete:function(){
            console.log("Request finished.");
          }
        });

    });

// ====================================
    $('.fileupload-multiphotos-images').fileupload({
        url: "<?path('qv.company.upload', ['button'=>'Apply'])?>", // '/backend/~ajax/uploadphoto-multiphoto',
        dataType: 'html',
        done: function (e, data) {
        },
        progressall: function (e, data) {
            
        }
    }).prop('disabled', !$.support.fileInput)
        .parent().addClass($.support.fileInput ? undefined : 'disabled');

        
    $('.fileupload-multiphotos-images').bind('fileuploadsubmit', function (e, data) {
        data.formData = { field_name: $(this).data("item-id") };
    });

// Service functions
    function renderResult(result){
        $('.modal-overlay').addClass('visible-yes');
        $('.menu-modal').removeClass('visible-no');
        if( result['return'] == "error"){
//            alert('ERROR');
            $('#modal-header').html( "<? l('Error uploading file') ?>" );
            $('#modal-body').html(result.mssg);
        } else {
//            alert('SUCCESS');
            $('#modal-header').html( "<? l('Result') ?>" );
            $('#modal-body').html(result.mssg);
        }
    }
    function renderErrorResult(result){
        if( result['return'] == "error"){
            $('.modal-overlay').addClass('visible-yes');
            $('.menu-modal').removeClass('visible-no');
            $('#modal-header').html( "<? l('Error uploading file') ?>" );
            $('#modal-body').html(result.mssg);
        } 
    }


}); // end doc ready
</script>

