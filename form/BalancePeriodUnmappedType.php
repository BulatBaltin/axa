<?php

// namespace form;
// use dmForm;

class BalancePeriodUnmappedType extends dmForm {
    function __construct()
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id]);
        $this->fields = [
            'bal_period' => [
                'name'=>'bal_period',
                'type'=>'Combo',
                'value'=>'this-month',
                'source'=>[
                    'this-month'=> 'This month', //(deze maand)
                    'last-month'=> 'Last month' //(gisteren)
                ],
                // 'presentation' => function($entry){return $entry['name'].' ('.$entry['id'] .')';},
            ],
        ];
    }
}
