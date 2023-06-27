<div class='page_wrap'>

    <div class='row mb-4'>
        <a href="<?path('qv.transaction.index')?>" class="vertical_align_center col-md-4">
        <h1> <?l($Title) ?> </h1>
        </a>

    </div>

    <a class="btn" href="<? path($root . '.new') ?>"><?l('Create new')?></a>
    <? if (isset($plus_menu)): ?>
        <? foreach($plus_menu as $menuItem):  ?>
            <a class="btn" href="<?path( $menuItem['pathName'] )?>">
                &nbsp;<?= $menuItem['description']?>&nbsp;
            </a>
        <? endforeach ?>
    <? endif ?>

    <div class="tabs_wrapper">
        <div class="tabs">
            <span class="tab"><?l('Hour flow') ?></span>
            <span class="tab"><?l('System') ?></span>
            <span class="tab">
                <svg class="tab_svg_icon">
                    <use xlink:href="/images/icons/sprite.svg#settings"></use>
                </svg>
            </span>
        </div>
        <div class="tab_content">
            <div class="tab_item">
                <table id="grid-data" class="full_width fully_mobile mb-4">
                    <thead>
                        <tr>
                            <? foreach($FieldsEx as $field) : ?>
                                <th><?=$field['label'] ?></th>
                            <?  endforeach ?>
                            <th>
                                <?l('Actions') ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <? if(count($ItemsHCH) > 1): ?>
                    <? foreach($ItemsHCH as $atom ): $atom_id = $atom['id']?>
                        <tr id="rec-1-<?=$atom_id?>">
                            <? foreach($FieldsEx as $field) : ?>
                                <td><div class="table_label_mobile"><?=$field['label'] ?></div><?=$atom[$field['name']] ?></td>
                            <?  endforeach ?>
                            <td>
                                <div class="table_label_mobile"><?l('Actions') ?></div>
                                <a class="edit_row_icon" href="<? path($root . '.edit', ['id' => $atom_id]) ?>">
                                    <svg>
                                        <use xlink:href="/images/icons/sprite.svg#edit"></use>
                                    </svg>
                                </a>
                                <a class="undo_row_icon" href="<? path($root .'.undo', ['id' => $atom_id]) ?>">
                                    <svg>
                                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                    </svg>
                                </a>
                                <a class="delete_row_icon del-btn" data-id="<?=$atom_id?>" href="<? path($root .'.delete', ['id' => $atom_id]) ?>">
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
                            <td colspan="<?= (count($Fields) + 1) ?>"><?l('No records found') ?></td>
                        </tr>
                    <? endif ?>
                    </tbody>
                </table>

                <? include_view( DMIGHT.'template/pagination.html.php',[
                    'pagination'    => $pagination3,
                    'pages'        => $pages3,
                    'params'        => $params3,
                    'page'          => $page3,
                    'rootpages'     => $rootpages3,
                    'search'        => $search3,
                ]) ?>

            </div>

            <div class="tab_item">
                <table id="grid-data-2" class="full_width fully_mobile mb-4">
                    <thead>
                        <tr>
                            <? foreach($FieldsEx as $field) : ?>
                                <th><?=$field['label'] ?></th>
                            <?  endforeach ?>
                            <th>
                                <?l('Actions') ?>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <? if( count($ItemsElse) > 0): ?>
                    <? foreach( $ItemsElse as $atom ): $atom_id = $atom['id'] ?>
                        <tr id="rec-2-<?=$atom_id?>">
                            <? foreach($FieldsEx as $field) : ?>
                                <td><div class="table_label_mobile"><?=$field['label'] ?></div><?=$atom[$field['name']] ?></td>
                            <?  endforeach ?>
                            <td>
                                <div class="table_label_mobile"><?l('Actions') ?></div>
                                <a class="edit_row_icon" href="<? path($root . '.edit', ['id' => $atom_id ]) ?>">
                                    <svg>
                                        <use xlink:href="/images/icons/sprite.svg#edit"></use>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <? endforeach ?>
                    <? else : ?>
                        <tr>
                            <td colspan="<?= ( count($Fields) + 1) ?>"></td>
                        </tr>
                    <? endif ?>
                    </tbody>
                </table>
                <? include_view( DMIGHT.'template/pagination.html.php',[
                    'pagination'    => $pagination2,
                    'pages'        => $pages2,
                    'params'        => $params2,
                    'page'          => $page2,
                    'rootpages'     => $rootpages2,
                    'search'        => $search2,
                ]) ?>

            </div>
            <div class="tab_item">
                <table id="grid-data-3" class="full_width fully_mobile mb-4">
                    <thead>
                        <tr class=''>
                            <? foreach($FieldsEx  as $field):  ?>
                                <th><?=$field['label'] ?></th>
                            <?  endforeach  ?>
                            <th>
                                <div>
                                    <?l('Actions') ?>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <? if( count($Items) > 1): ?>
                    <? foreach($Items as $atom): $atom_id = $atom['id']?>
                        <tr id="rec-2-<?=$atom_id?>">
                            <? foreach($FieldsEx  as $field):  ?>
                                <td>
                                    <div class="table_label_mobile"><?=$field['label'] ?></div>
                                    <?= $atom[$field['name']] ?>
                                </td>
                            <?  endforeach ?>
                            <td>
                                <div class="table_label_mobile"><?l('Actions') ?></div>
                                <a class="edit_row_icon" href="<? path($root . '.edit', ['id' => $atom_id]) ?>">
                                    <svg>
                                        <use xlink:href="/images/icons/sprite.svg#edit"></use>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <? endforeach ?>
                    <? else : ?>
                        <tr>
                            <td colspan="<?= (count($Fields) + 1) ?>"></td>
                        </tr>
                    <? endif ?>
                    </tbody>
                </table>

                <? include( DMIGHT.'template/pagination.html.php') ?>

            </div>
        </div>
    </div>


</div>    

<div class="p-4"></div>
<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script src ="/js/toolskit/tabs-ctrl.js"></script>
<!-- <script src="/js/tabcontrol.js"></script> -->

<script type="text/javascript">
    var curr_tab = "1";
    $(document).ready(function(){

        $('#grid-data').on("click", ".del-btn", function (event) {

            const atom_id = $(this).data("id");
            const atom_name = $("#name"+atom_id).text();
            const url_path = $(this).attr('href');
            const csrf_token = $("#csrf_token"+atom_id).val();

            dmDialog({
                title: "<?l('Delete the object')?>",
                text: '<?l("Are you sure you want to delete this object?")?>'
     +'<br>'+'ID: '+atom_id+"<br>"+"<?l('Name') ?>: "+atom_name,
                ok: function() {
                    $.post(url_path, {
                            _token: csrf_token
                        }, (result)=> { // 
                            showResult( result, function(){
                                //alert('Back fire!!'+atom_id);
                                $("#rec-1-"+atom_id).remove();
                            });    
                        },'json');
                }
            });

            return false;
        });
    });
</script>