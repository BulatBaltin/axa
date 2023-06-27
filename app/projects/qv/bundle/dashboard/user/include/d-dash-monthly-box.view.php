<div style= "border: 1px solid lightgrey;">
    <table class="fully_mobile" width='100%'>
        <tr>
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
        <tbody>
        <? if ((count($monthlyReport) - 1) > 0): ?>
            <? $report = $monthlyReport[0] ?>
            <tr style="background: #ddd; font-size:1rem;font-weight: 600;">
                <td>
                    <?=$report['total']?>
                </td>
                <td>
                    <?=$report['goal_now']?> (<?=$report['goal']?>)
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
    <? if ((count($monthlyReport) - 1) > 0): ?>
        <? $report = $monthlyReport[0] ?>
        <? if ($report['smile']): ?>
        <h3 style='text-align: center;padding:5px;margin-top: 1rem;font-weight: 600;'><?=$report['cheers'][0]?></h3>
        <h4 style='text-align: center;padding:5px;margin-bottom: 1rem;'>
        <?=$report['cheers'][1]?></h4>
        <table id='tmdetails' class="fully_mobile" width='100%'>
            <tr>
                <th width='50%'>
                Your hours 
                </th>
                <th width='50%'>
                Task
                </th>
            </tr>
            <tbody>
            <? for ($i=1; $i <= count($monthlyReport)-1; $i++ ): ?>
                <? $atom = $monthlyReport[$i] ?>
                <tr>
                    <td>
                        <strong><?=$atom['total']?></strong>
                    </td>
                    <td style='text-align: left;'>
                        <? if (isset($site_root) and $atom['tid']): ?>
                            <a class='row-href' target="_blank" href="https://<?=$site_root?>.teamwork.com/#/tasks/<?=$atom['tid']?>">(#<?=$atom['tid']?>)&nbsp;
                            <?=$atom['task']?>
                            </a>
                        <? else: ?>
                            <?=$atom['task']?>
                        <? endif ?>
                    </td>
                </tr>
            <? endfor ?>
            </tbody>
        </table>
        <? endif ?>
    <? endif ?>
</div>
