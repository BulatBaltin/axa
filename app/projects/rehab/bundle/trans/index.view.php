<div style="padding:2rem;">

<h1><?= $title?></h1>
<hr>

<? $form->start('trans') ?>

<div style="display: flex; justify-content: space-between ; width: 800px;">
    <? $form->widget('check_all')?>
    <? $form->widget('lang')?>
</div>
<hr>
<div>
<? $ix = 0; foreach ($form->rows as $row_form) :?>
    <div style="display: flex;">

    <? $row_form->widget('check', ['name' => "check[$ix]", 'id' => "check[$ix]"])?>
    <? $row_form->widget('table', ['name' => "table[$ix]"])?>
    <? $row_form->widget('field', ['name' => "field[$ix]"])?>

    </div>
<? $ix++; endforeach ?>

<div style='padding: 2rem 0; display:flex;' > 
    <? $form->widget('fill_data', ['style' => 'margin-right:2rem;'])?>
    <? $form->widget('translate_data')?>
</div>

</div>
<div style="display: flex;">
<? $form->widget('keys',    ['id' => 'keys_id']) ?>
<? $form->widget('phrases', ['id' => 'phrases_id']) ?>
<? $form->widget('trans',   ['id' => 'trans_id']) ?>

</div>

<div id='html_textarea' style='padding: 2rem 0;'>
<?
module_partial('include/fill-textareas-trans.php',[
        'description' => [],
        'description_trans' => [],
        'test' => $description
    ]);
?>
</div>

<div style='padding: 2rem 0;' > 
    <? $form->widget('update') ?>
</div>

<? $form->end() ?>

<div id='mssg' style='padding: 2rem 0;'>
</div>

<script type="text/javascript"> 
$(document).ready(function(){

    // $('#summernote').summernote({
    // placeholder: 'fill the answer',
    // tabsize: 6,
    // height: 400
    // });


    $('#check-all').change(function(event){
        // let check = $(this).is(":checked");//$(this).attr('checked');
        let check = $(this).prop("checked");//$(this).attr('checked');

        $('.check-item').each(
            function() { $(this).prop('checked', check) }
        );
        // alert( check );
    });

    $('#translate-data').click(function(event){

        let url =       "<?path('rehab.trans.translate-data')?>";
        let formUp      = $('form[name="trans"]')[0];
        let form_inv    = new FormData(formUp);
        // alert('HERE '+url);

        $.ajax({
            method: "POST", url: url, dataType: 'json',
            cache: false, processData: false, contentType: false,
            data: form_inv,
            success: function(result) {
                $('#mssg').html(result.mssg);
                $('#trans_id').html(result.trans);
                $('#html_textarea').html(result.html_textarea);
            }
        });
    });
    $('#fill-data').click(function(event){

        let url =       "<?path('rehab.trans.fill-data')?>";
        let formUp      = $('form[name="trans"]')[0];
        let form_inv    = new FormData(formUp);

        $.ajax({
            method: "POST", url: url, dataType: 'json',
            cache: false, processData: false, contentType: false,
            data: form_inv,
            success: function(result) {
                $('#mssg').html(result.mssg);
                $('#keys_id').html(result.keys);
                $('#phrases_id').html(result.phrases);
                $('#html_textarea').html(result.html_textarea);
            }
        });
    });
    $('#update').click(function(event){

        let url =       "<?path('rehab.trans.update')?>";
        let formUp      = $('form[name="trans"]')[0];
        let form_inv    = new FormData(formUp);

        $.ajax({
            method: "POST", url: url, dataType: 'json',
            cache: false, processData: false, contentType: false,
            data: form_inv,
            success: function(result) {
                $('#mssg').html(result.mssg);
            }
        });
    });

});

</script> 

