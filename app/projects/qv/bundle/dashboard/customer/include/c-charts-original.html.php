<div class="row">
    <div class="col-md-6 mb-5 mr-1">
        <div><h3><? l('Hour overview of last three months') ?></h3></div>
            <div class="bordered_bottom_date"><strong><?=$data3_days[3] ?> - <?= $data3_days[1] ?></strong></div>
        <div class="row" style="height: 2.5rem;margin-top:2rem;font-size: small;">
            <div class="col-md-4 mb-5"><span style="background-color:<?=$data_colors[1]?>;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<?l('Not invoiced hours') ?></div>
            <div class="col-md-3 mb-5"><span style="background-color:<?=$data_colors[2]?>;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<?l('Invoiced hours') ?></div>
        </div>
        <div id='chart1-original'>
        <!-- style='border:1px solid #f3f3ee;' -->
            <canvas id="ochart1" height="330"
                style='border:1px solid #dddddd;padding:0px 10px 10px 10px;'
                >
                <!-- style='border:1px solid #c3c3c3;'  -->
                Upgrade your browser
            </canvas>
        </div>
    </div>

    <div class="col-md-5 mb-5">
        <div><h3><?l('Current month') ?></h3></div>
            <div class="bordered_bottom_date"><strong><?=$data3_days[0] ?></strong></div>
        <div class="row" style="height: 2.5rem;margin-left: 2rem; margin-top:2rem; font-size: small;">
            <div class="col-md-5 mb-5"><span style="background-color:<?=$data_colors[1]?>;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<? l('Not invoiced hours') ?></div>
            <div class="col-md-4 mb-5"><span style="background-color:<?=$data_colors[2]?>;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<? l('Invoiced hours') ?></div>
        </div>
        <div id='chart2-original' style='display:flex;'>
            <canvas id="ochart2" height="330"
                >
                Upgrade your browser
            </canvas>
            <div style='margin-top: 2rem;'>
                <span style="background-color:<?=$data_colors[1]?>;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<?=$data[1] ?>
                <br>
                <br>
                <span style="background-color:<?=$data_colors[2]?>;">&nbsp;&nbsp;&nbsp;&nbsp;</span>&nbsp;<?=$data[2] ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

<? include(ROUTER::ModulePath().'assets/js/charts.js') ?>

</script>



