<? if(isset($mail_mode)): ?>

<!DOCTYPE html>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Monthly progress report</title>
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
#tmdetails tr:nth-child(even) {
background-color: #eee;
}
#tmdetails tr:nth-child(odd) {
background-color: #fff;
}
</style>
</head>
<body>

<h1>Hello, <?=$dev_name ?> </h1>
<h2>Here is your monthly progress report for <?=$say_date ?> </h2>

<? endif ?>

<div class="row" style="margin-top:2rem;">
    <div class="col-md-12">
        <div class="mb-3 table_head">
            <? if (!isset($mail_mode)): ?>
            <h2 class="mr-3"><?l('Monthly progress report')?> (<span id='say-month'><?=$say_month?></span>)
            <span id="monthly-mail" style="margin-left: 3rem; cursor: pointer;">
            <i title="send email with this report" class="ml-2 fas  fa-envelope-square big-icon-blue"
            ></i>
            </span>            
            </h2>
            <div class="vertical_align_center">
            <?
dmForm::widgetCast(
    [
        'name'=>"x-date-m",
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

        <div id="tb-box-monthly">
<? module_partial('user/include/d-dash-monthly-box',[
'reportday' => $reportday, 
'company'   => $company, 
'developer' => $developer,
'site_root' => $site_root
]) ?>
        </div>
    </div>
</div>

<? if (isset($mail_mode)): ?>

</body>
</html>
<? endif ?>
