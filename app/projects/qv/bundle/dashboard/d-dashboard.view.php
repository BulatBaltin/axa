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
            <span style="font-size: 1.3rem;font-weight: bold;color:#777;"><?=$developer['name']?></span>
        </div>
    </div>

    <? include('user/include/d-charts-original.html.php') ?>
    <? include('user/include/d-dash-daily-report.html.php') ?>
    <? include('user/include/d-dash-weekly-report.html.php') ?>
    <? include('user/include/d-dash-monthly-report.html.php') ?>
    <div id='invoiced_hours' style='margin:0 1rem;'>
        
    </div>
</div>
<!-- {# </------------- Footer ------------------ #} -->

<? include(DMIGHT.'template/modalwnd.html.php')?> 

<script type="text/javascript">

    $(document).ready(function(){

        $('#daily-mail').click(function(){
            send_mail('d','Send email with a daily report<br>to the current developer'+"<br><?=$developer['name'] ?>", $('#x-datetimepicker').val() );
        });
        $('#weekly-mail').click(function(){
            send_mail('w','Send email with a weekly report<br>to the current developer'+"<br><?=$developer['name'] ?>", $('#w-datetimepicker').val());
        });
        $('#monthly-mail').click(function(){
            send_mail('m','Send email with a monthly report<br>to the current developer'+"<br><?=$developer['name'] ?>", $('#m-datetimepicker').val());
        });

        function toPhpDate( str_date) {// dd/mm/YYYY -> Y-m-d
            return str_date.substring(6)+'-'+str_date.substring(3,5)+'-'+str_date.substring(0,2);
        }
        function send_mail( report, text, date) {

            let url = "<? path('qv.team.send-mail', ['report'=>'@@report', 'hash'=> $dev_hash, 'date'=> '@@date' ])?>";
            url = url.replace('@@report', report);
            date = toPhpDate( date);

            url = url.replace('@@date', date);
            dmDialog({
                title:'Send email',
                text: text,
                ok: function () { 
                    ShowProcess();
                    $.ajax({ method: "POST", url: url, dataType: 'json',
                        success: function (result) {
                            HideProcess();
                            dmInfoDialog(
                                { 
                                  title: "<?l('Result')?>", 
                                  text: result.mssg 
                                });
                        }
                    });
                }
            });
        }

        $('#tb-box-weekly').on('click', "[id^='week-day-']",  function() { 
            let date = $(this).data('date');
            // $('#dmform_x-dat-d_id').val(date);
            // $('#dmform_x-dat-d_id').attr('value', date);
            // $('#dmform_x-dat-d_id').trigger('change');
            // return false;

            $('#tb-box-daily').load( "<?path('qv.dash-dev.site-span',['id'=> $dev_hash ])?>",
                { 
                    start_day: date,
                    type: 'd'
                }, function() {
                    // alert(date);
                    $('#dmform_x-dat-d_id').val(date);
                    // $('#dmform_x-dat-d_id').trigger('show');
                    // $('#dmform_x-dat-d_id').attr('value', date);
                    $('html, body').animate({
                        scrollTop: 650
                    });                    
                }
            );
            return false;
        }); 

        // $('#x-datetimepicker,#w-datetimepicker,#m-datetimepicker').datepicker({
        //     dateFormat: "dd/mm/yy"
        // });
        // $('#x-datetimepicker').on('change', function(){
        $('#dmform_x-date-d_id').on('change', function(){
            let url = "<?path('qv.dash-dev.site-span', ['id'=> $dev_hash ])?>";
            // alert('day report :'+url);
            $('#tb-box-daily').load( url,
                { 
                    start_day: $(this).val(),
                    type: 'd'
                }
            );
        });
        $('#dmform_x-date-w_id').on('change', function(){
            let url = "<?path('qv.dash-dev.site-span', ['id'=> $dev_hash ])?>";
            // alert('week report :'+url);
            $('#tb-box-weekly').load( "<?path('qv.dash-dev.site-span', ['id'=> $dev_hash ])?>",
                { 
                    start_day: $(this).val(),
                    type: 'w'
                }
            );
        });
        $('#dmform_x-date-m_id').on('change', function(){
            let url = "<?path('qv.dash-dev.site-span', ['id'=> $dev_hash ])?>";
            // alert('month report :'+url);
            $.ajax({ type: "POST", url: url, dataType: 'json',
                data: {
                    start_day: $(this).val(),
                    type: 'm'
                },
                success: function (result) {
                    $('#tb-box-monthly').html(result.view);
                    $('#say-month').html(result.say_month);
                }
            });

        });

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

    </script>
