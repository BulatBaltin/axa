<?php
// namespace form;
// use dmForm;

class CustomerPeriodHoursType extends dmForm {
    function __construct()
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id]);
        $this->fields = [
            'pay_customer' => [
                'name'=>'pay_customer',
                'type'=>'Combo',
                'value'=>'',
                'source'=>'Client',
                'sort'=>['name'=>'ASC'],
                'first_rec' =>[0, 'All customers']

                // 'presentation' => function($entry){return $entry['name'].' ('.$entry['id'] .')';},
            ],

            'pay_period' => [
                'name'=>'pay_period',
                'type'=>'Combo',
                'value'=>'3-months',
                'source'=>[
                    'all-data' => 'All period', // (vandaag)
                    'this-week' => 'This week', //(deze week)
                    'this-month'=> 'This month', //(deze maand)
                    '3-months' => '3 last months', //(deze maand)
                    ],
                // 'presentation' => function($entry){return $entry['name'].' ('.$entry['id'] .')';},
            ],

        ];
    }
}


