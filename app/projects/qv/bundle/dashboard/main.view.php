<div class='page_wrap'>
    <div class="row">
        <div class="col-md-6 mb-5">
            <div class="row">
                <h1 class="vertical_align_center col-md-6">
                    <a id="refresh" name="refresh" class="mr-3 update_icon_link" 
href="<?path('qv.dashboard.calcdata')?>">
                        <svg class="update_icon">
                            <use xlink:href="/images/icons/sprite.svg#update"></use>
                        </svg>
                    </a>
<? l($title) ?>
                </h1>
                <div class="col-md-6" style="display:block;margin:auto;">
                    <div><?l('Last update')?> :</div>
                    <div class="bordered_bottom_date" style="padding:5px 0;"><b>
<?= $TimeRefresh ?></b>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-5">
            <div class="row">
                <h2 class="vertical_align_center col-md-6">
                    <div class="update_icon_link mr-3" id="action-import-all">
                        <svg class="update_icon">
                            <use xlink:href="/images/icons/sprite.svg#update"></use>
                        </svg>
                    </div>
<? l('Import data') ?>
                </h2>

                <div class="col-md-6" style="display:block;margin:auto;">
                    <div><?l('Last update')?> :</div>
                    <div class="bordered_bottom_date" style="padding:5px 0;"><b>
<?= $TimeRefresh ?></b>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <? include('main/include/charts-original.html.php') ?>
    <? include('main/include/dash-disbalance.html.php') ?>
    <? include('main/include/dash-employee-hours.html.php') ?>
    <? include('main/include/dash-hours-to-pay.html.php') ?>
    <? include('main/include/dash-fixed-hours.html.php') ?>

<!-- {---- Footer ---- } -->
    <div id='refresh-box' class="modal-overlay z1000">
        <div id="spinner" class="loader"></div>
    </div>
</div>

<? include('main/include/dash-import.html.php') ?>

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">

    $(document).ready(function(){

// const style = getComputedStyle(document.body);
// const theme = {
//   primary: style.getPropertyValue('--primary'),
//   secondary: style.getPropertyValue('--secondary')
// };        
//  alert($('body').css('background-color'));

        $('#id_pay_period').change( function() {
            let period = $(this).val();
            let customer = $('#id_pay_customer').val();
            $('#hours-to-pay-body').load( 
                "<?path('qv.dashboard.hours-pay-body')?>",
                { 
                    period: period,
                    customer: customer
                },
                function() {
                }
            );
        });

        $('#id_pay_customer').change( function() {
            let customer = $(this).val();
            let period = $('#id_pay_period').val();
            $('#hours-to-pay-body').load( 
                "<?path('qv.dashboard.hours-pay-body')?>",
                { 
                    period: period,
                    customer: customer
                },
                function() {
                }
            );
        });

        $('#id_fixedhours').change( function() {
            let completed = $(this).val();
            let url = "<?path('qv.dashboard.fx-hours-body')?>";
            $.ajax({
                type: "post", url: url, dataType: 'json',
                data: { completed: completed },
                success: function (result) {
                    $('#fx-hours-body').html(result.htmlGrid);
                    $('#fx-hours-total').html(result.htmlTotal);
                }
            });
        });
// 
        $('#id_bal_period').change( function() {
            var period = $(this).val();
            let url = "<? path('qv.dashboard.period-body') ?>"; 
            // alert('id_bal_period '+period + url);
            $.ajax({
                type: "post", url: url, dataType: 'json',
                data: {
                    period: period
                },
                success: function (result) {
                    $('#period-body').html(result.t_body);
                    $('#show-period').html(result.say_period);
                }
            });
        });

        // jQuery('#x-datetimepicker').datepicker({
        //     dateFormat: "dd/mm/yy"
        // });

        $('#dmform_x-date_id').on('change', function(){
            show_spinner();
            $('#tb-box').load( "<?path('qv.dashboard.site-span')?>",
                { 
                    start_day: $(this).val(),
                    span: "total-all" 
                },
                function(){
                    hide_spinner();
                }
            );
        });

// this is not used 'total-*'
// $('#tb-box').on('click',"[id^='total-']",function(){
//     $('#tb-box').load( ...path('qv.dashboard.site-span'...),
//         { 
//             start_day: $('#x-datetimepicker').val(),
//             span: $(this).attr('id') 
//         } 
//     );
// })

        $('#action-import-all').click(function(){
            dmDialog({
                width: "450px",
                left: "calc(50vw - 225px)",
                title:"<?l('Import all data') ?>",
                text:
"<div style='font-size:1.1rem;'><?l('Import all data')?><br>&nbsp;&blacksquare;&nbsp;<?l('Time tracking')?><br>&nbsp;&blacksquare;&nbsp;<?l('Accounting systems')?><br>&nbsp;&blacksquare;&nbsp;<?l('All developers')?></div>",
                ok: function() { import_all() }
                });

            return false;
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
                // ShowProcess();
                show_spinner();
                $.ajax({
                    type: "POST",
                    url: "<? path('dashboard.import') ?>",
                    dataType: 'json',
                    data: {
                        import: asist,
                    },
                    success: function (result) {
                        // HideProcess();
                        hide_spinner();

                        if(result['return'] == 'queue') {
                            dmInfoDialog({ title: "<?l('Import all data')?>", text: result['mssg'] });

                        } else {
                            var i;
                            var note;
                            var time;
                            for(i = 1; i < 7;i++) {
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
                        }
                    }
                });
            }
            return false;
        }

        $('#refresh').click(function() {
            dmDialog({
                title:"<?l('Refresh')?>",
                text: "<?l('Refresh dashboard data')?>",
                ok: function(){ show_spinner(); window.location.href="<?path('qv.dashboard.calcdata')?>"; }
            });
            return false; // remove std href handling
        });

        $('#action-import').click(function(){
            // Show import panel
            $('#import-box').addClass('visible-yes');
        });   


    function show_spinner(){
        $('#refresh-box').addClass('visible-yes');
        $('#spinner').show();
    }
    function hide_spinner(){
        $('#spinner').hide();
        $('#refresh-box').removeClass('visible-yes');
    }

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
    //
    $('#tb-box').on('click', '#i-sort',  function() {
        const $sort_table_icon =  $('#i-sort svg');
        $sort_table_icon.toggleClass("arrow_down");
        $sort_table_icon.toggleClass("arrow_up");
        if($sort_table_icon.hasClass('arrow_up')) {
            sortTable("ASC"); 
        } else {
            sortTable("DESC"); 
        }
    });
       
});  // ready doc 

    function sortTable( order ) {
        var table, tb_box, rows, switching, i, x, y, shouldSwitch;
        //tb_box = document.getElementById("tb-box");
        //table = tb_box.querySelector("#tb-staff");
        table = document.getElementById("tb-staff");
        switching = true;
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 3; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("td")[1];
                y = rows[i + 1].getElementsByTagName("td")[1];
                // Check if the two rows should switch place:
                if (order == "ASC") {
                    if (parseInt(x.innerText) > parseInt(y.innerText)) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (parseInt(x.innerText) < parseInt(y.innerText)) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }

                }

            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
            }
        }
    }
</script>

