<div style= "border: 1px solid lightgrey;">
    <table class="fully_mobile" width='100%'>
        <thead>
            <tr style='background: #ddd;' >
                <th width='33%'>
                Your hours 
                </th>
                <th width='33%'>
                Your Goal 
                </th>
                <th colspan='2'>
                Result
                </th>
            </tr>
        </thead>

        <tbody>
        <? $report = $dailyReport[0] ?>
            <tr style="font-size:1rem;font-weight: 600;">
                <td>
                    <?=$report['total']?>
                </td>
                <td>
                    <?=$report['goal']?> 
                </td>
                <td style='text-align: right;border-right: none;'>
                <? if ($report['smile']): ?>
                <img src='/images/icons/<?=$report['smile']?>.png'>
                <? endif ?>
                </td>
                <td style='text-align: left;border-left: none;'>
                <? if( $report['smile'] ): ?>
                    <?=$report['result'] . '%' ?>
                <? endif ?>
                </td>
            </tr>
        </tbody>
    </table>
    <? $report = $dailyReport[0] ?>
<? if ($report['smile']): ?>
    <h<?=$h1?> style='text-align: center;padding:5px;margin-top: 1rem;font-weight: 600;'><?=$report['cheers'][0]?></h<?=$h1?>>
    <h<?=$h2?> style='text-align: center;padding:5px;margin-bottom: 1rem;'><?=$report['cheers'][1]?></h<?=$h2?>>
    <table id='tdetails' class="fully_mobile" width='100%'>
        <tr>
            <th width='20%'>
            <?l('Your hours')?> 
            </th>
            <th width='50%'>
            Task
            </th>
            <th width='15%'>
            Start date
            </th>
            <th width='15%'>
            Due date
            </th>
        </tr>
        <tbody>
    <? if ((count($dailyReport) - 1) > 0) : ?>
        <? for($i=1; $i < count($dailyReport); $i++): ?>
            <? $atom = $dailyReport[$i] ?>
            <tr>
                <td>
                    <strong><?=$atom['total'] ?></strong>
                </td>
                <td style='text-align: left;'>
                    <? if (isset($site_root) and $atom['tid']): ?>
                        <a class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$atom['tid']?>">(#<?=$atom['tid']?>)&nbsp;
                        <?=$atom['task']?>
                        </a>
                    <? else :?>
                        <?=$atom['task']?>
                    <? endif ?>
                </td>
                <td>
                    <?=$atom['startdate'] ?>
                </td>
                <td>
                    <strong><?=$atom['duedate'] ?></strong>
                </td>
            </tr>
        <? endfor ?>
    <? endif ?>
        </tbody>
    </table>

<? endif ?>

<h4 style='text-align: center;padding:5px;margin-top: 1rem;font-weight: 600;'>Stacked data for <?=$say_month ?></h4>

    <table class="fully_mobile" width='100%'>
        <tr>
            <th width='35%'>
            Your hours 
            </th>
            <th width='35%'>
            Your Goal 
            </th>
            <th colspan='2'>
            Result
            </th>
        </tr>
        <tbody>
        <? if ((count($monthlyReport) - 1) > 0): ?>
            <? $report = $monthlyReport[0] ?>
            <tr style="background: #ddd; font-size:1rem;font-weight: 600;">
                <td>
                    <?=$report['total']?>
                </td>
                <td>
                    <?=$report['goal_now']?> (<?=$report['goal'] ?>)
                </td>
                <td style='text-align: right;border-right: none;'>
                <img src='/images/icons/<?=$report['smile']?>.png'>
                </td>
                <td style='text-align: left;border-left: none;'>
                <?=$report['result'] . '%' ?>
                </td>
            </tr>
        <? endif ?>
        </tbody>
    </table>

<h4 style='text-align: center;padding:5px;margin-top: 1rem;font-weight: 600;'>Due date (<?=$due_date ?>) task list</h4>
    <table id='tduedetails' class="fully_mobile" width='100%'>
        <tr>
            <th width='70%'>
            Task
            </th>
            <th width='15%'>
            Start date
            </th>
            <th width='15%'>
            Due date
            </th>
        </tr>
        <tbody>
    <? if (count($dueReport)): ?>
        <? for( $i=0; $i < count($dueReport); $i++) : ?>
            <? $atom = $dueReport[$i] ?>
            <tr>
                <td style='text-align: left;'>
                    <? if (isset($site_root) and $atom['tid']): ?>
                        <a class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$atom['tid']?>">(#<?=$atom['tid']?>)&nbsp;
                        <?=$atom['task'] ?>
                        </a>
                    <? else :?>
                        <?=$atom['task'] ?>
                    <? endif ?>
                </td>
                <td>
                    <?=$atom['startdate'] ?>
                </td>
                <td>
                    <strong><?=$atom['duedate']?></strong>
                </td>
            </tr>
        <? endfor ?>
    <? endif ?>
        </tbody>
    </table>

</div>
