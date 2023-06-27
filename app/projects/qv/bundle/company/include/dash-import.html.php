<div id="import-box" class="modal-overlay ">
    <div id="import-panel" class="menu-modal bg-white">
        <div id="btn-close-modal" class="menu-modal-close">
            <svg class="">
                <use xlink:href="/images/icons/sprite.svg#close"></use>
            </svg>
        </div>
        <a id="import-data" type="button" class="btn mb-2"
href="<?path('qv.dashboard.calcdata')?>"><? l('Import selected data') ?>
            <svg class="update_icon">
                <use xlink:href="/images/icons/sprite.svg#undo"></use>
            </svg>
        </a>
        <div id='mssg-box' class="mb-1"></div>
        <div style="overflow-y: auto;">
        <table class="full_width fully_mobile">
            <thead>
                <tr>
                    <th id="check-all" class="bg-bar" width='5%'>
                        <div class='round-spot m-1 ml-1 mt-3'>
                            <i id="check-all-i" class="far fa-check-square tb-check-icon"></i>
                        </div>
                    </th>
                    <th width="45%"></th>
                    <th width="25%">
                        <? l('Last Update') ?>
                    </th>
                    <th width="25%">
                        <? l('Notification') ?>
                    </th>
                </tr>
            </thead>
            <tbody>
                <? foreach($importRows as $item): ?>
                <tr>
                    <td class= "td-mark">

                        <div class='round-spot m-1 ml-1 mt-3'>
                            <i data-id="<?=$item['id']?>" class= "i-mark far fa-check-square tb-check-icon"
                            ></i>
                        </div>
                    </td>
                    <td>
                        <a href="<? path($item['path'])?>"><?=$item['name'] ?></a>
                    </td>
                    <td>
                        <div class="table_label_mobile"><? l('Last Update') ?></div>
                        <span id="time<?=$item['id'] ?>"><?=$item['time'] ?></span>
                    </td>
                    <td>
                        <div class="table_label_mobile"><? l('Notification') ?></div>
                        <? if ($item['status'] == 'ok'): ?>
                    <i id="i-note<?=$item['id']?>" class="fas fa-check mr-1" style="color: green;"></i>
                        <? else :?>
                    <i id="i-note<?=$item['id']?>" class="fas fa-exclamation-triangle" style="color: gray;"></i>
                        <? endif ?>

                        <span id="result<?=$item['id'] ?>"><?=$item['note'] ?></span>
                    </td>
                </tr>
                <? endforeach ?>
            </tbody>
        </table>
        </div>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function(){

    $('#import-data').click(function(){
        dmDialog({
            title:'Import data',
            text:'Import all data from Time tracking<br>and Accounting sources<br>for all developers',
            ok: function() { import_all(); }
            });

        return false;
    });

    $('#check-all').click(function(){
        if($('#check-all-i').hasClass('fa-check-square')) {
            $('#check-all-i').removeClass('fa-check-square');
            $('#check-all-i').addClass('fa-square');

            $('.i-mark').removeClass('fa-check-square');
            $('.i-mark').addClass('fa-square');
        } else {
            $('#check-all-i').removeClass('fa-square');
            $('#check-all-i').addClass('fa-check-square');

            $('.i-mark').addClass('fa-check-square');
            $('.i-mark').removeClass('fa-square');
        }
    });

    $('.td-mark').on('click', '.i-mark', function(){
        $(this).toggleClass('fa-check-square');
        $(this).toggleClass('fa-square');
    });

    // 
    function import_all() {
        let asist = ""; //{};
        // $('.on-check,.fa-check-square').each( function(){
        $('.i-mark').each( function(){
            if($(this).hasClass('fa-check-square')){
                let id = $(this).data('id');
                asist += id+',';
            }
        });
        // alert('asist: '+asist);
        if(asist) {
            ShowProcess();
            $.ajax({
                type: "POST",
                url: "<? path('dashboard.import') ?>",
                dataType: 'json',
                data: {
                    import: asist,
                },
                success: function (result) {
                    HideProcess();
                    var i;
                    var note;
                    var time;
                    for(i = 1; i < 8; i++) {
                        if(result.hasOwnProperty('mssg'+i)) {
                            note = result['mssg'+i];
                            time = result['time'+i];
                            $('#result'+i).text(note);
                            $('#time'+i).text(time);
                            indx = '#i-note'+i;
                            if(note.includes('[')) {
                                $(indx).removeClass('fa-check');
                                $(indx).addClass('fa-exclamation-triangle');
                                $(indx).prop('style', 'color: brown;');
                            } else {
                                $(indx).removeClass('fa-exclamation-triangle');
                                $(indx).addClass('fa-check');
                                $(indx).prop('style', 'color: green;');
                            }
                        }
                    }

                    $('#mssg-box').html( result.mssg );
                    setTimeout(function(){
                        $('#mssg-box').html('');
                    }, 5000);

                }
            });
        }
        return false;
    }
});
</script>