<div class='page_wrap'>

    <a href="<?path('qv.task.index')?>"><h1 class="mb-4"><?l($Title) ?></h1></a>

    <div class="table_actions d-flex">
        <div style='margin-right:10px;'>
            <? if ($search_string) : ?>
                <? $border = 'border:2px solid orange;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>
            <div class="search-box" style='<?=$border?>'>
                <input class="" type="search" id="search-go" name="search-fld" placeholder="Search string" value="<?=$search_string ?>">
                <svg class="search_icon" id="go-search">
                    <use xlink:href="/images/icons/sprite.svg#search"></use>
                </svg>
            </div>
        </div>
        <div>
            <span><?l('Status') ?>:</span>
            <? if ($form->status) : ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-status" style='<?=$border?>'>
                <? $form->widget('status',['id' => 'task_status'])?>
            </span>
        </div>
        <div style='margin-right:10px;'>
            <span><?l('Task Lists') ?>:</span>
            <? if ($form->tasklist) :?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else : ?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-tasklist" class="custom_select" style='width:200px;<?=$border?>'>
                <? $form->widget('tasklist',['id' => 'task_tasklist']) ?>
            </span>
        </div>
        <div style='margin-right:10px;'>
            <span><?l('Project') ?>:</span>
            <? if ($form->projecten) : ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-projecten" class="custom_select" style='width:200px;<?= $border?>'>
                <? $form->widget('projecten',['id' => 'task_projecten']) ?>
            </span>
        </div>
        <div style='margin-right:10px;'>
            <span><?l('Customer') ?>:</span>
            <? if ($form->customer) : ?>
                <? $border = 'border:2px solid green;border-radius:4px;' ?>
            <? else :?>
                <? $border = '' ?>
            <? endif ?>
            <span id ="pick-customer" class="custom_select" style='width:300px;<?=$border?>'>
            <? $form->widget('customer',['id' => 'task_customer']) ?>
            </span>
        </div>
        <div>
            <button id="add-object" type="button" data-method="payment"
            class="btn green_btn"><?l('Add') ?>
                <svg class="add_icon">
                    <use xlink:href="/images/icons/sprite.svg#plus"></use>
                </svg>
            </button>
        </div>
    </div>

    <table id="grid-data" class="full_width fully_mobile mt-4 mb-4">
        <thead>
            <tr class='tr-header-grey'>
                <th class="bg-bar hide_on_mobile p-0" width='5%'>
                    <div class='round-spot' id="i-markall">
                        <i class="far fa-square tb-check-icon"></i>
                    </div>
                </td>

                <th width='20%'><?l('Task')?></th>
                <? foreach( $Fields as $field ) : ?>
                    <th><?= $field['label'] ?></th>
                <?  endforeach ?>
                <th>
                    <?l('Use estimated hours')?>
                </th>
                <th>
                    <?l('Completed')?>
                </th>
                <th>
                    <div>
                        <?l('Actions')?>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <? if( count($Items) > 0 ) : ?>
            <? foreach( $Items as $atom ) : $atom_id = $atom['id']?>
                <tr id="rec<?=$atom_id?>" class='tr-data'>
                    <td class="p-0 hide_on_mobile cell-mark">
                        <div class='round-spot'>
                            <i data-id="<?=$atom_id?>" class="i-mark far fa-square tb-check-icon"></i>
                        </div>
                    </td>

                    <td>
                        <div class="table_label_mobile"><?l('Task') ?></div>
                        <? if ($site_root and $atom['tid']): ?>
    <a class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$atom['tid']?>">(#<?=$atom['tid']?>)&nbsp;
                            <?=$atom['task']?>
                            </a>
                            <? if($site_root and $atom['parent_tid']): ?>
                                &nbsp;(<a style="color:green" class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$atom['parent_tid']?>"><?l('Parent task') ?> #<?=$atom['parent_tid']?></a>)
                            <? endif ?>
                        <? else :?>
                            <?= $atom['task'] ?>
                        <? endif ?>
                    </td>

                    <? foreach( $Fields as $field ) : ?>
                        <td>
                            <div class="table_label_mobile"><?=$field['label'] ?></div>
                            <?= (
                                isset($field['date']) ?
                                date('d/m/y H:i', strtotime($atom[$field['name']])) :
                                $atom[$field['name']] 
                                ) ?>
                        </td>
                    <?  endforeach ?>
                    <td>
                        <div class="table_label_mobile"><?l('Use estimated hours') ?></div>

                        <i id="icon-<?=$atom_id?>" data-id="<?=$atom_id?>"
                            <? if ( $atom['estimated'] ) : ?>
                                class="fas fa-check-circle big-icon-green"
                            <? else :?>
                               class="fas fa-exclamation-circle big-icon-red"
                            <? endif ?>
                        ></i>
                    </td>
                    <td>
                        <div class="table_label_mobile"><?l('Status') ?></div>

                        <i id="icon-<?=$atom_id?>" data-id="<?=$atom_id?>"
                            <? if ( $atom['completed'] ): ?>
                                class="fas fa-check-circle big-icon-green"
                            <? else :?>
                               class="fas fa-exclamation-circle big-icon-red"
                            <? endif ?>
                        ></i>
                    </td>
                    <td>
                        <div class="table_label_mobile"><?l('Actions')?></div>
                        <a href="<? path($root . '.edit', ['id' => $atom_id]) ?>" class="edit_row_icon">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#edit"></use>
                            </svg>
                        </a>
                        <a class="del-btn text-danger delete_row_icon" data-id="<?=$atom_id?>" href="<? path($root . '.delete', ['id' => $atom_id ]) ?>">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#bin"></use>
                            </svg>
                        </a>
                        <span id="name<?=$atom_id?>" hidden><?=$atom['task']?></span>
                        <input type="hidden" id="csrf_token<?=$atom_id?>" value="<?csrf_token('delete' . $atom_id)?>">
                    </td>
                </tr>
            <? endforeach ?>
            <? else : ?>
                <tr>
                    <td colspan="<?=(count($Fields) + 3) ?>"></td>
                </tr>
            <? endif ?>
        </tbody>
    </table>

    <? include( DMIGHT.'template/pagination.html.php') ?>

    <div class="mt-4 select_no_search hide_on_mobile">
        <select id="actions" class="p-2 form-control">
            <option value=""><?l('Actions')?></option>
            <option value="complete"><?l('Set marked tasks as Completed')?></option>
            <option value="incomplete"><?l('Set marked tasks as Incompleted')?></option>
            <option value="remove"><?l('Remove marked entries')?></option>
            <option value="import"><?l('Import from Time tracking')?></option>
        </select>
    </div>
    <div id='mssg-box' style="padding: 1rem 0;"></div>
</div>
<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">

    const select_filter = "#search-go,#task_status,#task_customer,#task_tasklist,#task_projecten";

    <? include('js/toolskit/funcs.js') ?>
    <? include('js/toolskit/marks.js') ?>

    $(document).ready(function(){

        $(select_filter).change( function(event){
            goFilters();
            return true;
        });    

        $('#search-go').on('keypress',function(e) {
            if(e.which == 13) {
                goFilters();
                return false;
            }
        });        

        function goFilters() {
            let customer_id     = $('#pick-customer select').val(); 
            let tasklist_id     = $('#pick-tasklist select').val(); 
            let projecten_id    = $('#pick-projecten select').val(); 
            let status          = $('#pick-status select').val(); 
            let search          = $('#search-go').val();

            let url;
            if(!tasklist_id && !status && !customer_id && !projecten_id && !search) {
                url = "<? path('qv.task.index')?>";
            }  else {

        <? //autoescape 'js' ?>
                url = "<? path('qv.task.filter', [ 'search' =>'p_search','tasklist_id' => 'p_tasklist', 'customer_id' => 'p_customer', 'projecten_id' => 'p_projecten', 'status' => 'p_status', 'page' => 1 ]) ?>";
        <? //endautoescape ?>            
                url = removeEmptyParts(url, 
                    ['search', 'customer_id', 'tasklist_id', 'projecten_id', 'status'], 
                    [ search,   customer_id,   tasklist_id, projecten_id, status]);

                url = url.replace('p_search', search); 
                url = url.replace('p_tasklist', tasklist_id); 
                url = url.replace('p_projecten', projecten_id); 
                url = url.replace('p_customer', customer_id); 
                url = url.replace('p_status', status); 
            }
            window.location.href = url;                            
        } 

        function ShowResultBox(result) {
            $('#mssg-box').html(result.mssg);
            setTimeout(function(){
                if(result.return == 'success') {
                    window.location.href = "<? path('qv.task.index') ?>";                            
                } else {
                    $('#mssg-box').html('');
                }
            }, 4000);
        }

        function onImport(list, action) {
            ShowProcess();
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<? path('qv.task.import') ?>",
                data: { list : list, action: action },
                success: function (result) {
                    window.location.href = "<?path('qv.task.index')?>";                            
                }
            });
            return;
        }

        function onDeleting(list) {
            ShowProcess();
            $.ajax({ type: "POST", dataType: 'json', url: "<? path('qv.task.deletelist') ?>",
                data: { list : list },
                success: function (result) {
                    HideProcess();
                    ShowResultBox(result);                        
                }
            });
        }

        $('.tr-data').on('click', '.cell-mark', function () {
            let that = $(this).find('.i-mark');
            if ($(that).hasClass('fa-check-square')) {
                $(that).removeClass('fa-check-square');
                $(that).addClass('fa-square');
            } else {
                $(that).removeClass('fa-square');
                $(that).addClass('fa-check-square');
            }
        });

        function getMarkedList() {
            let list = '';
            $('.i-mark').each(function(){
                if($(this).hasClass('fa-check-square')) {
                    let id = $(this).data('id');
                    list += id+',';
                }
            });
            return list;
        }
        function setCompletedTasks( list, action) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "<? path('qv.task.complete') ?>",
                data: {
                    list : list,
                    action: action,
                },
                success: function (result) {
                    setMarks( action );
                    // alert("result: "+result['return']);
                    // console.log(result);
                    //renderErrorResult(result);
                    //window.location.href = "<?path('user.employees')?>";                            
                }
            });
        }

        function setMarks( action ) {
            $('.i-mark').each(function(){
                if($(this).hasClass('fa-check-square')) {
                    let id = $(this).data('id');
                    let icon = "#icon-"+id;
                    if(action == 'complete') {
                        if($(icon).hasClass('fa-exclamation-circle')) {
                            $(icon).removeClass('fa-exclamation-circle big-icon-red');
                            $(icon).addClass('fa-check-circle big-icon-green');
                        }
    
                    } else if(action == 'incomplete') {
                        if($(icon).hasClass('fa-check-circle')) {
                            $(icon).addClass('fa-exclamation-circle big-icon-red');
                            $(icon).removeClass('fa-check-circle big-icon-green');
                        }
    
                    } else {
                        if($(icon).hasClass('fa-check-circle')) {
                            $(icon).removeClass('fa-check-circle big-icon-green');
                            $(icon).addClass('fa-exclamation-circle big-icon-red');
                        }

                    }
                }
            });
        } 

        $('#actions').change(function(){
            var action = $('#actions option:selected').val();
            //var action = $(this).val();
            var list = "";
            list = getMarkedList();

            $('#actions').val('');

            if (list !== "") {
            
                if( action == 'import') {
                    dmDialog({
                        title:"<?l('Import tasks')?>",
                        text:"<?l('Import new tasks from Time tracking app')?>",
                        ok: function() { onImport(list, action) }
                        });

                } else if (action == 'complete') {
                    dmDialog({
                        title: "<?l('Mark as Completed tasks')?>",
                        text: "<?l('Do you want to set marked tasks as Completed?')?>",
                        ok: function() {
                            setCompletedTasks(list, action);
                        }
                    });
                } else if (action == 'incomplete') {
                    dmDialog({
                        title: "<?l('Mark as Incomplete tasks')?>",
                        text: "<?l('Do you want to set marked tasks as Incomplete?')?>",
                        ok: function() {
                            setCompletedTasks(list, action);
                        }
                    });
                } else if (action == 'remove') {
                    dmDialog({
                        title: "<?l('Remove marked tasks')?>",
                        text: "<?l('Are you sure you want to delete tasks?')?>",
                        ok: function() {
                            onDeleting(list);
                        }
                    });

                }
            }
            return false;
        });

        $('#add-object').click(function(){
window.location.href = '<? path("qv.task.edit",['id' => 0]) ?>';                            
            return false;
        });
    });    
    // + -------------------------- Service functions ---------------------- +
    </script>

