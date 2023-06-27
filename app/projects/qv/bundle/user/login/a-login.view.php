<!DOCTYPE html>
<html lang="en">

<head>
    <? include(LAYOUT .'base-qv-head.html.php') ?>
    <link rel="stylesheet" href="/css/login.css">
    <title><?l('Login')?></title>
</head>
<body>

<section class="main-content" style="background: url('/images/qv/quickvoice_angle.png');">
<div class="page_wrap">

    <div id="login-box" class="modal-overlay">
        <div id="login-panel" class="login-modal bg-white" style="border-radius: 8px;">

            <div class="login_form" style="border-radius: 8px;">
                <div style='background: #eee;'><img height='60' src="/images/quickvoice.png" alt="Quick voice" class="m-2"></div>
                <h4 class="mb-4 mt-4"><?l($ProjectTitle) ?></h4>
                <div style="border-radius: 35px; background-color: #B5FFFB;padding: 3px;">
                    <h3 style="margin-top: 5px;color:#999"><b><?=ll('Welcome').' !'?></b></h3>
                </div>

                <? $form->start() ?>
                    <div>
                        <div style="text-align: left;font-size: 14px;margin-top:2rem;">
                        <?l('Don\'t have an account yet?')?>
                        <a href="<?path('qv.user.signup')?>" style="text-decoration: none;color:green;"><?l('Sign up here!')?></a>
                        </div >
                        <div class="input">
                            <label for="inputUsername"><?l('Username / Email')?></label>

                            <? $form->widget('username',[
                                'id' => 'inputUsername',
                                'value' => $last_username,
                            ], 'required autofocus', false, true) ?>
                            <span class="spin-box"></span>
                        </div>

                        <div class="input">
                            <label for="inputPassword"><?l('Password')?></label>
                            <? $form->widget('password',[
                                'id' => 'inputPassword'
                            ]) ?>
                            <span class="spin-box"></span>
                        </div>
                        </div>

                        <div id="error-box" style="margin-top:1rem;">
                        <?l($mssg) ?></div>

                        <input type="hidden" name="_csrf_token" value="<?= csrf_token('authenticate') ?>">

                        <div class="input">
                            <? $form->widget('remember_me') ?>
                            <!-- <label class="custom_checkbox_label">
                            <input type="checkbox" name="_remember_me">
                            <span class="check"></span>
                            <?l('Remember me')?>
                            </label> -->
                        </div>

                        <button class="btn mt-4 mb-3" type="submit">Sign in</button>

                        <div>

                            <a id="send-restore-email" href="javascript:void(0)" class="pass-forgot" style="text-align: right;font-size: 1rem;text-decoration: none;">
                                <?l('Forgot your password?')?>
                            </a>
                        </div>
                    </div>
                <? $form->end() ?>
            </div>
        </div>
    </div>

</div>
</section>

<footer>
</footer>

<script src="/js/app.js"></script>
<script src="/js/dmight/password_eye.js"></script>

<script type="text/javascript">

$(document).ready(function(){

    $('#login-box').addClass('visible-yes');

    // $("#inputUsername").focus();

    // $(".input input").focus(function() {
    $("#inputUsername,#inputPassword").focus(function() {
        // alert('Focus')
        //$('#error-box').html('');

        // $('label [for="inputUsername"]').css({
        //         "line-height": "18px",
        //         "font-size": "16px",
        //         "color": "lightgrey",
        //         "top": "-25px",
        //         "transition": "top 0.2s ease"
        //     });

        $(this).parent("div").parent(".input").each(function() {
        // $(this).parent("div .input").each(function() {
        //  alert('Parent');
            $("label", this).css({
                "line-height": "18px",
                "font-size": "16px",
                "color": "lightgrey",
                "top": "-25px",
                "transition": "top 0.2s ease"
            })
            $(".spin-box", this).css({
                "background-color": "red"
            })
        });
    }).blur(function() {
        $(".spin-box").css({
            "background-color": "black"
        })
        if ($(this).val() == "") {
            $(this).parent(".input").each(function() {
                $("label", this).css({
                "line-height": "24px",
                "font-size": "18px",
                "color": "grey",
                "top": "0px"
                })
            });

        }
    });

    // if($("#inputUsername").val() !== "") $("#inputUsername").focus();

});

</script>

</body>
</html>
