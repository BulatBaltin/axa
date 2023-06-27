<?php
// namespace form;
// use dmForm;

class TaskIdType extends dmForm {
    function __construct($task, $task_list )
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id]);
        $this->fields = [
        'tid' => [
            // 'name'=>'name',
            'value'=>$task['tid'] ?? '',
            'label'=>'External task id',
        ],
        'otask' => [
            'name'=>'otask',
            'value'=>$task['id'] ?? '',
            'label'=>'Customer tasks',
            'type'=>'Combo',
            'params'=>'',
            'source'=>$task_list,
            // 'presentation' => function($entry){return $entry['name'].' ('.$entry['id'] .')';},
        ]
    ];
    }
}

