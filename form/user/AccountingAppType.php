<?php
// namespace form\user;
// use dmForm;

class AccountingAppType extends dmForm
{
    function __construct( $data = null )
    {
    // $this->action = 'update';
    // $this->redirect = route('qv.project.edit',['id' => $proj_id],;
    $this->fields = [
        'open'=> [],
        'logofile'=> [
            'label' => 'Logo-file'
        ],
        'name'=> [
            'label' => 'App Name'
        ],
        'login'=> [
            'label' => 'Login'
        ],
        'password'=> [
            'label' => 'Password'
        ],
        'key1'=> [
            'label' => 'Key-1'
        ],
        'key2'=> [
            'label' => 'Key-2'
        ],
        'parm1'=> [
            'label' => 'Parm-1'
        ],
        'parm2'=> [
            'label' => 'Parm-2'
        ]
    ];

        $this->SetData($data);
    }
}
