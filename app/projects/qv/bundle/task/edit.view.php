<div class='page_wrap'>


<div class="mb-4 mt-3" style='display:flex; align-items: center;'>

    <? if (isset($task_host) and $task_host ): ?> 
        <? $url_back = $task_host ?>
    <? elseif (isset($rootindex)) : ?> 
        <? $url_back = route( $rootindex ) ?>
    <? else :?>
        <? $url_back = route( $root . '.index') ?>
    <? endif ?>

    <? include_view(DMIGHT.'template/move-button.html.php', ['url_back'=> $url_back]) ?>

    <div>
    <h2 style="margin:1rem 4rem;"><?l($title)?></h2>

    <? if( !$is_new ) : ?>
<h6>
<a style="margin:0 4rem;" class="mb-4" target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$object['tid']?>">(#<?=$object['tid']?>)&nbsp;
<?= $object['task'] ?>
</a>
</h6>

<? endif ?>
    </div>
</div>

    <? $form->start('task') ?>
    <div hidden>
        <? $form->widget('id') ?>
    </div>

<div class="tabs_wrapper">
    <div class="tabs">
        <span class="tab"><?l('Overview')?></span>
        <span class="tab"><?l('Estimated time')?></span>
        <span class="tab"><?l('Actual time')?></span>
    </div>

    <div class="tab_content">
        <div class="tab_item" style="display: block">
            <div id="success-update">
            </div>
            <!-- <h3 class="mb-3"><?l('Basic information') ?></h3> -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <? foreach($pg11_list as $entry): ?>
                        <? $form->row($entry) ?>
                    <? endforeach ?>
                </div>
                <div class="col-md-4 mb-4">
                    <? foreach($pg11_list_2 as $entry): ?>
                        <? $form->row($entry) ?>
                    <? endforeach ?>
                </div>
                <div class="col-md-4 mb-4">
                    <? foreach($pg12_list as $entry): ?>
                        <? $form->row($entry) ?>
                    <? endforeach ?>
                </div>
            </div>
        </div>
        <div class="tab_item">
            <div class="row">
                    <div class="col-md-4 mb-4">
            <? foreach($pg2_list_1 as $entry): ?>
                <? $form->row($entry) ?>
            <? endforeach ?>
                    </div>
                    <div class="col-md-4 mb-4">
            <? foreach($pg2_list_2 as $entry): ?>
                <? $form->row($entry) ?>
            <? endforeach ?>
                    </div>
            </div>
        </div>
        <div class="tab_item">
            <div class="row">
                <div class="col-md-4 mb-4">
            <? foreach($pg3_list_1 as $entry): ?>
                <? $form->row($entry) ?>
            <? endforeach ?>
                </div>
                <div class="col-md-4 mb-4">
            <? foreach($pg3_list_2 as $entry): ?>
                <? $form->row($entry) ?>
            <? endforeach ?>
                </div>
            </div>
        </div>
    </div>

    <button id="update-1" type="submit" class="btn mb-3">
        <?l('Save changes') ?>
        <svg class="update_icon">
            <use xlink:href="/images/icons/sprite.svg#undo"></use>
        </svg>
    </button>

    <? $form->end() ?>

</div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script src ="/js/toolskit/tabs-ctrl.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        let func_update = function(event) {
            let form_data = $('form[name="task"]')[0];
            form_data = new FormData(form_data);
            // form_data.append('part', update_id);
            let url = "<? path('qv.task.save') ?>";
            $.ajax({ 
                method: "POST", dataType: 'json', data: form_data,
                cache: false, processData: false, contentType: false,
                url: url,
                success: function (result) {
                    // $('#tasklist_id').val(result.tasklist_id);
                    // ???
                    $('#success-update').html(result.mssg);
window.location.href = '<? path("qv.task.index") ?>';                            
                }
            })
            return false;
        };

        $("#update-1").click( func_update );

    });
</script>


