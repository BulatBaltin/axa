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
tr:nth-child(even) {
background-color: #eee;
}
tr:nth-child(odd) {
background-color: #fff;
}
th {
background-color: #eee;
}
</style>
</head>
<body>

<h1>Hello, <?=$dev_name ?> </h1>
<h2>Here is your <strong><italic>Open tasks report</italic></strong> for <?=$say_date ?> </h2>

<? endif ?>

<table id="grid-data" class="full_width fully_mobile mt-4 mb-4">
    <thead>
        <tr class='tr-header-grey'>
            <th width='45%'><?l('Task')?></th>
            <th width='10%'><?l('Last update')?></th>
            <th width='10%'><?l('Due date')?></th>
            <th width='25%'><?l('Tags')?></th>
            <th width='10%'><?l('Priority / Comments')?></th>
        </tr>
    </thead>
    <tbody id='report-body'>
<? include('report-body.html.php') ?>
    </tbody>
</table>

<? if (isset($mail_mode)):?>

</body>
</html>
<? endif ?>
