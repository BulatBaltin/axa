<?php
// namespace form\user;
// use dmForm;

class TranslationAppType extends dmForm
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
        'parm1'=> [
            'label' => 'Parm-1'
        ],
        'parm2'=> [
            'label' => 'Parm-2'
        ],
        'parm3'=> [
            'label' => 'Parm-3'
        ],
        'Updatetrans'=> [
            'type' => 'submit',
            'label' => 'Update',
            'class' => 'rb-button'
        ],
        'Connecttrans'=> [
            'type' => 'submit',

            'label' => 'Connect',
                'class' => 'rb-button'
        ]
    ];

        $this->SetData($data);
    }
}
