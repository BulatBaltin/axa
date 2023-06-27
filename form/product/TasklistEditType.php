<?php

class TasklistEditType extends dmForm
{
    public function __construct($tasklist)
    {
        $this->fields = [
'id'            => ['value' => $tasklist['id']],
'visibility'    => ['value' => ''],
'name'          => ['value' => $tasklist['name']],
'pid'           => ['value' => $tasklist['pid']],
'customer'      => [
    'name'      => 'customer_id',
    'type'      => 'combo',
    'first_rec' => [0, '- Select -'],
    'source'    => 'client',
    'value'     => $tasklist['customer_id']
],
'description'   => ['type'  => 'text', 'value' => $tasklist['description']],
'grouppa'       => [
    'value' => $tasklist['grouppa'], 
    'label' => 'Gruppa (not empty - Multy customer)'
],
'adduser' => [
    'source'    => 'user',
    'type'      => 'combo',
    'first_rec' => [0, '- Select -'],
    'label'     => 'Assign Project to Employee',
]
        ];
    }
}
