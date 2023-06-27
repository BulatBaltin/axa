<?php

class InvoiceCommandType extends dmForm
{
    public $rows;

    function __construct($dataCluster, $customers = null)
    {

        $periods = ['' => 'All periods'];
        $year = intval(date('Y'));
        $month = intval(date('m'));
        for($i=0;$i < 12;$i++){
            $cmonth = substr("0".$month, -2);
            $period = $year.'-'.$cmonth;
            $dateObj   = DateTime::createFromFormat('!m', $month);
            $monthName = $dateObj->format('F'); // March            
            $periods[$period] = $monthName . ' ' . $year;
            $month--;
            if($month <= 0){
                $month = 12;
                $year--;
            }
        }
        
        // array_unshift($customers, 'All customers'); // changes indexes !!!
        $this->rows = $dataCluster['rows'];

        $this->fields = [
            'period' => [
                'type'  => 'combo',
                'div_class' => 'no-margin-b',
                'source' => $periods,
                'value' => $dataCluster['period'] ?? ''
            ],
            'status' => [
                // 'required' => false,
                'source'  => [
                    "" =>'All',
                    'submitted' => 'Submitted',
                    "not submitted"=>'Not submitted',
                    "not ready" => 'Not ready',
                    "submitted or not submitted" => 'Submitted or Not submitted',
                ],
                'div_class' => 'no-margin-b',
                'type' => 'combo',
                'value' => $dataCluster['status'] ?? '',
            ],
            'tag' => [
                // 'required' => false,
                'div_class' => 'no-margin-b',
                'source'  => [
                    ""      => 'Active',
                    "A"     => 'Archive',
                    "D"     => 'Deleted',
                    "LL"    => 'All'
                ],
                'type' => 'combo',
                'value' => $dataCluster['tag'] ?? '',

            ],
            'customer' => [
                'div_class' => 'no-margin-b',
                'source' => $customers,
                // 'first_rec' =>[0,'All customers'],
                'placeholder' => 'All customers',
                'type' => 'combo',
                'value' => $dataCluster['customer'] ?? 0,
            ]
        ];
    }

}

