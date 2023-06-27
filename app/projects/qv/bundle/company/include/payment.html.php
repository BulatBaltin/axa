<? $form_payment->start()?>
      
        <div class="row">
          <div class="col-50">
            <h3>Billing Address</h3>
            <div class="input_row">
              <label for="fname"><?l('Full Name')?></label>
              <? $form_payment->widget('fullname',['placeholder' => "Enter " . $object['name']]) ?>
            </div>
            <div class="input_row">
              <label for="email"><?l('Email')?></label>
              <? $form_payment->widget('email',['placeholder' => "Enter " . $object['email']]) ?>
            </div>
            <div class="input_row">
              <label for="adr"><?l('Address')?></label>
              <? $form_payment->widget('address',['placeholder' => "Enter " . $object['address']]) ?>
            </div>
            <div class="input_row">
              <label for="city"><?l('City')?></label>
              <? $form_payment->widget('city')?>
            </div>
            <div class="input_row">
              <div class="row">
                <div class="col-50">
                    <label for="state"><?l('State')?></label>
                    <? $form_payment->widget('state')?>
                </div>
                <div class="col-50">
                    <label for="zip"><?l('Zip')?></label>
                    <? $form_payment->widget('zip', ['placeholder' => 'Enter ZIP'])?>
                </div>
              </div>
            </div>
          </div>

          <div class="col-50">
            <h3><?l('Payment')?></h3>
            <div class="input_row">
              <label for="fname"><?l('Accepted Cards')?></label>
              <div class="icon-container">
                <i class="fa fa-cc-visa" style="color:navy;"></i>
                <i class="fa fa-cc-amex" style="color:blue;"></i>
                <i class="fa fa-cc-mastercard" style="color:red;"></i>
                <i class="fa fa-cc-discover" style="color:orange;"></i>
              </div>
            </div>
            <div class="input_row">
              <label for="cname"><?l('Name on Card')?></label>
              <? $form_payment->widget('nameoncard',['placeholder' => $object['name']]) ?>
            </div>
            <div class="input_row">
              <label for="ccnum">Credit card number</label>
              <? $form_payment->widget('creditcard',['placeholder' => "1111-2222-3333-4444"]) ?>
            </div>
            <div class="input_row">
              <label for="expmonth">Exp Month</label>
              <? $form_payment->widget('expmonth',['placeholder' => "12"]) ?>
            </div>
            <div class="input_row">
              <div class="row">
                <div class="col-50">
                    <label for="expyear">Exp Year</label>
                    <? $form_payment->widget('expyear',['placeholder' => "2021"]) ?>
                </div>
                <div class="col-50">
                    <label for="cvv">CVV</label>
                    <? $form_payment->widget('cvv',['placeholder' => "***"]) ?>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <label class="custom_checkbox_label">
          <? $form_payment->widget('sameadr') ?>
          <!-- <input type="checkbox" checked="checked" name="sameadr"><span class="check"></span><?l('Shipping address same as billing') ?> -->
        </label>
        <button id="profile-payment" type="button" data-method="payment"
        class="btn mt-4"><? l('Update') ?>
          <svg class="update_icon">
            <use xlink:href="/images/icons/sprite.svg#undo"></use>
          </svg>
        </button>
        
    </div>
<? $form_payment->end()?>
