<?php
// namespace form;
// use dmForm;

class ProjectenType extends dmForm {
    function __construct()
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id]);
        $this->fields = [
        'name' => [
            // 'name'=>'name',
            'value'=>'',
            'label'=>'Project name',
        ],
       'description' => [
            // 'name'=>'description',
            'value'=>'',
            'label'=>'Description',
        ],
        'customer' => [
            'name'=>'customer',
            'value'=>'',
            'label'=>'Customer',
            'type'=>'Combo',
            'params'=>'',
            'source'=>'client',
            'sort'=>['name'=>'ASC'],
            'presentation' => function($entry){return $entry['name'].' ('.$entry['id'] .')';},
        ],
        'budget' => [
            'name'=>'budget',
            'value'=>'',
            'label'=>'Hour budget',
            'type'=>'number',
        ]
    ];
                
    }
}