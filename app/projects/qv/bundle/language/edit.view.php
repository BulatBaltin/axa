<div class='page_wrap'>

    <div class='p-2'>
    </div>
    <div class='p-2 mb-2' style="background: whitesmoke;">
    <h3><?l($Title)?> <span style='font-weight: bold; color: #888'><?=$language['name']?></span></h3>
    </div>

    <div style="border: 1px solid green; border-radius: 5px;padding:1rem 2rem;margin-bottom: 1rem;">
    <span>
    The contents of the left box can be translated with external services (e.g. <a href="https://translate.google.com/"> https://translate.google.com </a>) and the result should be copied to the right text area box.
    </span><br>
    <span>
    Lines should correspond to each other.
    </span><br>
    <span>
    It is recommended to take the left box contents (English key-phrases) from Dutch language (full version)
    </span>
    </div>

    <? $form->start() ?>
    <div style="display: flex;">
        <? $form->row('name') ?>&nbsp;&nbsp;
        <? $form->row('code') ?>
    </div>

<div class="p-1">
<table width="100%">
<tr>
<td width="50%" class="p-2">
<td width="50%" class="p-2">
    <? $form->widget('ucfst') ?>
</tr>
</table>

<table width="100%">
<tr height="200">
<td width="50%" class="pr-2">
    <? $form->widget('text1') ?>

<td width="50%" class="pl-2">
    <? $form->widget('text2') ?>
</tr>
</table>
</div>

<div class="p-2">
</div>
<div class="bg-light p-2">
    <table width="100%" style='border:0'>
        <tr>
        <td style="text-align: left;">
<div>
<?include_view(DMIGHT.'template/move-button.html.php',['url_back'=> route($root . '.index')]) ?>
</div>
        <td width="10%">
            <button class="btn btn-primary"><?l(($button_label ?? 'Save')) ?></button>
<? $form->end() ?>        
        <td align="right">
        <? if( isset($del_btn) or isset($delete) ): 
            $note = ll('Are you sure you want to delete this object?');
            ?>
<form method="post" action="<? path($root . '.delete', ['id' => $object['id']]) ?>" 
onsubmit="return confirm('<?=$note?>')">
    <input type="hidden" name="_method" value="DELETE">
    <input type="hidden" name="_token" value="<? csrf_token('delete' . $object['id']) ?>">
    <button class="btn btn-outline-danger btn-sm"><?l('Delete') ?></button>
</form>
        <? endif ?>
    </tr>
    </table>
</div>   

</div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">
$(document).ready(function(){

});

</script>

