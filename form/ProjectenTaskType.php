<?php
// namespace form;
// use dmForm;

class ProjectenTaskType extends dmForm {
    function __construct(?array $task, ?array $task_list)
    {
        $this->fields = [
            'tid' => [
                'value'=> $task['tid'] ?? '',
                'label'=>'Teamwork ID',
            ],
            'task' => [
                'name'=>'task',
                'value'=> $task['tid'] ?? '',
                'type'=>'combo',
                'source'=>$task_list,
                'first_rec'=>[0, 'Select task'],
                'label'=>'Teamwork task'
            ]
        ];
    }
}