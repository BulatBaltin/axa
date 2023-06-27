<div class='page_wrap'>

<h1 class="mb-5"><?l($Title) ?></h1>

<table id="grid-data" class="mb-4 full_width fully_mobile">
    <thead>
        <tr class='tr-header'>
            <? foreach($Fields as $field): ?>
                <th <? if(isset($field['style'])) echo ('style="'.$field['style'].'"') ?> ><?=$field['label'] ?></th>
            <?  endforeach ?>
            <th style='width:8rem;'>
                <?l('Actions')?>
            </th>
        </tr>
    </thead>
    <tbody>
        <? if(count($Items) > 0):?>
        <? foreach($Items as $atom): $atom_id = $atom['id']?>
            <tr id="rec<?=$atom_id?>">
                <? foreach($Fields as $field): ?>
                    <td>
                        <div class="table_label_mobile"><?l($field['label']) ?></div>
                        <?=$atom[$field['name']] ?>
                    </td>
                <?  endforeach ?>
                <td>
                    <div class="table_label_mobile"><?l('Actions')?></div>
                    <div class="nowrap">
                        <a href="<? path($root . '.edit', ['id'=> $atom_id]) ?>" class="edit_row_icon">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#edit"></use>
                            </svg>
                        </a>
                        <a class="delete_row_icon" data-id="<?=$atom_id?>" href="<? path($root . '.delete', ['id' => $atom_id]) ?>">
                            <svg>
                                <use xlink:href="/images/icons/sprite.svg#bin"></use>
                            </svg>
                        </a>
                    </div>
                    <span id="name<?=$atom_id?>" hidden><?=$atom['name']?></span>
                    <input type="hidden" id="csrf_token<?=$atom_id?>" value="<?csrf_token('delete' . $atom_id)?>">
                </td>
            </tr>
        <? endforeach ?>
        <? else :?>
            <tr>
                <td colspan="<?=(count($Fields) + 1) ?>"></td>
            </tr>
        <? endif ?>
    </tbody>
</table>

<a class="btn" href="<? path($root . '.new') ?>"><?l('Create new') ?><i class="fas fa-plus-circle ml-2"></i></a>
<? if (isset($plus_menu)): ?>
    <? foreach ($plus_menu as $menuItem):?>
        <span>
            <a class="btn btn-success" href="<?path( $menuItem['pathName'] )?>">
                &nbsp;<?=$menuItem['description'] ?>&nbsp;
            </a>
        </span>
    <? endforeach ?>
<? endif ?>

</div>    
<div class="p-4"></div>
    
<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">
$(document).ready(function(){
    $('#grid-data').on("click", ".delete_row_icon", function (event) {
        const atom_id = $(this).data("id");
        const atom_name = $("#name"+atom_id).text();
        let goon = confirm('<?l("Are you sure you want to delete this object?")?>'+"\r\nid/name:"+atom_id+"/"+atom_name);
        if (goon) {
            var url_path = $(this).attr('href');
            var csrf_token = $("#csrf_token"+atom_id).val();
            $.post(url_path, {
                    _token: csrf_token
                }, function(result) { //
                    //renderResult( result, function(){
                    renderResult( result, function(){
                        // alert('Back fire ?');
                        $("#rec"+atom_id).remove();
                    });    
                },'json');
        };
        return false;
    });
});    
// + -------------------------- Service functions ---------------------- +
    </script>
