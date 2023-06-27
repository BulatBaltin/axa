<div class='page_wrap'>
    <div class="row" style="max-height:6rem;">
        <h1 class="col-md-4">
            <a id="no-refresh" name="refresh" class="mr-3 update_icon_link" href="javascript:void(0)">
                <svg class="update_icon">
                    <use xlink:href="/images/icons/sprite.svg#update"></use>
                </svg>
            </a>

            <?l($title) ?>
        </h1>
        <div class="col-md-4 mb-5">
            <div><?l('Last update') ?> :</div>
            <div class="bordered_bottom_date" style="padding:5px 0;"><b><?= $TimeRefresh ?></b>
            </div>
        </div>
        <div class="col-md-4 mb-5">
        </div>
    </div>

    <? include('customer/include/c-charts-original.html.php') ?>
    <? include('customer/include/c-dash-hours-to-pay.html.php') ?>
    <? include('customer/include/c-dash-period-report.html.php') ?>

    <!-- Old version -->
    <div hidden class="row"> 
        <div class="col-md-12 mb-3">
            <div class="table_head">
                <h4 class="mr-3"><?l('Invoiced hours') ?></h4>
                <div class="vertical_align_center">
                    <span class="bordered_bottom_date" style="margin-right:6rem;">
                        <a href="#">
                        <label for="x-monthpicker" style="margin-right:10px;padding:10px;"><?l('Report date')?></label>
                        </a>
                        <input id='x-monthpicker' type="text" class="datepicker_range pointer" value="<?=$date1_month ?> - <?=$date2_month ?>" >

                    </span>
                    <div id="i-month-pie" class='round-spot-sort'>
                        <svg class="arrow_down mt-2">
                            <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id='invoiced_hours' style='margin:0 1rem;'>
    </div>
</div>
<!-- {# </------------- Footer ------------------ #} -->

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">

    $(document).ready(function(){

        $('#customer_dash_unmapped_fixedhours').change( function() {
            let chunk = $('#customer_dash_unmapped_fixedhours').val();
            $('#fx-hours-body').load( 
                "<?path('qv.dash-customer.fx-hours-body',['id'=> $hash ])?>",
                { 
                    chunk: chunk,
                },
                function() {
                }
            );

        });

        $('#id_period').change( function() {
            let period = $('#id_period').val();
            // alert(period);
            $.ajax({
                type: "post", url: "<?path('qv.dash-customer.period-body',['id'=> $client_hash ])?>", dataType: 'json',
                data: {
                    period: period
                },
                success: function (result) {
                    $('#period-body').html(result.t_body);
                    $('#show-period').html(result.say_period);
                }
            });
        });

        jQuery('#x-datetimepicker').datepicker({
            dateFormat: "dd/mm/yy"
        });

        $('#x-datetimepicker').on('change', function(){
            $('#tb-box').load( "<?path('qv.dash-customer.site-span', ['id'=> $hash ] )?>",
                { 
                    start_day: $(this).val(),
                    span: "total-all" 
                }
            );
        });

        $('#tb-box').on('click',"[id^='total-']",function(){
            $('#tb-box').load( "<?path('qv.dash-customer.site-span', ['id'=> $hash] )?>",
                { 
                    start_day: $('#x-datetimepicker').val(),
                    span: $(this).attr('id') 
                } 
            );
        })

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

        <? include('js/toolskit/modaldlg.js') ?>
       
    });  // ready doc 

    function sortTable( order ) {
        var table, rows, switching, i, x, y, shouldSwitch;
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
