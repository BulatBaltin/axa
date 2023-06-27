<div class='page_wrap'>

<div class="mb-4 mt-3" style='display:flex; align-items: center;'>
    <? $url_back = route('qv.tasklist.index') ?>
    <? include_view(DMIGHT.'template/move-button.html.php', ['url_back'=> $url_back]) ?>

    <h2 style="margin:0 4rem;"><?l($title)?></h2>
</div>

<div class="tabs_wrapper">
    <div class="tabs">
        <span class="tab"><?l('Overview')?></span>
        <span class="tab"><?l('Visibility')?></span>
    </div>
    <? $form->start('tasklist') ?>
    <div>
        <? $form->errors() ?>
        <div hidden>
            <? $form->widget('id') ?>
            <? $form->widget('visibility',['id'=> 'tasklist_list']) ?>
        </div>
    </div>
    <div class="tab_content">
        <div class="tab_item" style="display: block">
            <div id="success-update-1">
            </div>
            <h3 class="mb-3"><?l('Basic information') ?></h3>
            <div class="row">
<!-- {# Basic info ------- #} -->
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="customer"><?l('Tasklist name')?></label>
                        <? $form->widget('name') ?>
                    </div>
                    <div class="form-group">
                        <label for="customer"><?l('Customer mapped to the Tasklist')?></label>
                        <? $form->widget('customer') ?>
                    </div>
                    <div class="form-group">
                        <label for="pid"><?l('Tasklist Time Tracking ID (pid)')?></label>
                        <? $form->widget('pid') ?>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="form-group">
                        <label for="description"><?l('Description')?></label>
                        <? $form->widget('description')?>
                    </div>
                    <div class="form-group">
                        <label for="grouppa"><?l('Group (not empty - Multy customer)')?></label>
                        <? $form->widget('grouppa')?>
                    </div>
                </div>
            </div>
            <button name='update-1' id="update-1" type="submit" class="btn">
                <?l('Update') ?>
                <svg class="update_icon">
                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                </svg>
            </button>
        </div>
<!-- {# End Basic info ------- #} -->
        <div class="tab_item">
            <div id="success-update-2">
            </div>
            <h3><?l('Visibility')?></h3>
            <div class="row">
                <div class="col-md-6">
                    <div id="user-list">
                        <? foreach($vis_workers as $worker): $worker_id = $worker['id'] ?>
                        <div class="mt-2" id="worker-<?=$worker_id?>" data-id="<?$worker_id?>">
                            <i class="del-worker fas fa-user-check pointer" data-id="<?$worker_id?>"></i>
                            <span class="ml-1"><?=$worker['name'] ?></span>
                        </div>
                        <? endforeach ?>
                    </div>
                    <div id="add-user" class="mt-4 custom_select_wrap form-group">
                        <label for="adduser"><i class="fas fa-user-plus mr-2"></i><?l('Assign Employee to Tasklist')?></label>
                        <? $form->widget('adduser', ['id' => 'tasklist_adduser']) ?>
                    </div>
                </div>
            </div>

            <button name='update-2' id="update-2" type="submit" class="btn">
                <?l('Update') ?>
                <svg class="update_icon">
                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                </svg>
            </button>
            <!-- {# End tab  #} -->
        </div>
    </div>
    <? $form->end() ?>        
    </div>

    <div class="p-3"></div>
    <? include_view(DMIGHT.'template/move-button.html.php', ['url_back'=> $url_back]) ?>
</div>

<div class="p-3"></div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script src ="/js/toolskit/tabs-ctrl.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        let func_update = function(event) {
            // var form_data = $('form [name="tasklist"]').serialize();
            let update_id = $(this).attr('id');
            let list = '';
            let prefix = '';
            $('#user-list').find('.del-worker').each(function(){
                list += prefix + $(this).data('id');
                prefix = ',';        
            });
            $('#tasklist_list').val(list);

            let form_data = $('form[name="tasklist"]')[0];
            form_data = new FormData(form_data);
            form_data.append('part', update_id);

            $.ajax({ 
                method: "POST", dataType: 'json', data: form_data,
                cache: false, processData: false, contentType: false,
                url: "<? path('qv.tasklist.update-basic', ['id' => $object['id'] ]) ?>",
                success: function (result) {
                    // $('#tasklist_id').val(result.tasklist_id);
                    $('#success-'+update_id).html(result.mssg);
                }
            })
            return false;
        };

        $("#update-1").click( func_update );
        $("#update-2").click( func_update );

// Start visibility -------------------------------------------
        var list_adduser = '#tasklist_adduser';
        <? include('js/toolskit/visibility.js') ?>
// End visibility -------------------------------------------

    });
</script>


