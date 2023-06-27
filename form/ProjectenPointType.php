<?php
// namespace form;
// use dmForm;

class ProjectenPointType extends dmForm {
    function __construct()
    {
        $this->fields = [

        'name' => [
                'value'=>'123456',
                'label'=>'Teamwork ID',
            ],
        'point' => [
                'value'=>'33',
                'label'=>'Milestone',
            ]
        ];
    }
}