<? if (isset($mail_mode)): ?>

<!DOCTYPE html>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Daily progress report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<style>
table {
border-collapse: collapse;
}
table, th, td {
border: 1px solid lightgrey;
}
th, td {
padding: 12px;
text-align: center;
}
#tdetails tr:nth-child(even) {
background-color: #eee;
}
#tdetails tr:nth-child(odd) {
background-color: #fff;
}
</style>
</head>
<body>

<h1>Hello, <?=$dev_name ?> </h1>
<h2>Here is your daily progress report for <?=$say_date ?> </h2>

<? $h1 = '1' ?>
<? $h2 = '2' ?>

<? else : ?>

<? $h1 = '3' ?>
<? $h2 = '4' ?>

<? endif ?>
<div class="row" id='daily-root'>
    <div class="col-md-12">
        <div class="mb-3 table_head">
            <? if (!isset($mail_mode)): ?>
            <h2 class="mr-3"><?l('Daily progress report')?>
            <span id="daily-mail" style="margin-left: 3rem; cursor: pointer;">
            <i title="send email with this report" class="ml-2 fas fa-envelope-square big-icon-blue"
            ></i>
            </span>

            </h2>
            <div class="vertical_align_center">
<?
dmForm::widgetCast(
    [
        'name'=>"x-date-d",
        'type'=>'date',
        'value'=> $str_reportday,
        'label' => ll('Report date'),
        'label_class' => 'date-label',
    ]
)
?>
            </div>
            <? endif ?>
        </div>

        <div id="tb-box-daily">
<? module_partial('user/include/d-dash-daily-box',
[
'reportday' => $reportday, 
'company'   => $company, 
'developer' => $developer,
'site_root' => $site_root
]
) ?>
        </div>
    </div>
</div>

<? if (isset($mail_mode)): ?>

<div style="padding: 10px 5px;">
<img src='/images/icons/smile_good.png'> <span>greater or equal 100%</span>
</div>
<div style="padding: 10px 5px;">
<img src='/images/icons/smile_wait.png'> <span>greater or equal 85%</span> 
</div>
<div style="padding: 10px 5px;">
<img src='/images/icons/smile_bad.png'> <span>less than 85%</span> 
</div>

</body>
</html>
<? endif ?>
