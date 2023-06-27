<div class="row">
    <div class="col-md-12">
        <div class="mb-3 table_head">
            <h3 class="mr-3"><?l('Hours per employee')?></h3>
            <div class="vertical_align_center">
                <?
dmForm::widgetCast(
    [
        'name'=>"x-date",
        'type'=>'date',
        'value'=> $str_today,
        'label' => ll('Report date'),
        'label_class' => 'date-label',
    ]
)
?>

                <!-- <span class="bordered_bottom_date">
                    <a href="#" >
                    <label for="x-datetimepicker" style="margin-right:10px;padding:10px;"><?l('Report date')?></label>
                    </a>
                    <input id="x-datetimepicker" class="x-datepicker" type="text" value="<?=$today ?>">

                </span>
                <div id="i-calendar-pie-3" class='ml-1 round-spot-sort'>
                    <svg class="arrow_down mt-2">
                        <use xlink:href="/images/icons/sprite.svg#down-arrow"></use>
                    </svg>
                </div> -->
            </div>
        </div>

        <div id="tb-box">
            <? 
module_partial('main/include/dash-table', [
    'company' => $company, 
    'startDate' => new DateTime, 
    'span' => 'total-all' 
]);
            // include('dash-table.html.php') 
            ?>
        </div>
    </div>
</div>
