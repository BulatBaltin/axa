
<div class="row">
    <div class="col-md-4 mb-3 mt-3">
        <div class="row">

            <div class="col-md-8 mb-3 mt-3">
                <div style="font-size:1.1rem;">
                    Submitted Invoiced Hours 
                </div>
            </div>
            <div class="col-md-4 mb-3 mt-3">
                <div style="font-size:1.2rem;">
                    <? invoiceTotals['q_submitted'] ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <div style="font-size:1.1rem;">
                    Open Invoiced Hours
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div style="font-size:1.2rem;">
                    <? invoiceTotals.q_not_submitted ?>
                </div>
            </div>
            {# <div class="col-md-6 mb-3">
                <div style='color:orange; background:orange; width: <? invoiceTotalsGraph.not_submitted ?>px;'>
                    <? invoiceTotalsGraph.not_submitted ?>
                </div>
            </div> #}
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <div style="font-size:1.1rem;">
                    Not ready Invoiced Hours
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div style="font-size:1.2rem;">
                    <? invoiceTotals.q_not_ready ?>
                </div>
            </div>
            {# <div class="col-md-6 mb-3">
                <div style='color:orange; background:orange; width: <? invoiceTotalsGraph.not_ready ?>px;'>
                    <? invoiceTotalsGraph.not_submitted ?>
                </div>
            </div> #}
        </div>
        <div class="row">
            <div class="col-md-8 mb-3">
                <div style="font-size:1.1rem;">
                    All Invoiced Hours
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div style="font-size:1.2rem;font-weight:500;">
                    <? invoiceTotals.q_all ?>
                </div>
            </div>
            {# <div class="col-md-7 mb-3">
                <div style='color:orange; background:orange; width: 300px;'>
                    <? invoiceTotals.q_all ?>
                </div>
            </div> #}
        </div>
    </div>
    <div class="col-md-4 mb-3 mt-3" id='chart1-canvas'>

        <canvas id="popChart1" width="83%" height="40" class="bg-white"
            data-submitted="<?invoiceTotalsGraph.submitted?>" 
            data-ready="<?invoiceTotalsGraph.not_submitted?>" 
            data-notready="<?invoiceTotalsGraph.not_ready?>" 
            data-all="<?invoiceTotalsGraph.all?>" 
        ></canvas>

    </div>
    <div class="col-md-4 mb-3 mt-3" id='chart3-canvas'>

        <canvas id="popChart3" width="83%" height="40" class="bg-white"
            data-submitted="<?invoiceTotalsGraph.submitted?>" 
            data-ready="<?invoiceTotalsGraph.not_submitted?>" 
            data-notready="<?invoiceTotalsGraph.not_ready?>" 
            data-all="<?invoiceTotalsGraph.all?>" 
        ></canvas>

    </div>
</div>
