<div style= "border: 1px solid lightgrey;">
    <table id='twdetails' class="fully_mobile" width='100%'>
        <tr>
            <th width='25%'>
            Day of week 
            </th>
            <th width='25%'>
            Your hours 
            </th>
            <th width='25%'>
            Your Goal 
            </th>
            <th colspan='2'>
            Result
            </th>
        </tr>
        <? if ((count($weeklyReport) - 1) > 0): ?>
        <tbody>
            <? for ($i=1; $i < count($weeklyReport); $i++): 
                $report = $weeklyReport[$i] ?>
                <? if ($report['smile']): ?>
                <tr style="font-size:1rem;font-weight: 600;">
                    <td>
                    <? if (!isset($mail_mode)): ?>
                    <a href='#daily-root' id='week-day-<?=$i ?>' data-date="<?=$report['date'] ?>">
                    <? endif ?>
                        <?=$report['day'] ?>
                    <? if (!isset($mail_mode)): ?>
                    </a>
                    <? endif ?>
                    </td>
                    <td>
                        <?=$report['total'] ?>
                    </td>
                    <td>
                        <?=$report['goal'] ?> 
                    </td>
                    <td  style='text-align: right;border-right: none;'>
                    <img src='/images/icons/<?=$report['smile'] ?>.png'>
                    </td>
                    <td style='text-align: left;border-left: none;'>
                    <?=$report['result'] . '%' ?>
                    </td>
                </tr>
                <? else : ?>
                <tr style="font-size:1rem;font-weight: 600; color: #888;">
                    <td>
                        <?=$report['day'] ?>
                    </td>
                    <td>
                        <?=$report['total'] ?>
                    </td>
                    <td>
                        <?=$report['goal'] ?> 
                    </td>
                    <td colspan='2'>
                    --
                    </td>
                </tr>
                <? endif ?>
            <? endfor  ?>
        </tbody>
        <tfoot>
            <tr style="background: #ddd; font-size:1rem;font-weight: 600;">
                <td>
                    Total
                </td>
                <td>
                    <?=$weeklyReport[0]['total'] ?>
                </td>
                <td>
                    <?=$weeklyReport[0]['goal'] ?> 
                </td>
                <td style='text-align: right;border-right: none;'>
                <img src='/images/icons/<?=$weeklyReport[0]['smile'] ?>.png'>
                </td>
                <td style='text-align: left;border-left: none;'>
                <?=$weeklyReport[0]['result'] . '%' ?>
                </td>
            </tr>
        </tfoot>
        <? endif  ?>
    </table>

<? if (count($weeklyTaskReport) > 1 ): ?>
    <? $report = $weeklyTaskReport[0] ?>
    <? if ($report['smile']): ?>
    <h3 style='text-align: center;padding:5px;margin-top: 1rem;font-weight: 600;'><?=$report['cheers'][0]?></h3>
    <h4 style='text-align: center;padding:5px;margin-bottom: 1rem;'><?=$report['cheers'][1]?></h4>

    <table id='tdetails' class="fully_mobile" width='100%'>
        <tr>
            <th width='50%'>
            Your hours 
            </th>
            <th width='50%'>
            Task
            </th>
        </tr>
        <tbody>
        
        <? for ($i=1; $i < count($weeklyTaskReport); $i++): ?>
            <? $atom = $weeklyTaskReport[$i] ?>
            <tr>
                <td>
                    <strong><?=$atom['total']?></strong>
                </td>
                <td style='text-align: left;'>
                    <? if (isset($site_root) and $atom['tid']): ?>
                        <a class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$atom['tid']?>">(#<?=$atom['tid']?>)&nbsp;
                        <?=$atom['task'] ?>
                        </a>
                    <? else :?>
                        <?=$atom['task'] ?>
                    <? endif ?>
                </td>
            </tr>
        <? endfor ?>
        </tbody>
    </table>
    <? endif ?>
<? endif ?>

</div>
