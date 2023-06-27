<thead>
    <tr class='tr-header'>
        <th hidden><? $form->widget('markAll')?></th>
        <th style="width:50px;"><?l('Pos') ?></th>
        <th style="width:200px;">
            <?l('Project') ?>
        </th>
        <th style="width:100px;"><?l('User') ?></th>
        <th style="width:250px;"><?l('Task (NL)') ?></th>
        <th><?l('Product') ?></th>
        <th width="115px"><?l('Hours') ?>

            <br>
            <button id="items_fixed_hours"  title="<?l('Set fixed hours from tasks') ?>" type="button" class="copy-dn calculate_btn btn mt-2" height='25px'>
                <i style='color:grey' title="<?l('Set fixed hours from tasks') ?>" class="fas fa-anchor"></i>
            </button>
            <button id="items_hours_round" title="<?l('Round hours') ?>" name="round-items-hours" type="button" class="calculate_btn btn copy-dn mt-2" height='25px'>
                <svg class="calculate_icon">
                    <use xlink:href="/images/icons/sprite.svg#calculate"></use>
                </svg>
            </button>
        </th>
        <th width="70px"><?l('Price')?></th>
        <th width="70px"><?l('Total')?></th>
        <th width="70px">
            <small><b><?l('init hours') ?></b></small>
        </th>
        <!-- <th width="70px">
        <small><b><?l('Non-billable') ?></b></small>
        </th> -->
        <th width="95px">
        <div class='bg-action'>
            <?l('Actions')?>
        </div>    
        </th>
    </tr>
</thead>
<tbody id='t-edit-body'>

<? include('t-edit-body.html.php') ?>

</tbody>
