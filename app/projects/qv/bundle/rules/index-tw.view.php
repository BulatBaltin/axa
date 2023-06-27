<div class='page_wrap'>

    <h2>
        <?l($title) ?>
    </h2>
    <h4 class="mt-4 mb-4">
        <?l($subtitle)?>
    </h4>
    <button id="add-object" type="button" data-method="payment"
            class="btn green_btn"><?l('Add Import Rule') ?>
        <svg class="add_icon">
            <use xlink:href="/images/icons/sprite.svg#plus"></use>
        </svg>
    </button>

    <? $form->start() ?>
    <div>
        <? $form->errors() ?>
    </div>
    <table id="grid-data" class="full_width fully_mobile mt-4 mb-4">
        <thead>
            <tr class='tr-header-grey'>

                <th class="bg-bar hide_on_mobile p-0" width='5%'>
                    <div class='round-spot' id="i-markall">
                        <i class="far fa-square tb-check-icon"></i>
                    </div>
                </td>

                <? foreach( $Fields as $field ): ?>
                    <th><?=$field['label'] ?></th>
                <?  endforeach ?>
                <th>
                    <div class='bg-action-white'>
                        <?l('Activated')?>
                    </div>    
                </th>
            </tr>
        </thead>
        <tbody>
            <? if( count($form->rows) > 0): ?>
                <? $inx = 0 ?>
            <? foreach( $form->rows as $atom ): ?>
                <? $entry = $Items[$inx] ; $entry_id = $entry['id']?>
                <tr id="rec<?=$entry_id ?>" class="tr-data">
                    <td class="p-0 hide_on_mobile cell-mark">
                        <div class='round-spot'>
                            <i data-id="<?=$entry_id?>" class="i-mark far fa-square tb-check-icon"></i>
                        </div>
                    </td>

                    <td data-id="<?=$entry_id?>" data-name="name">
                        <div class="table_label_mobile"><?l('Name') ?></div>
                        <? $atom->widget('name') ?>
                    </td>
                    <td data-id="<?$entry_id?>" data-name="field">
                        <div class="table_label_mobile"><?l('Field') ?></div>
                        <div class="mobile_full_width">
                            <div class="select_no_search"><? $atom->widget('field') ?></div>
                        </div>
                    </td>
                    <td data-id="<?$entry_id?>" data-name="operator">
                        <div class="table_label_mobile"><?l('Operator') ?></div>
                        <div class="mobile_full_width">
                            <div class="select_no_search"><? $atom->widget('operator') ?></div>
                        </div>
                    </td>
                    <td data-id="<?$entry_id?>" data-name="value">
                        <div class="table_label_mobile"><?l('Value') ?></div>
                        <? $atom->widget('value') ?>
                    </td>
                    <td>
                        <div class="table_label_mobile"><?l('Activated') ?></div>
                    <i id="icon-<?$entry_id?>" data-id="<?$entry_id?>"   
                    <? if ($entry['status'] == "activate"): ?>
                        class="ml-2 fas fa-check-circle big-icon-green"
                    <? else :?>
                        class="ml-2 fas fa-exclamation-circle big-icon-red"
                    <? endif ?>
                    ></i>
                    </td>
                </tr>
               <? $inx++ ?>
            <? endforeach ?>
            <? else : ?>
                <tr>
                    <td colspan="<?= (count($Fields) + 2) ?>"></td>
                </tr>
            <? endif ?>
        </tbody>
    </table>
    
    <? $form->end() ?>

    <? $save = 'Apply to Projects' ?>

    <div class="mt-4 form-group hide_on_mobile">
        <select id="actions" class="p-2 form-control">
            <option value=""><?l('Actions')?></option>
            <option value="activate"><?l('Activate selected rules') ?></option>
            <option value="deactivate"><?l('Deactivate selected rules') ?></option>
            <option value="remove"><?l('Remove selected rules')?></option>
        </select>
    </div>    

    <div class="p-4"></div>
    
</div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">

<? include('js/toolskit/funcs.js') ?>
<? include('js/toolskit/marks.js') ?>

$(document).ready(function(){

    var scheme;
    var action;

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

    $('#grid-data').on("change", ".tr-data td", function (event) {
        const rec = $(this).data('id');
        const name = $(this).data('name');
        var value;
        if(('field,client,operator').includes(name)) {
            value = $(this).find("select option:selected").val();
        } else {
            value = $(this).find('input').val();
        }
        // alert('id= '+rec+' '+name+' '+value);
        $.ajax({ type: "POST", dataType: 'json', url: "<? path('rules.updatefld') ?>",
            data: { rec: rec, name: name, value: value },
            success: function (r){}
        });

    });

    // + --------------- Press button Add item --------------------- + //

    $('#actions').change(function(){
        action = $('#actions option:selected').val();
        var list = "";

        $('#actions').val('');

        $('.i-mark').each(function(){
            if($(this).hasClass('fa-check-square')) {
                let id = $(this).data('id');
                list += id+',';
            }
        });
        if( action.includes('activate') && list !== "" ) {

            dmDialog({
                title: "<?l('Project mapping rules')?> :"+action,
                text: '<?l("Are you sure you want to change selected rules and apply them to projects mapping?")?>',
                ok: function() {
                    var header;
                    if(action == 'activate') {
                        header = "<?l('Map projects to customers') ?>";
                    } else {
                        header = "<?l('Unmap projects to customers') ?>";
                    }
                    $.ajax({ type: "POST", dataType: 'json', url: "<? path('rules.activate') ?>",
                        data: { list : list, action: action },
                        success: function (result) {
                            scheme = result.codes;
                            $('#modal-dlg').addClass('visible-yes');
                            $('#modal-header').html(header);
                            $("#modal-body").html( result.table);
                        }
                    });
                }
            });

        } else if(action=='remove' && list != "") {

            dmDialog({
                title: "<?l('Delete rules') ?>",
                text: "<?l('Are you sure you want to delete rules?') ?>",
                ok: function() {
                    $.ajax({ type: "POST", dataType: 'json', url: "<? path('rules.deletelist') ?>",
                        data: { list : list },
                        success: function (){ window.location.href="<?path('rules.index')?>" }
                    });
                }
            });
        }
        // window.location.href = "<?path('user.employees')?>";
        return false;
    });

    $('.close-modal,#btn-close-modal').click(function() {
        $('#modal-dlg').removeClass('visible-yes');
        return false;
    });
    $('#btn-save-modal').click(function() {
        $('#modal-dlg').removeClass('visible-yes');
        show_spinner();
        // alert(scheme);
        $.ajax({ type: "POST", dataType: 'json', url: "<? path('rules.mapping') ?>",
            data: { scheme : scheme, action : action },
            success: function (r){ 
                // alert(r.mssg); 
                window.location.href="<?path('rules.index')?>";
            }
        });
        return false;
    });
    function show_spinner(){
        $('#modal-shadow').addClass('visible-yes');
        $('#spinner').show();
    }
    function hide_spinner(){
        $('#spinner').hide();
        $('#modal-shadow').removeClass('visible-yes');
    }

    $('#add-object').click(function(){
        window.location.href = '<?path("rules.new")?>';                            
        return false;
    });

});    
</script>
