<?php
// namespace form\user;
// use dmForm;

class PaymentType extends dmForm {
    function __construct( $payment = null )
    {
    // $this->action = 'update';
    // $this->redirect = route('qv.project.edit',['id' => $proj_id],;
    $this->fields = [
'nameoncard'=> ['label' => 'Name on Card'],
'creditcard'=> ['label' => 'Credit Card Number'],
'expmonth'=> ['type'=>'number','label' => 'Exp Month'],
'expyear'=> ['type'=>'number','label' => 'Exp Year'],
'cvv'=> ['label' => 'cvv'],

'fullname'=> ['label' => 'Full Name'],
'email'=> ['label' => 'Email'],
'address'=> ['label' => 'Address'],
'state'=> ['label' => 'State'],
'state'=> ['label' => 'State'],
'city'=> ['label' => 'City'],
'zip'=> ['label' => 'Zip'],
'sameadr'=> [
    'type' => 'checkbox',
    'label' => ll('Shipping address same as billing'),
    'value' => true
],
    ];

    $this->SetData($payment);
    }
}
