<?php
// namespace form\customer;
// use dmForm;

class CustomerPeriodUnmappedType extends dmForm
{
    function __construct()
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id]);
        $this->fields = [
        // 'id' => [],
        'period' => [
            'type'      => 'combo',
            'source'    => [
'all-data'=>'All period',   // (vandaag)
'today' => 'Today',         // (vandaag)
'yesterday' => 'Yesterday', //(gisteren)
'this-week' => 'This week', //(deze week)
'last-week' => 'Last week', //(gisteren)
'this-month' => 'This month', //(deze maand)
'last-month' => 'Last month', //(gisteren)
'3-months'  => '3-months', //(gisteren)
'this-year' => 'This year' //(gisteren)
            ],
            'value' =>'all-data',            
            'name' => 'period'
            ],
    ]   ;
    }
}

