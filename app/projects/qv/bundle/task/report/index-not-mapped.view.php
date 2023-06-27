<div class='page_wrap'>

<div class="mb-4 mt-3" style='display:flex; align-items: center;'>
    <h2><?l($title)?></h2>
</div>

<div class="tabs_wrapper">
    <div class="tabs">
        <span class="tab"><strong><?l('Report')?></strong></span>
        <span class="tab"><?l('Rules')?></span>
    </div>
    <? $form->start('report_task') ?>
    <div>
        <?  $form->errors() ?>
        <div hidden>
            <?  $form->row('rulelist') ?>
            <?  $form->row('emaillist') ?>
        </div>
    </div>
    <div class="tab_content">
        <div class="tab_item" style="display: block">
            <div id="success-error-1">
            </div>
            <div class="row" style="padding-top:0.5rem;">
                <div class="col-md-3 mb-2">
                    <?  $form->row('xstart') ?>
                </div>

                <div class="col-md-2" style="padding-top:2rem;">
                    <? $form->row('isrules') ?>
                </div>

                <div class="col-md-2 mb-2" >
                    <? $form->row('limit') ?>
                </div>
                <div class="col-md-2 mb-2" >
                    <? $form->row('orderby') ?>
                </div>

                <div class="col-md-2 mb-2" >
                    <? if($form->user) :?>
                        <? $border = 'border:2px solid green;border-radius:4px;' ?>
                    <? else :?>
                        <? $border = '' ?>
                    <? endif ?>
                    <span id ="pick-user" class="custom_select" style='width:300px;<?=$border?>'>
                    <? $form->row('user')?>
                    </span>
                </div>
            </div>
            <div style="display:flex;">
                <button id="make-report" type="button" class="btn">
                    <?l('Report') ?>
                    <svg class="update_icon">
                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                    </svg>
                </button>
                <div id='n-records' style='margin-left:3rem;padding-top:0.8rem;'>
                </div>
            </div>
            <div>

<? include('report-not-mapped-grid.html.php') ?>

            </div>
        </div>
        <div class="tab_item">
            <div id="success-error-2">
            </div>
            <h3><?l('Rules to exclude')?></h3>

            <div class="row">
                <div class="col-md-6">
                    <div id="rule-list">
                        <? foreach( $vis_rules as $rule ): $rule_id = $rule['id']?>
                        <div class="mt-2" id="rule-<?=$rule_id?>" data-id="<?=$rule_id?>">
<i class="del-rule fas fa-user-check pointer" data-id="<?=$rule_id?>"></i>
<span class="ml-1"><?=$rule['name'] ?></span>
                        </div>
                        <? endforeach ?>
                    </div>
                    <div id="add-rule" class="form-group custom_select_wrap mt-3">
<label for="addrule"><i class="fas fa-user-plus mr-2"></i><?l('Assign Rule to exclude')?></label>
                        <? $form->widget('rules') ?>
                    </div>
                </div>
            </div>

            <button id="update-1" type="button" class="btn">
                <?l('Update') ?>
                <svg class="update_icon">
                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                </svg>
            </button>

        </div>
    </div>

    <? $form->end() ?>        
</div>
<div class="p-3">
</div>

<div class="p-3"></div>
<div class="p-3"></div>

</div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 
<script src ="/js/toolskit/tabs-ctrl.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        $("#make-report").click(function(){
            var form_data = $('form[name="report_task"]')[0];
            form_data = new FormData(form_data);

            $.ajax({ method: "POST", dataType: 'json', data: form_data,
                cache: false, processData: false, contentType: false,
                url: "<? path('qv.task.not-mapped-report') ?>",
                success: function (result) {
                    if(result.return == 'error')
                        $('#success-error-1').html(result.mssg);
                    else
                        $('#n-records').html(result.n_records);
                        $('#report-body').html(result.mssg);
                }
            });
            return false;

        });

        $("#update-1").click(function(){

            var list = '';
            $('#rule-list').find('.del-rule').each(function(){
                list += $(this).data('id')+',';        
            });
            $('#open_tasks_report_rulelist').val(list);

            var form_data = $('form[name="report_task"]')[0];
            form_data = new FormData(form_data);

            $.ajax({ method: "POST", dataType: 'json', data: form_data,
                cache: false, processData: false, contentType: false,
                url: "<? path('qv.task.opened-rules') ?>",
                success: function (result) {
                    $('#success-error-2').html(result.mssg);
                }
            });
            return false;
        });
        $("#update-2").click(function(){
            var list = '';
            $('#user-list').find('.del-worker').each(function(){
                list += $(this).data('id')+',';        
            });
            $('#open_tasks_report_emaillist').val(list);
            var form_data = $('form[name="report_task"]')[0];
            form_data = new FormData(form_data);
            
            $.ajax({ method: "POST", dataType: 'json', data: form_data,
                cache: false, processData: false, contentType: false,
                url: "<? path('tasks.opened-emails') ?>",
                success: function (result) {
                    $('#success-error-3').html(result.mssg);
                }
            });
            return false;
        });

// Start visibility ------------------------------------------- ]
        var list_adduser = '#open_tasks_report_adduser';

        $('#user-list').on('click', '.del-worker', function () {
            var id = $(this).data('id');
            $('#user-list').find('#worker-' + id).remove();
        });

        $(list_adduser).change(function () {
            var id = $(list_adduser + ' option:selected').val();
            var title = $(list_adduser + ' option:selected').text();
            if ($('#worker-' + id).length > 0) return;
            var newWorker = "<div class='mt-2' id='worker-" + id + "' data-id='" + id + "'>\
                    <i class='del-worker fas fa-user-check pointer' style='color:grey;' data-id='"+ id + "'></i>\
                    <span class='ml-1'>"+ title + "</span>\
                    </div>";

            $('#user-list').append(newWorker);
        });

// End email list
// Start rules
        $('#rule-list').on('click', '.del-rule', function () {
            var id = $(this).data('id');
            $('#rule-list').find('#rule-' + id).remove();
        });
        var list_rules = '#open_tasks_report_rules';
        $('#open_tasks_report_rules').change(function() {
            var id = $(list_rules + ' option:selected').val();
            if (id == '') return;
            var title = $(list_rules + ' option:selected').text();
            if ($('#rule-' + id).length > 0) return;
            var newRule = "<div class='mt-2' id='rule-" + id + "' data-id='" + id + "'>\
                    <i class='del-rule fas fa-user-check pointer' style='color:grey;' data-id='"+ id + "'></i>\
                    <span class='ml-1'>"+ title + "</span>\
                    </div>";

            $('#rule-list').append(newRule);
        });
// End rules

    });
</script>
