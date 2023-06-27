<div class='page_wrap'>

<h1><? l($title) ?></h1>
<div class="tabs_wrapper">
    <div class="tabs">
        <span class="tab"><? l($subtitle2) ?></span>
        <span class="tab"><? l('Operations') ?></span>
    </div>
    <div class="tab_content">
        <div class="tab_item">
            <p class="mb-3"><? l($subtitle) ?></p>
            <? $form->start() ?>
            <div>
                <? $form->errors() ?>
            </div>
            <? $form->widgetAll() ?>

            <button id="update-1" type="submit" class="btn">
                <? l('Update') ?>
                <svg class="update_icon">
                    <use xlink:href="/images/icons/sprite.svg#undo"></use>
                </svg>
            </button>
            <? $form->end() ?>
        </div>

        <div class="tab_item">
            <h4><? l('Operations') ?></h4>
            <div id="mssg-package" class="mb-2">
            </div>

            <ul class="accordion">
                <li>
                    <a class="toggle" href="javascript:void(0);">
                        <svg class="arrow_down">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                        1. <?l('Archive / Activate the year') ?>
                    </a>
                    <div class="inner">
                        <div class='comment'>
                        <?l('Operation is recommended at the start of the new year when last year data have been handled already. Only submitted invoices are used.') ?>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-md-3'>
                                <div class='d-flex justify-content-between'>

                                    <?$form2->widget('archive_year')?>
                                    <span>&nbsp;&nbsp;</span>
                                    <?$form2->widget('archiveop')?>
                                </div>
                            </div>
                            <div class='col-md-4'>
                                <button class="btn btn-info ml-2" id="archive-activate" type="button" class="btn">
                                    <? l('Operation')?>
                                    <svg class="update_icon">
                                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a class="toggle" href="javascript:void(0);">
                        <svg class="arrow_down">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                        2. <? l('Hours & Goods check') ?>
                    </a>
                    <div class="inner">
                        <div class='comment'>
                        <? l('Validation of time tracking data is done') ?>
                        </div>

                        <div class='row mb-3'>
                            <div class='col-md-3'>
                                <?$form2->widget('hours_date')?>
                            </div>

                            <div class='col-md-4'>
                                <button class="btn btn-info ml-2" id="hours-goods" type="button" class="btn">
                                    <? l('Operation')?>
                                    <svg class="update_icon">
                                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <a class="toggle" href="javascript:void(0);">
                        <svg class="arrow_down">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                        3. <? l('Gather Invoice goods by task ID (tid)') ?>
                    </a>
                    <div class="inner">
                        <div class='comment'>
                        <? l('View all goods with a given task ID (tid)') ?>
                        </div>
                        <div class='row mb-3'>
                            <div class='col-md-3'>
                                <?$form2->widget('tid')?>
                            </div>

                            <div class='col-md-4'>
                                <button class="btn btn-info ml-2" id="gather-task" type="button" class="btn">
                                    <? l('Operation')?>
                                    <svg class="update_icon">
                                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <a class="toggle" href="javascript:void(0);">
                        <svg class="arrow_down">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                        4. <? l('Current operation') ?>
                    </a>
                    <div class="inner">
                        <div class='comment'>
                        <? l('Administrator only') ?><br>
                        <br>1 - Change start / stop time in invoice goods. Set invoice tag 'S' (submitted) / 'I'
                        <br>2 - Set period (yyyy-mm-dd) to start date in time entries
                        <br>3 - Set period (yyyy-mm-dd) to start date in invoice goods
                        <br>4 - Test Job queue
                        <br>5 - Reset Task(nl) to have a date and #Id
                        <br>6 - Test getTasksDueDate() from Teamwork; set date to test it
                        </div>
                        <div class='row mb-6'>
                            <div class='col-md-6'>
                                <div class='d-flex justify-content-between'>

                                    <?$form2->widget('link_date')?>
                                    <?$form2->widget('action')?>
                                    <button class="btn btn-info ml-2" id="link-items" type="button" style='display:flex;'>
                                    <?l('Operation')?>&nbsp;&nbsp;
                                    <svg class="update_icon" style='margin-top:1px;'>
                                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                    </svg>
                                </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <a class="toggle" href="javascript:void(0);">
                        <svg class="arrow_down">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                        5. <? l('Remove notifications before') ?>
                    </a>
                    <div class="inner">
                        <div class='comment'>
                            <? l('Remove notifications before') ?>
                        </div>
                        <div class='row mb-5'>
                            <div class='col-md-3'>
                                <div class='d-flex justify-content-between'>

                                    <?$form2->widget('notes_date')?>
                                </div>
                            </div>

                            <div class='col-md-4'>
                                <button class="btn btn-info ml-2" id="notes-items" type="button" class="btn">
                                    <? l('Operation')?>
                                    <svg class="update_icon">
                                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>

                <li>
                    <a class="toggle" href="javascript:void(0);">
                        <svg class="arrow_down">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                        6. <? l('Import all data') ?>
                    </a>
                    <div class="inner">
                        <div class="mb-2">

                            <h2 class="vertical_align_center col-md-6">
                                <div class="update_icon_link mr-3" id="action-import-all">
                                    <svg class="update_icon">
                                        <use xlink:href="/images/icons/sprite.svg#update"></use>
                                    </svg>
                                </div>
                                <? l('Import all data') ?>
                            </h2>
                        </div>
                    </div>
                </li>

                <li>
                    <a class="toggle" href="javascript:void(0);">
                        <svg class="arrow_down">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                        7. <? l('Import user defined data') ?>
                    </a>
                    <div class="inner">
                        <div class="mb-2">

                            <h2 class="vertical_align_center col-md-6">
                                <div class="update_icon_link mr-3" id="action-import">
                                    <svg class="update_icon">
                                        <use xlink:href="/images/icons/sprite.svg#update"></use>
                                    </svg>
                                </div>
                                <? l('Import user defined data') ?>
                            </h2>

                        </div>
                    </div>
                </li>

                <li>
                    <a class="toggle" href="javascript:void(0);">
                        <svg class="arrow_down">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                        8. <? l('Tracking ID (sysid) request')?> 
                    </a>
                    <div class="inner">
                        <div class="mb-2">
                            <div class='d-flex'>
                                <?$form2->widget('phrase')?>
                            
                                <button class="btn btn-info ml-2" id="test-dutch" type="button" class="btn">
                                    <? l('Operation')?>
                                    <svg class="update_icon">
                                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <a class="toggle" href="javascript:void(0);">
                        <svg class="arrow_down">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                        9. <? l('Translate to dutch from period')?> 
                    </a>
                    <div class="inner">
                        <div class="mb-2">
                            <div class='d-flex'>
                                <?$form2->widget('trans_date')?>
                            
                                <button class="btn btn-info ml-2" id="trans-dutch" type="button" class="btn">
                                    <? l('Translate')?>
                                    <svg class="update_icon">
                                        <use xlink:href="/images/icons/sprite.svg#undo"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

        </div>

        <div class="tab_item"></div>
    </div>
