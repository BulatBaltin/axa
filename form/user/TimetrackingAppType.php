<?php

class TimetrackingAppType extends dmForm
{
    function __construct( $data = null )
    {
    // $this->action = 'update';
    // $this->redirect = route('qv.project.edit',['id' => $proj_id],;
    $this->fields = [
            'open' =>[],
            'logofile' => [
                'label' => 'Logo-file'
            ],
            'greencheck' => [
                'label' => 'greencheck'
            ],
            'name' => [
                'label' => 'App Name'
            ],
            'companytogglname' => ['label' => 'Company Time Tracking Name'],
            'togglid' => ['label' => 'Time Tracking App ID'],
            'usertoken' => ['label' => 'Time Tracking App token'],
            'startdate' => ['type'=>'datetime', 'label' => 'Start Tracking Time'],
            'stopdate' => ['type'=>'datetime','label' => 'Stop Tracking Time'],
            'Updatetime' => [
                'type' => 'submit',
                'label' => 'Update',
                'class' => 'rb-button'
                ],
            'Connecttime' => [
                'type' => 'submit',
                'label' => 'Connect',
                'class' => 'rb-button'
            ]
        ];

        $this->SetData($data);
    }
}
