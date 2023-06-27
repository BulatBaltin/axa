<div class='page_wrap'>
    <div class='row mb-4'>
        <a href="<?path('qv.tasklist.index')?>" class="vertical_align_center col-md-4">
        <h1> <?l($Title) ?> </h1>
        </a>

        <div class="col-md-4 mb-3"  style="padding:0;">
        <span style="padding:10px 0;border-bottom:1px solid lightgrey;"><?l('Last import time')?> : <strong style="color:grey;"><?=$timeStart ?></strong></span>
        </div>
    </div>

    <div id="success-error">
    </div>

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
            <span><?l('Customer') ?>:</span>
            <div id ="pick-customer" class="custom_select" style='width:250px;'>
                <? $form->widget('customer',['id' => 'select-pick-customer']) ?>
            </div>
        </div>
        <div>
            <a href="<? path($root . '.edit', ['id' => 0]) ?>" class="btn green_btn">
            <?l('Add Tasklist') ?>
                <svg class="add_icon">
                    <use xlink:href="/images/icons/sprite.svg#plus"></use>
                </svg>
            </a>
        </div>
    </div>

    <table id="grid-data" class="full_width fully_mobile mt-4 mb-4">
        <thead>
            <tr>
                <th class="bg-bar p-0" width='5%'>
                    <div class='round-spot' id="i-markall">
                        <i class="far fa-square tb-check-icon"></i>
                    </div>
                </th>

                <? foreach($Fields as $field):  ?>
                    <th><?=$field['label'] ?></th>
                <?  endforeach ?>
                <th style='width:16rem;'>
                    <div>
                        <?l('Visibility')?>
                    </div>
                </th>
                <th style='width:10rem;'>
                    <div>
                        <?l('Actions')?>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
        <? $inx = 0 ?>
        <? if( count($Items) > 0 ): ?>
        <? foreach( $Items as $atom ): ?>
        <? $one_row = $form->rows[$inx]; $atom_id = $atom['id'] ?>
            <tr id="rec<?=$atom_id?>" class='tr-data'>

                <td class="p-0 hide_on_mobile cell-mark">
                    <div class='round-spot'>
                    <i data-id="<?=$atom_id?>" class="i-mark far fa-square tb-check-icon"></i>
                    </div>
                </td>
                <? $icol = 0 ?>
                <? foreach($Fields as $field): ?>
                    <? if ($icol == 1 ): ?>
                        <td class="td-customer custom_select_wrap" data-project-id=<?=$atom_id?> 
                        data-href="<?path('qv.tasklist.map-customer')?>" 
                        data-id="<?=$atom_id?>" id="customer<?=$atom_id?>">                        
                        
                        <div class="table_label_mobile"><?l($field['label']) ?></div> <? $one_row->widget('customer') ?></td>
                    <? else :?>
                        <td>
                            <div class="table_label_mobile"><?l('Project')?></div>
                            <?=$atom[$field['name']] ?>
                        </td>
                    <? endif ?>
                <? $icol++ ?>
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
                    <a href="<? path($root .'.edit', ['id'=> $atom_id]) ?>" class="edit_row_icon">
                        <svg>
                            <use xlink:href="/images/icons/sprite.svg#edit"></use>
                        </svg>
                    </a>
                    <a class="del-btn text-danger delete_row_icon" data-id="<?=$atom_id?>" href="<? path($root . '.delete', ['id' => $atom_id]) ?>">
                        <svg>
                            <use xlink:href="/images/icons/sprite.svg#bin"></use>
                        </svg>
                    </a>
                    <span id="name<?=$atom_id?>" hidden><?=$atom['name']?></span>
                    <input type="hidden" id="csrf_token<?=$atom_id?>" value="<?csrf_token('delete' . $atom_id)?>">
                </td>
            </tr>
        <? $inx++ ?>
        <? endforeach ?>
        <? else : ?>
            <tr>
                <td colspan="<?= (count($Fields) + 3) ?>"></td>
            </tr>
        <? endif ?>
        </tbody>
    </table>

    <? include( DMIGHT.'template/pagination.html.php') ?>

    <!-- <div class="mt-4 form-group hide_on_mobile">
        <select id="actions" class="p-2 form-control"> -->


    <div class="select_no_search hide_on_mobile mt-4">
        <select id="actions" class="p-2 form-control">
            <option value=""><?l('Actions') ?></option>
            <option value="import"><?l('Import from Time Tracking')?></option>
            <option value="remove"><?l('Remove selected tasklist')?></option>
        </select>
    </div>    
    
    <div id='mssg-box' style="padding: 1rem 0;"></div>
