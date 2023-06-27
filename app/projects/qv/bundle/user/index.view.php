<div class='page_wrap'>

    <a href="<?path('qv.user.index')?>"><h1 class="mb-4"><?l($Title) ?></h1></a>

    <div class="table_actions d-flex">
        <div>
            <div class="search-box">
                <input class="" type="search" id="search-go" name="search-fld" placeholder="<?l('Search string')?>" value="<?=$search_string ?>">
                <svg class="search_icon" id="go-search">
                    <use xlink:href="/images/icons/sprite.svg#search"></use>
                </svg>
            </div>
        </div>
        <div>
            <button id="add-object" type="button" data-method="payment"
                    class="btn green_btn"><? l('Add Employee') ?>
                <svg class="add_icon">
                    <use xlink:href="/images/icons/sprite.svg#plus"></use>
                </svg>
            </button>
        </div>
    </div>

    <table id="grid-data" class="full_width fully_mobile mt-4 mb-4">
        <thead>
            <tr class='tr-header-grey'>
                <th class="bg-bar p-0" width='5%'>
                    <div class='round-spot' id="i-markall">
                        <i class="far fa-square tb-check-icon"></i>
                    </div>
                </th>

                <? foreach($Fields as $field):?>
                    <th><?=$field['label'] ?></th>
                <?  endforeach ?>
                <th style='width:12rem;'>
                    <div class='bg-action-white'>
                        <?l('Activated')?>
                    </div>
                </th>
                <th style='width:10rem;'>
                    <div class='bg-action'>
                        <?l('Actions')?>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <? if($Items):  ?>
            <? foreach($Items as $atom): 
                $atom_id = $atom['id']?>
                <tr id="rec<?=$atom_id?>" class='tr-data'>

                    <td class="p-0 hide_on_mobile cell-mark">
                        <div class='round-spot'>
                            <i data-id="<?=$atom_id?>" class="i-mark far fa-square tb-check-icon"></i>
                        </div>
                    </td>

<? foreach($Fields as $field):?>
    <td>
        <? if($atom['hash']):?>
            <a title='<?l("Developer's profile page")?>' class="row-href" data-id="<?=$atom_id?>" href="<? path('qv.dash-dev.site', ['id' => $atom['hash']]) ?>">

            <? if ($field['name'] == 'role') :?>
                <?=$roles[$atom[$field['name']]] ?>
            <? else :?>
                <?=$atom[$field['name']] ?>
            <? endif ?>
            </a>
        <? elseif ($field['name'] == 'role') :?>
            <?=$roles[$atom[$field['name']]] ?>
        <? else :?>
            <?=$atom[$field['name']] ?>
        <? endif ?>
    </td>

<? endforeach ?>
                    <td>
                        <div class="table_label_mobile"><?l('Activated')?></div>
                        <i id="icon-<?=$atom_id?>" data-id="<?=$atom_id?>"
                            <? if ($atom['status'] == "activate"): ?>
                                class="ml-2 fas fa-check-circle big-icon-green"
                            <? else :?>
                                class="ml-2 fas fa-exclamation-circle big-icon-red"
                            <? endif ?>
                        ></i>
                        <? if ($atom['sendmail']): ?>
                        <i id="icon-mail-<?=$atom_id?>" data-id="<?=$atom_id?>"
                                class="ml-2 fas  fa-envelope-square big-icon-blue"
                        ></i>
                        <? endif ?>
                    </td>
                    <td>
                        <div class="table_label_mobile"><?l('Actions')?></div>
                        <a href="<? path($root .'.edit', ['id'=> $atom_id]) ?>" class="edit_row_icon">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#edit"></use>
                            </svg>
                        </a>
                        <a class="del-btn text-danger delete_row_icon" data-id="<?=$atom_id?>" href="<? path($root .'.delete', ['id'=> $atom_id]) ?>">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#bin"></use>
                            </svg>
                        </a>
                        <span id="name<?=$atom_id?>" hidden><?=$atom['name']?></span>
                        <input type="hidden" id="csrf_token<?=$atom_id?>" value="<?csrf_token('delete' . $atom_id)?>">
                    </td>
                </tr>
            <? endforeach ?>
            <? else :?>
                <tr>
                    <td colspan="<?= (count ($Fields) + 1) ?>"></td>
                </tr>
            <? endif ?>
        </tbody>
    </table>

    <? include(DMIGHT.'template/pagination.html.php')?> 

    <div class="select_no_search hide_on_mobile mt-4">
        <select id="actions" class="form-control">
            <option value="">-- <?l('Actions') ?> --</option>
            <option value="activate"><?l('Activate marked') ?></option>
            <option value="deactivate"><?l('Deactivate marked') ?></option>
            <option value="remove"><?l('Remove marked entries') ?></option>
        </select>

    </div>
    <div id='mssg-box' style="padding: 1rem 0;"></div>
    <div class="p-4"></div>
