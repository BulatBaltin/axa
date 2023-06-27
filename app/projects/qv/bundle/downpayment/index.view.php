<div class='page_wrap'>

    <h1 class="mb-4"><?

use BulkGate\Sms\SenderSettings\CountrySenderID;

l($Title)?></h1>

    <div id="success-error">
    </div>

    <div class="table_actions d-flex">
        <div>
            <div class="search-box">
                <input class="" type="search" id="search-go" name="search-fld" placeholder="<?l('Search string') ?>" value="<?=$search_string ?>">
                <svg class="search_icon" id="go-search">
                    <use xlink:href="/images/icons/sprite.svg#search"></use>
                </svg>
            </div>
        </div>
        <div>
            <span><?l('Customer') ?>:</span>
            <div id ="pick-customer" class="custom_select" style='width:250px;'>
                <? $form->widget('customer') ?>
            </div>
        </div>
        <div>
            <a href="<? path($root . '.edit',['id' => 0]) ?>" class="btn green_btn">
            <?l('Add Downpayment') ?>
                <svg class="add_icon">
                    <use xlink:href="/images/icons/sprite.svg#plus"></use>
                </svg>
            </a>
        </div>
    </div>

    <table id="grid-data" class="full_width fully_mobile mt-4 mb-4">

        <thead>
            <tr>
                <th style="width: 5%;">Id</th>
                <th>Doc date</th>
                <th>Doc number</th>
                <th style="width: 20%;">Customer</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Active</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
        <? if( count($Items) > 0 ): ?>
        <? foreach( $Items as $downpayment ): ?>
            <tr>
                <td><?=$downpayment['id'] ?></td>
                <td><?= ($downpayment['doc_date'] ? date('d/m/y H:i', strtotime($downpayment['doc_date'])) : '') ?></td>
                <td><?= $downpayment['doc_number'] ?></td>
                <td><?= $downpayment['customer_name'] ?></td>
                <td><?= $downpayment['quantity'] ?></td>
                <td><?= $downpayment['price'] ?></td>
                <td><?= $downpayment['total'] ?></td>
                <td><?= $downpayment['active'] ? 'Yes' : 'No' ?></td>
                <td>

<div class="table_label_mobile"><?l('Actions')?></div>
<a title="<?l('Edit downpayment')?>" href="<? path('qv.downpayment.edit', ['id' => $downpayment['id'] ]) ?>" class="edit_row_icon">
    <svg>
        <use xlink:href="/images/icons/sprite.svg#edit"></use>
    </svg>
</a>
<a class="del-btn text-danger delete_row_icon" data-id="<?=$downpayment['id']?>" href="#"
data-token="<? csrf_token('delete' . $downpayment['id']) ?>"
data-downpayment-name="<?=$downpayment['id'] ?>"
>
    <svg>
        <use xlink:href="/images/icons/sprite.svg#bin"></use>
    </svg>
</a>

                </td>
            </tr>
        <? endforeach ?>
        <? else: ?>
            <tr>
                <td colspan="9"><?l('No records found')?></td>
            </tr>
        <? endif ?>
        </tbody>
    </table>

</div>