</div>    
<div class="p-4"></div>
    
<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">
    // const select_customer = "#project_customer_array_customer";
    const select_customer = "#select-pick-customer";
    var trigger_val = true;

    $(document).ready(function(){

        $(select_customer).change( function(event){
            var customer_id = $(this).val(); 
            goFilter(customer_id);
            return true;
        });
        
        function goFilter(customer_id) {
        var url = "<? path('qv.tasklist.filter',['search' => 'pattern', 'page'=> 1]) ?>";
        url = url.replace('pattern', customer_id); 
        window.location.href = url;                            
        } 

        $('#grid-data').on('change', '.td-customer', function(event){
            if(trigger_val == false) {
                trigger_val = true;
                return false;
            }
            var data_id = $(this).data('id');
            var url_path = $(this).data('href');
            var project_id = $(this).data('project-id');
            var selectBox = $(this).find('select');
            var customer_id = event.target.selectedOptions[0].value;
            if(project_id !== '0') {
                $.ajax({
                    type: "POST", 
                    url: url_path,
                    dataType: 'json',
                    data: {
                        item_id: data_id,
                        customer_id: customer_id,
                        tasklist_id: project_id
                    },
                    success: function (result) { // alert('Back fire');
                        $('#success-error').html(result.mssg);
                        if(result.return == 'error') {
                            trigger_val = false;
                            $(selectBox).val('').change();
                        }
                    }
                });
            }
            return false;
        });

        function ShowResultBox(result) {
            $('#mssg-box').html(result.mssg);
            setTimeout(function(){
                if(result.return == 'success') {
                    window.location.href = "<? path('qv.tasklist.index') ?>";                            
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

        $('#add-object').click(function(){
            window.location.href = '<?path("project.addnew")?>';                            
            return false;
        });

        function onImport(list, action) {
            ShowProcess();
            $.ajax({ type: "POST", dataType: 'json', url: "<? path('qv.tasklist.import') ?>",
                data: { list : list, action: action },
                success: function (result) {
                    window.location.href = "<?path('qv.tasklist.index')?>";                            
                }
            });
        }
        function onDeleting(list) {
            ShowProcess();
            $.ajax({ type: "POST", dataType: 'json', url: "<? path('qv.tasklist.deletelist') ?>",
                data: { list : list },
                success: function (result) {
                    window.location.href = "<?path('qv.tasklist.index')?>";                            
                }
            });
        }

        $('#actions').change(function(){
            var action = $('#actions option:selected').val();
            //var action = $(this).val();
            var list = "";

            $('#actions').val('');

            if(action == 'import') {
                dmDialog({
                    title: "<?l('Import projects') ?>", 
                    text: "<?l('Import projects from Time tracking Apps?') ?>", 
                    ok: function() { onImport(list, action) }
                });
                return false;
            }
            $('.i-mark').each(function(){
                if($(this).hasClass('fa-check-square')) {
                    let id = $(this).data('id');
                    list += id+',';
                }
            });
            if(action == 'remove' && list !== "") {
                dmDialog({
                    title:"<?l('Delete projects?') ?>",
                    text:"<?l('Are you sure you want to delete projects?') ?>",
                    ok: function() { onDeleting(list) }
                }); 
                return false;
            }
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
            var url = "<? path('qv.tasklist.search',['search'=> 'pattern']) ?>";
            url = url.replace('pattern', lookfor); 
            // alert(lookfor+ ' '+url);
            window.location.href = url;                            
        } 

<? include('js/toolskit/funcs.js') ?>
<? include('js/toolskit/marks.js') ?>

    });    
    // + -------------------------- Service functions ---------------------- +
    </script>
