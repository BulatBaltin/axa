<?php

class TaskEditType extends dmForm
{
    public function __construct( $task )
    {
        foreach ($task as $key => $value) {
            if($value === null) {
                $task[$key] = '';
            }
        }

        $this
            ->add('id', ['value' => $task['id']])
            ->add('task',   [
                'label' => 'Task name',
                'value' => $task['task']
                ])
            ->add('tid',    [
                'label' => 'Tracked time task id',
                'value' => $task['tid']
                ])
            ->add('planduration',  [
                'type' => 'number',
                'label' => 'Estimated time (secs)',
                'value' => $task['planduration'],
            ])
            ->add('planquantity',   [
                'type' => 'number',
                'label' => 'Estimated time (hours)',
                'value' => $task['planquantity'],
                'step' => 0.001,
                // 'data' => 0,
                // 'constraints' => [
                //     // new NotBlank(),
                //     new Type([ 'type' => 'float' ]),
                //     new GreaterThanOrEqual([ 'value' => 0 ]),
                // ],
                // 'attr' => ['type' =>'number', 'step' => 0.1]
            ])
            ->add('duration', [
                'type' => 'number',
                'label' => 'Actual time (secs)',
                'value' => $task['duration'],
            ])
            ->add('quantity', [
                'type' => 'number',
                'label' => 'Actual time (hours)',
                'value' => $task['quantity'],
                'step' => 0.001,
            ])
            ->add('planstart', [
                'type' => 'datetime',
                'label' => 'Estimated start time',
                'value' => $task['planstart'] ? date('Y-m-d H:i', strtotime($task['planstart'])) : '',
            ])
            ->add('planstop', [
                'type' => 'datetime',
                'label' => 'Estimated stop time',
                'value' => $task['planstop'] ? date('Y-m-d H:i', strtotime($task['planstop'])) : ''
            ])
            ->add('start', [
                'type' => 'datetime',
                'label' => 'Start time',
                'value' => date('Y-m-d H:i', strtotime($task['start'])),
            ])
            ->add('stop', [
                'type'  => 'datetime',
                'label' => 'Stop time',
                'value' => date('Y-m-d H:i', strtotime($task['stop'])),
            ])
            ->add('duedate', [
                'type'  => 'datetime',
                'label' => 'Due date',
                'value' => date('Y-m-d H:i', strtotime($task['duedate'])),
            ])
            ->add('source', [
                'label' => 'Data source',
                'value' => $task['source'],
            ])
            ->add('projecten', [
                'type'      => 'combo',
                'source'    => 'project',
                'value' => $task['projecten_id'],
                'label' => 'Project',
            ])
            ->add('project', [
                'type'      => 'combo',
                'source'    => 'tasklist',
                'label' => 'Task lists',
                'value' => $task['project_id'],
            ])
            ->add('projectid', [
                'type'  => 'number',
                'label' => 'Import project Id',
                'value' => $task['projectid'],
            ])
            ->add('projectname', [
                'label' => 'Import project name',
                'value' => $task['projectname'],
                ])
            ->add('billable', [
                'type'  => 'checkbox',
                'label' => 'Billable time',
                'value' => $task['billable'],
            ])
            ->add('completed', [
                'type'  => 'checkbox',
                'label' => 'Completed task',
                'value' => $task['completed'],
            ])
            ->add('estimated', [
                'type'  => 'checkbox',
                'label' => 'Use estimated hours',
                'value' => $task['estimated'],
            ])
        ;
    }

}