</div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">
    $(document).ready(function(){

        function ShowResultBox(result) {
            $('#mssg-box').html(result.mssg);
            setTimeout(function(){
                if(result.return == 'success') {
                    window.location.href = "<? path('qv.user.index') ?>";                            
                } else {
                    $('#mssg-box').html('');
                }
            }, 4000);
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

        function onDeleting(list) {
            ShowProcess();
            $.ajax({ type: "POST", dataType: 'json', url: "<? path('qv.user.deletelist') ?>",
                data: { list : list },
                success: function (result) {
                    window.location.href = "<?path('qv.user.index')?>";                            
                }
            });
        }

        //$('#actions option:selected').change(function(){
        $('#actions').on('click',function(){
            // $('#actions').val('');
        });
        $('#actions').change(function(){
            var action = $('#actions option:selected').val();
            var list = "";

            $('#actions').val('');

            $('.i-mark').each(function(){
                if($(this).hasClass('fa-check-square')) {
                    let id = $(this).data('id');
                    list += id+',';
                    let icon = "#icon-"+id;
                    if(action == 'activate') {
                        if($(icon).hasClass('fa-exclamation-circle')) {
                            $(icon).removeClass('fa-exclamation-circle big-icon-red');
                            $(icon).addClass('fa-check-circle big-icon-green');
                        }
    
                    } else if(action == 'deactivate'){
                        if($(icon).hasClass('fa-check-circle')) {
                            $(icon).removeClass('fa-check-circle big-icon-green');
                            $(icon).addClass('fa-exclamation-circle big-icon-red');
                        }

                    }
                }
            });
            if(list !== "" && (action == 'activate' || action == 'deactivate' )) {
                $.ajax({
                    type: "POST",
                    dataType: 'json',
                    url: "<? path('worker.activate') ?>",
                    data: {
                        list : list,
                        action: action,
                    },
                    success: function (result) {
                    }
                });
            } else if(list !== "" && action == 'remove') {
                dmDialog({
                    title: "<?l('Delete user(s) / employee(s)') ?>",
                    text: "<?l('Are you sure you want to delete user(s) / employee(s)?') ?>",
                    ok: function() { onDeleting(list) }
                    }); 
                return false;
            }
            return false;
        });

        $('#add-object').click(function(){
            window.location.href = '<?path("worker.new")?>';                            
            return false;
        });
        $('#go-search').click(function(){
            goSearch();
            return false;
        });
        $('#search-go').change(function(){
            goSearch();
            return false;
        });

        function goSearch() {
            var lookfor = $('#search-go').val();
            var url = "<? path('qv.user.search',['search'=>'pattern']) ?>";
            url = url.replace('pattern', lookfor); 
//            alert('Search: ' + url); 
            window.location.href = url;                            

        } 

// Start Marks -----------------------------------------
        <? include('js/toolskit/delrow.js') ?>
        <? include('js/toolskit/marks.js') ?>
// End Marks -------------------------------------------

    });    
</script>