</div>

<!-- {# </------------- Footer ------------------ #} -->

    <!-- <div id="import-box" class="modal-overlay ">
        <div id="import-panel" class="menu-modal bg-white">
            <div id="btn-close-modal" class="menu-modal-close">
                <svg class="">
                    <use xlink:href="/images/icons/sprite.svg#close"></use>
                </svg>
            </div>
            <a id="import-data" type="button" class="btn mb-2"
    href="<?path('dashboard.calcdata')?>"><? l('Import selected data') ?>
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
    </div> -->
</div>
<? include('include/dash-import.html.php') ?>

<div class='p-2'></div>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script src="/js/toolskit/tabs-ctrl.js"></script>
<script type="text/javascript">

$(document).ready(function(){

    function getStrDate() {
        let root = '#company_unmapped_trans_date_'; //company_unmapped_trans_date_date_day
        return combineOnlyDate(root);
    }
    function getStrDate2() {
        let root = '#company_unmapped_link_date'; //company_unmapped_trans_date_date_day
        return $(root).val();
    }
    function getStrNotesDate() {
        let root = '#company_unmapped_notes_date'; //company_unmapped_trans_date_date_day
        return $(root).val();
    }
    function getStrDate3() {
        let root = '#company_unmapped_hours_date_'; //company_unmapped_trans_date_date_day
        return combineOnlyDate(root);
    }
    function getOnlyMonth() {
        let root = '#company_unmapped_hours_date_'; //company_unmapped_trans_date_date_day
        let day = combineOnlyDate(root);
        return day.substring(0,7);
    }
    function combineOnlyDate(root) {
        let day = '0'+ $(root+'day').val();
        let mon = '0'+ $(root+'month').val();
        let strDateTime = $(root+'year').val() +"-"+
            mon.substr(mon.length - 2)+"-"+
            day.substr(day.length - 2);
        return strDateTime;
    }
    function combineDate(root) {
        let day = '0'+ $(root+'_day').val();
        let mon = '0'+ $(root+'_month').val();
        let hour = '0'+ $(root+'_hour').val();
        let mins = '0'+ $(root+'_minute').val();
        let strDateTime = $(root+'_year').val() +"-"+
            mon.substr(mon.length - 2)+"-"+
            day.substr(day.length - 2)+" "+
            hour.substr(hour.length - 2)+":"+
            mins.substr(mins.length - 2)+":00";
        return strDateTime;
    }

    $('#action-import-all,#import-data').click(function(){
        dmDialog({
            title:'Import data',
            text:'Import all data from Time tracking<br>and Accounting sources<br>for all developers',
            ok: function() { import_all(); } // func_import
            });
    });   
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
                url: "<? path('qv.dashboard.import') ?>",
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
    
    $('#test-dutch').click(function(){
        let phrase = $('#company_unmapped_phrase').val();
        dmDialog({
            title: 'Teamwork test',
            text: 'Tracking ID (sysid) request?' + '<br>#' + phrase,
            ok: function() { onTestDutch( phrase )}
        });
    });   
    function onTestDutch( phrase ) {
        ShowProcess();
        $.ajax({
            type: "POST",
            url: "<? path('company.test-dutch') ?>",
            dataType: 'html',
            data: { 
                phrase: phrase
            },
            success: function (mssg) {
                HideProcess();
                ShowResult(mssg);
            }
        });        
    }

    $('#notes-items').click(function(){
        var period = getStrNotesDate();
        dmDialog({
            title: 'Remove Notifications',
            text: 'Remove Notifications up to' + '<br>' + period,
            ok: function() { onRemoveNotify( period )}
        });
    });   
    function onRemoveNotify( period, action ) {
        ShowProcess();
        $.ajax({
            type: "POST",
            url: "<? path('company.notes-remove') ?>",
            dataType: 'html',
            data: { period: period },
            success: function (mssg) {
                HideProcess();
                ShowResult(mssg);
            }
        });        
    }

    $('#link-items').click(function(){
        var period = getStrDate2();
        var action = $('#company_unmapped_action').val();
        dmDialog({
            text: 'Action-'+action+'<br>Data handling?' + '<br>' + period,
            ok: function() { onLinkItems( period, action )}
        });
    });   
    function onLinkItems( period, action ) {
        ShowProcess();
        $.ajax({
            type: "POST",
            url: "<? path('company.link-items') ?>",
            dataType: 'html',
            data: { period: period, action: action },
            success: function (mssg) {
                HideProcess();
                ShowResult(mssg);
            }
        });        
    }
    $('#archive-activate').click(function(){
        let year = $('#company_unmapped_archive_year').val();
        let action = $('#company_unmapped_archiveop').val();
        dmDialog({
            title: action + ' ' + year + ' year',
            text: action + ' ' + year + ' year Invoices ?',
            ok: function() { onArchiveActivate( year, action )}
        });
    });
    function onArchiveActivate(year, action) {
        ShowProcess();
        $.ajax({
            type: "POST",
            url: "<? path('company.archive-activate') ?>",
            dataType: 'json',
            data: { 
                year: year, action: action
            },
            success: function (result) {
                HideProcess();
                ShowResult(result.mssg);
            }
        });        
    }

    $('#hours-goods').click(function(){
        var period = getOnlyMonth();
        dmDialog({
            text: 'Check invoice items with import hours items for period?' + '<br>' + period,
            ok: function() { onHoursGoodsItems( period ) }
        });
    });   
    $('#gather-task').click(function(){
        var period = getStrDate3();
        var tid = $('#company_unmapped_tid').val();
        dmDialog({
            text: 'Check invoice items with import hours items for period?' + '<br>' + period,
            ok: function() { onGatherTask(period, tid )}
        });
    });   
    function onGatherTask( period, tid ) {
        ShowProcess();
        $.ajax({
            type: "POST",
            url: "<? path('company.gather-task') ?>",
            dataType: 'html',
            data: { 
                period: period, tid: tid
            },
            success: function (mssg) {
                HideProcess();
                ShowResult(mssg);
            }
        });        
    }
    function onHoursGoodsItems( period ) {
        ShowProcess();
        $.ajax({
            type: "POST",
            url: "<? path('company.hours-goods') ?>",
            dataType: 'html',
            data: { 
                period: period
            },
            success: function (mssg) {
                HideProcess();
                ShowResult(mssg);
            }
        });        
    }
    $('#trans-dutch').click(function(){
        dmDialog({
            text: 'Translate data to Dutch from the set date?' + '<br>' + getStrDate(),
            ok: function() { onTransDutch( getStrDate() )}
        });
    });   
    function onTransDutch( period ) {
        ShowProcess();
        $.ajax({
            type: "POST",
            url: "<? path('company.trans-dutch') ?>",
            dataType: 'html',
            data: { 
                period: period
            },
            success: function (mssg) {
                HideProcess();
                ShowResult(mssg);
            }
        });        
    }

    $('#action-import').click(function(){
        // Show import panel
        $('#import-box').removeClass('visible-no');
        $('#import-box').addClass('visible-yes');
    });   
    $('#btn-close-modal').click(function(){
        // Hide import panel
        $('#import-box').removeClass('visible-yes');
        $('#import-box').addClass('visible-no');
    });   

    function ShowResultBox(result) {
        $('#mssg-box').html(result.mssg);
        setTimeout(function(){
            $('#mssg-box').html('');
        }, 5000);
    }
    function ShowResult(mssg) {
        $('#mssg-package').html(mssg);
    }

// packages
    // {# $('#package-2').click(function(){
    //     if(confirm('This will apply 2020-10-20 package') == false) return false;
    //     var url = "<? path('company.package20201020') ?>";
    //     ShowProcess();
    //     $('#mssg-package').load(
    //         url, 
    //         {},
    //         function(){
    //             HideProcess();
    //             // alert('Package is done');
    //         });
    //     return false;
    // });
    // $('#package-1').click(function(){
    //     if(confirm('This will apply 2020-09-09 package') == false) return false;
    //     var url = "<? path('company.package20200909') ?>";
    //     ShowProcess();
    //     $('#mssg-package').load(
    //         url, 
    //         {},
    //         function(){
    //             HideProcess();
    //             // alert('Package is done');
    //         });
    //     return false;
    // }); #}

});

</script>
