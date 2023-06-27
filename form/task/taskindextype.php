<?php

class TaskIndexType extends dmForm
{
    public function __construct( $task )
    {

        $this
            ->add('status', [
                'type'      => 'combo',
                'value'     => $task['status'] ?? '',
                'source'    => [
                    ''  => '- All -',
                    '1' => 'Completed',
                    '2' => 'Uncompleted'
                ],
            ])
            ->add('customer', [
                'type'      => 'combo',
                'source'    => 'client',
                'sort'      => ['name' => 'ASC'],
                'value'         => $task['customer_id'] ?? '',
                'first_rec'     => ['', '- All -'],
                'placeholder'   => 'All customers', // 'Select customer',
            ])
            ->add('tasklist', [
                'type'      => 'combo',
                'source'    => 'tasklist',
                'sort'      => ['name' => 'ASC'],
                'first_rec'     => ['', '- All -'],
                'value'         => $task['tasklist_id'] ?? '',
                'placeholder' => 'All task lists', //'Select project',
            ])
            ->add('projecten',  [
                'type'      => 'combo',
                'source'    => 'project',
                'sort'      => ['name' => 'ASC'],
                'first_rec'     => ['', '- All -'],
                'value'     => $task['projecten_id'] ?? '',
                'placeholder' => 'All projects', //'Select project',
            ]);
    }
}