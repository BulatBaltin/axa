 
 <? if (isset($downpayment)): ?>
 
 <fieldset style="border: 1px #ccc solid;color:grey; margin:2rem 0;">
    <legend style="font-size:16px;background: #ddd; max-width: 250px;padding-left:1rem;margin-left:2rem;"><? l('Downpayment (DESIGN !!!)') ?></legend>

    <div id="btn-panel" class="ml-4 mt-3" style="display: flex;">
        <div class="mr-4 mb-2 mt-2" style="display: block;">
            <label style="display: block;">
            Customer Downpayment<br>opening balance
            </label>
            <input id='opening_balance' type="text" class="" value="150.0" >
        </div>

        <div class="mr-4 mb-2 mt-2">
            <label style="display: block;">
            Invoice<br>Downpayment
            </label>
            <input id='opening_balance' type="text" class="" value="90.0" >
        </div>

        <div class="mr-4 mb-2 mt-2">
            <label style="display: block;">
            Customer Downpayment<br>closing balance
            </label>
            <input id='opening_balance' type="text" class="" value="60.0" >
        </div>
        <div class="mr-4 mb-2 mt-2" style="font-weight: bold;">
            <label style="display: block;">
            Total payable<br>by invoice
            </label>
            <input id='opening_balance' type="text" class="" value="20.0" >
        </div>
    </div>
</fieldset>
<? endif ?>
 