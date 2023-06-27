<div class='page_wrap'>


    <h1 class="mb-4"><a href="<?path('qv.client.index')?>" style='font-size:2rem;'><?l($Title) ?></a></h1>

    <div class="table_actions d-flex">
        <div>
            <div class="search-box">
                <input class="" type="search" id="search-go" name="search-fld" placeholder="<?l('Search string') ?>" value="<?=$search_string ?>">
                <svg class="search_icon" id="go-search">
                    <use xlink:href="/images/icons/sprite.svg#search"></use>
                </svg>
            </div>
        </div>

        <div>
            <button id="add-object" type="button" data-method="payment"
            class="btn green_btn"><? l('Add Customer') ?>
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

                <? foreach($Fields as $field) : ?>
                    <th><?=$field['label'] ?></th>
                <?  endforeach ?>
                <th>
                    <div class='bg-action-white'>
                        <?l('Visibility')?>
                    </div>
                </th>
                <th>
                    <div>
                        <?l('Actions')?>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            <? if( count($Items) > 0 ) : 
             foreach( $Items as $atom ) : 
                $atom_id = $atom['id'];
                $atom_name = $atom['name'];
                $atom_hash = $atom['hash'];
                ?>
                <tr id="rec<?=$atom_id?>" class='tr-data'>
                    <td class="p-0 hide_on_mobile cell-mark">
                        <div class='round-spot'>
                            <i data-id="<?=$atom_id?>" class="i-mark far fa-square tb-check-icon"></i>
                        </div>
                    </td>

                    <? foreach($Fields as $field): ?>
                        <td>
                            <div class="table_label_mobile"><?=$field['label']?></div>
                        <? if ($atom_hash): ?>
                            <a title='<?l("Customer's profile page")?>' class="row-href" data-id="<?=$atom_id?>" href="<? path('qv.dash-customer.site', ['id'=> $atom_hash]) ?>">
                                <?=$atom[$field['name']]?>
                            </a>
                        <? else: ?>
                            <?=$atom[$field['name']]?>
                        <? endif ?>

                        </td>
                    <?  endforeach ?>
                    <td>
                        <div class="table_label_mobile"><?l('Visibility')?></div>
                        <span id="icon-<?=$atom_id?>" data-id="<?=$atom_id?>">
                        <? if ($atom['visibility'] == ""): ?>
                            <?l('All')?>
                        <? else :?>
                            <?l('Selected')?>
                        <? endif ?>
                        </span>
                    </td>
                    <td>
                        <div class="table_label_mobile"><?l('Actions')?></div>
                        <a title="<?l('Edit Customer')?>" href="<? path($root .'.edit', ['id'=> $atom_id]) ?>" class="edit_row_icon">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#edit"></use>
                            </svg>
                        </a>
                        <a class="del-btn text-danger delete_row_icon" data-id="<?=$atom_id?>" href="<? path($root .'.delete', ['id'=> $atom_id]) ?>">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#bin"></use>
                            </svg>
                        </a>
                        <? if($atom_hash): ?>
                        <a title='<?l("Customer's profile page")?>' class="text-danger delete_row_icon" data-id="<?=$atom_id?>" href="<? path('qv.customer.site', ['id'=> $atom_hash]) ?>">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#eye"></use>
                            </svg>
                        </a>
                        <? endif ?>
                        <span id="name<?=$atom_id?>" hidden><?=$atom_name?></span>
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
    <? include(DMIGHT.'template/pagination.html.php')?> 

    <div class="select_no_search hide_on_mobile mt-4">
        <select id="actions" class="form-control">
            <option value=""><?l('Actions')?></option>
            <option value="remove"><?l('Remove marked entries')?></option>
            <option value="import"><?l('Import from accounting')?></option>
        </select>
    </div>

</div>

<div id='mssg-box' style="padding: 1rem 0;"></div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">
    $(document).ready(function(){

        function ShowResultBox(result) {
            $('#mssg-box').html(result.mssg);
            setTimeout(function(){
                if(result.return == 'success') {
                    window.location.href = "<? path('client.index') ?>";                            
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
                url: "<? path('client.import') ?>",
                data: { list : list, action: action },
                success: function (result) {
                    window.location.href = "<?path('client.index')?>";                            
                }
            });
            return;
        }

        function onDeleting(list) {
            ShowProcess();
            $.ajax({ type: "POST", dataType: 'json', url: "<? path('client.deletelist') ?>",
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

        $('#actions').change(function(){
            var action = $('#actions option:selected').val();
            //var action = $(this).val();
            var list = "";

            $('#actions').val('');

            if( action == 'import') {
                dmDialog({
                    title:'Import new customers',
                    text:'Import new customers from<br>Accounting app',
                    ok: function () { onImport(list, action); }
                });

            }
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
    
                    } else {
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
                            // alert("result: "+result['return']);
                            // console.log(result);
                        //renderErrorResult(result);
                        //window.location.href = "<?path('user.employees')?>";                            
                    }
                });
            } else if(list !== "" && action == 'remove') {
                dmDialog({
                    title:'Delete customer(s)',
                    text:'Are you sure you want to<br>delete customer(s)?',
                    ok: function () { onDeleting(list); }
                });
            }
            return false;
        });

        $('#add-object').click(function(){
            window.location.href = '<?path("client.addnew")?>';                            
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
            var url = "<? path('qv.client.search',['search'=>'pattern' ]) ?>";
            url = url.replace('pattern', lookfor); 
//            alert('Search: ' + url); 
            window.location.href = url;                            

        } 

// Start Delete db-table row ---------------------------
        <? include('js/toolskit/delrow.js') ?>
// Start Marks -------------------------------------------
        <? include('js/toolskit/marks.js') ?>
// End Marks -------------------------------------------
        <? include('js/toolskit/result.js') ?>

    });    
    // + -------------------------- Service functions ---------------------- +
    </script>


<script type="text/javascript">

    $(document).ready(function(){
        $('.btn-smart--').click(function(){
            alert( $(this).data('href'));
        });

        $('.del-btn').click(function(){
            let title = $(this).data('projecten-name');
            let token = $(this).data('token');
            let proj_id = $(this).data('id');
            let url = "<? path('qv.project.delete', [ 'id'=> 'proj_id']) ?>";
            url = url.replace('proj_id', proj_id);

            dmDialog({
                title: "<? l('Delete projecten') ?>",
                text: "<? l('Delete projecten and update linked data?') ?>"+"<br>"+title,
                ok: function() {
                    ShowProcess();
                    $.ajax({
                        method: "POST", dataType: 'json', 
                        url: url, 
                        data: { token: token},

                        success: function (result) {
                            HideProcess();
                            if(result.return == 'success') {
                                $('#note-grid').html( result.mssg );
                                window.location.href="<?path('qv.project.index')?>";     
                            }
                        }
                    });
                }
            });

            return false;
        });

    });

</script>
