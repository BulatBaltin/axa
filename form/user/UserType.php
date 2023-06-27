<?php
// namespace form\user;
// use dmForm;

class UserType extends dmForm {

    public $transrows;
    public $timerows;
    public $accrows;

function __construct( $user = null, $collections = [] )
{
    // $this->action = 'update';
    // $this->redirect = route('qv.project.edit',['id' => $proj_id]);

    $this->transrows = [];
    if(isset($user['transrows']))
        foreach ($user['transrows'] as $key => $value) {
            $this->transrows[] = new TranslationAppType($value);
        }
    $this->timerows = [];
    if(isset($user['timerows']))
        foreach ($user['timerows'] as $key => $value) {
            $this->timerows[] = new TimetrackingAppType($value);
        }
    $this->accrows = [];
    if(isset($user['accrows']))
        foreach ($user['accrows'] as $key => $value) {
            $this->accrows[] = new AccountingAppType($value);
        }


    $this->fields = [
'logoimage' => [
    'name' => 'logoimage',
    'type' => 'file',
    'label' => 'Company logo file (png,jpg file)',
    'file_type' => ".jpg, .jpeg, .png", 
    'data' => 'empty.png', 
    'value' => 'more_files.png'
],
'avatarimage' => [
    'name' => 'avatarimage',
    'type' => 'file',
    'label' => 'User avatar (png,jpg file)',
    'file_type' => ".jpg, .jpeg, .png", 
    'data' => 'empty.png', 
    'value' => 'default_user.png'
],
'save' => [
    'name' => 'save',
    'type' => 'submit',
    'label' => 'Save',
    'class' => 'rb-button'
],
'update1' => [
    'name' => 'update1',
    'type' => 'submit',
    'label' => 'Update',
    'class' => 'rb-button'
],
'update2' => [
    'name' => 'update2',
    'type' => 'submit',
    'label' => 'Update',
    'class' => 'rb-button'
],
'update3' => [
    'name' => 'update3',
    'type' => 'submit',
    'label' => 'Update',
    'class' => 'rb-button'
],
'subscribe' => [
    'name' => 'subscribe',
    'type' => 'submit',
    'label' => 'Subscribe',
    'class' => 'rb-button'
],
'checkout' => [
    'name' => 'checkout',
    'type' => 'submit',
    'label' => 'Checkout',
    'class' => 'rb-button'
],
'connectacc' => [
    'name' => 'connectacc',
    'type' => 'submit',
    'label' => 'Connect account',
    'class' => 'rb-button'
],
'connecttime' => [
    'name' => 'connecttime',
    'type' => 'submit',
    'label' => 'Connect',
    'class' => 'rb-button'
],
'delete' => [
    'name' => 'delete',
    'type' => 'submit',
    'label' => 'Delete',
    'class' => 'btn btn-outline-danger btn-sm float-right'
],
// <Timetracking
'timetracking' => [
    'name' => 'timetracking',
    'type' => 'combo',
    'source' => 'Timetracking',
    'label' => 'Time Tracking App'
],
// />
'timerows' => [
    'name' => 'timerows',
    'type' => 'collection',
    'entry_type' => 'TimetrackingAppType',
    'entry_options' => ['label' => false],
],
'togglid'   => ['label' => 'Time Tracking App ID'],
'usertoken' => ['label' => 'Time Tracking App token'],
'company'   => [
    'label' => 'Preset Configuration',
    'type' => 'combo',
    'source' => 'Company',
],
// <Accounting block>
'accrows' => [
    'name' => 'accrows',
    'type' => 'collection',
    'entry_type' => 'AccountingAppType',
    'entry_options' => ['label' => false],
],
// 
'accountlogin'  => [ 'label' => 'Login of Accounting software'],
'accountpass'   => [ 'label' => 'Password of Accounting software'],
'accountkey1'   => [ 'label' => 'Security Key1 of Accounting software'],
'accountkey2'   => [ 'label' => 'Security Key2 of Accounting software'],
'accountparm1'  => [ 'label' => 'Additional Parm1 of Accounting software'],
'accountparm2'  => [ 'label' => 'Additional Parm2 of Accounting software'],
// </Accounting>

// <Translation
// <Accounting block>
'transrows'     => [
    'name' => 'transrows',
    'type' => 'collection',
    'entry_type' => 'TranslationAppType',
    'entry_options' => ['label' => false],
],

'id' => ['label' => 'ID'],
'name'      => ['label' => 'Name'],
'sirname'   => ['label' => 'Surname'],
'address'   => ['label' => 'Address'],
'telephone' => ['label' => 'Telephone'],
'email'     => ['label' => 'Email'],
'url'       => ['label' => 'URL'],
'username'  => ['label' => 'User name'],
'companyname'   => ['label' => 'Company name'],
'chatemail' => [ 'label' => 'Send email copy to'],
'postcode'  => [ 'label' => 'Post code' ],
'city'      => [ 'label' => 'City'],
'password0' => [
    'label' => 'Verify current password',
    'type' => 'password',
    'empty_data' => "1111",
    // 'placeholder' => '&#9679;&#9679;&#9679;&#9679;&#9679;'
],
'password1' => [
    'label' => 'New password',
    'type' => 'password',
    'empty_data' => "1111",
    // 'placeholder' => "*****"
],
'password2' => [
    'label' => 'Confirm password',
    'type' => 'password',
    'empty_data' => "1111",
    // 'placeholder' => "*****"
],
'addrole' => [
    'name' => 'addrole',
    'type' => 'submit',
    'label' => 'Add Role',
    'class' => 'btn btn-success float-right'
],
'onerole' => [
    'name' => 'onerole',
    'type' => 'combo',
    'source'  => [
        'ROLE_ADMIN' => 'Company Admin',
        'ROLE_DEVELOPER' => 'Programmer',
        'ROLE_ACCOUNTANT' => 'Accountant / Sales Man',
        'ROLE_SUPER_ADMIN' => 'Super Admin',
        'ROLE_USER' => 'Application User'
    ]
],
'lingo_id' => [
    'name' => 'lingo_id',
    'source' => 'Language',
    'type' => 'combo',
    'label'  => 'Language'
],
'country_id' => [
    'name' => 'country_id',
    'source' => 'Country',
    'type' => 'combo',
    'label'  => 'Country'
],
'sendmail' => [
    'name' => 'sendmail',
    'type' => 'checkbox',
    'label'  => 'Send emails'
],
'dailygoal'=> [
    'type' => 'number',
    'label'  => 'Daily hour goal'
]
];

        $this->SetData($user);
        $this->SetCollection($collections);
    }
}