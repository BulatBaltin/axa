<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="/css/login.css">
    <link rel="stylesheet" href="/css/nstyles.css">
    <link rel="stylesheet" href="/css/bootstrap.css">
    <title>Error Handler</title>
</head>
<body>
<style>    
.td-left {
    text-align: left;
    padding:0.2rem 1rem;    
}
.td-right {
    text-align: right;
    padding:0.2rem 1rem;    
}
</style>    

<section class="main-content" style="background: url('/images/quickvoice_angle.png');">
<div class="page_wrap">

    <div id="login-box" class="modal-overlay visible-yes">
        <div id="login-panel" class="login-modal bg-white" style="left:calc(50% - 600px); max-width:1200px;width:1200px;">

            <div class="login_form" style="max-width:100%;padding: 2rem 1rem;">
                <div style="background: #ddd;"><img height='50' src="/images/quickvoice.png" alt="Quick voice" class="m-2"></div>
                <h3 class="mb-4 mt-4"><?= ll('Status code : ') . $code ?></h3>

<table style="border-collapse: collapse;font-size: 1.2rem;">
    <tbody>
<tr><td width="16%" class='td-left'><b><?l('Message')?></b></td><td class='td-left'><?=$message?></td></tr>
<tr><td width="16%" class='td-left'><b><?l('File')?></b></td><td class='td-left'><?=$file?></td></tr>
<tr><td width="16%" class='td-left'><b><?l('Line')?></b></td><td class='td-left'><?=$line?></td></tr>
    </tbody>
</table>
<div class="mb-4 mt-4" style="font-size: 1.2rem;">
    <b><a id='show-details' href='javascript:void(0)'><?l('Details')?></a></b>
</div>

<div id='error-details' 
<? if(!App::Config('DEBUG')) :?>
    style="display:none;"
<? endif ?>
>
<table style="table-layout: fixed; width: 100%; border-collapse: collapse;font-size: 1rem;" >
<tr style="border-bottom: 1px solid lightgrey; background: #eee;">
<th width="8%" style='padding:0.5rem;'>Line
<th width="20%">Function
<th>File
<!-- <th>Class -->
</tr>
<? foreach($trace as $step): 
    if(!isset($step['line'])) continue;
    ?>
<tr>
<td class='td-right'><?=$step['line'] ?>
<td class='td-left' style="word-wrap: break-word"><?=$step['function'] ?>
<td class='td-left' style="word-wrap: break-word"><?=$step['file'] ?>
<!-- <td style="word-wrap: break-word"><?//=$step['class'] ?> -->
</tr>
<? endforeach ?>
</table>
</div>

                <h4 class="mb-4 mt-4"><a href="
                <? if (isset($customer_hash)): ?>
                    <? path('qv.customer.site', [ 'id' => $customer_hash ] ) ?>
                <? elseif (isset($user_hash)): ?>
                    <? path('home') ?>
                <? else :?>
                    <? path('home') ?>
                <? endif ?>
                ">
                <strong><? l('Return to homepage') ?></strong></a></h4>
                <h4 class="mb-4 mt-4"><a  style="background:#777;color:white;padding:0.5rem 1rem;text-decoration: none;" href="<? path('app_login') ?>"><strong><? l('Login') ?></strong></a></h4>
            </div>
        </div>
    </div>

</div>
</section>

<footer>
    <a href="#" class="logo"></a>
    <div class="copyright">DianSoftware © 2019-<?=date('Y')?></div>
</footer>

<script src="/js/jquery-3.4.1.min.js"></script>
<script type="text/javascript">

    $(document).ready(function(){
        $('#show-details').click( function() { 
            $('#error-details').toggle(); 
        });
    });    
</script>

</body>
</html>
