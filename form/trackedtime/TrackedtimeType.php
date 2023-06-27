<?php
// ZInvoiceHoursType
class TrackedtimeType extends dmForm
{
    public $rows;
    function __construct(    
        $dataCluster, 
        $tasklists,
        $invoices
    )
    {
        $this->rows = $dataCluster['rows'];
        foreach ($this->rows as $key => $value) {
            $this->rows[$key] = new TimerowType($value);
        }

        $periods = [
            '' => 'All periods',
            'since-date'=> 'Since date',
            'this-week' => 'This week',
            'last-week' => 'Last week'
        ];

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

        $this->fields = [
            'tag'=> [
                // 'required' => false,
                'id'    => 'select_tag_id',
                'div_class'    => 'no-margin-b',
                'value' => $dataCluster['tag'] ?? 'N',
                'type'  => 'combo',
                'source'  => [
                    'N' => 'Not Invoiced hours',
                    'C' => 'Not invoiced hours for completed tasks',
                    'I' => 'Invoiced hours and submitted hours',
                    'S' => 'Submitted hours',
                    'NS'=> 'Not Submitted invoiced hours',
                    'MR'=> 'Hours removed manually from invoices',
                    'LL'=> 'All',
                ],
            ],
            'period'=> [
                'type'      => 'combo',
                'source'    => $periods,
                'value'     => $dataCluster['period'] ?? '',
                'div_class' => 'no-margin-b',
                'id'        => 'select_period_id',
                // 'required'  => true,
                // 'multiple'  => false,
                // 'expanded' => true, //'Invoice',
                // 'data' => 'All periods',
                // 'help' => 'Add to the existing invoices if they exist or create new invoices',
                // 'attr' => ['class' => 'd-flex']
            ],
            'tasklist' => [
                'div_class' => 'no-margin-b',
                'id'    => 'select_tasklist_id',
                'name' => 'tasklist', 
                'label' => 'Task list',
                'value'     => $dataCluster['tasklist'] ?? '',
                'type' => 'combo', 'source' => 'tasklist',// $tasklists,
                // 'value' => 'All task lists', //'Select project',
                'first_rec' => [0,ll('All task lists')], //'Select project',
                'placeholder' => ll('All task lists'), //'Select project',
            ],
            'customer' => [
                'div_class' => 'no-margin-b',
                'id'    => 'select_customer_id',
                'name'  => 'customer',
                'value' => $dataCluster['customer'] ?? '',
                'type'  => 'combo', 'source' => 'client',
                'first_rec' => [0, ll('All customers')], //'Select project',
                'placeholder' => ll('All customers'), // 'Select customer',
            ],
            'user' => [
                'div_class' => 'no-margin-b',
                'id'   => 'select_user_id',
                'name' => 'user',
                'value' => $dataCluster['user'] ?? '',
                'type' => 'combo', 'source' => 'user',
                'first_rec' => [0, ll('All employees')], //'Select project',
                'placeholder' => ll('All employees'), // 'Select developer',
            ],


            'CheckButton'=> [
                'type' => "submit",
                'label' => " ",
                'class' => 'CheckForm'
            ],
            'UncheckButton'=> [
                'type' => "submit",
                'label' => ' ',
                'class' => 'UnCheckForm'
            ],
            'sincedate'=> [
                'type' => 'date',
                'data' => date('Y-m-d'),
                // 'choices' => $periods,
                // // 'placeholder' => 'All periods',
                // 'required' => true,
                // 'multiple' => false,
                // 'expanded' => true, //'Invoice',
                // 'help' => 'Add to the existing invoices if they exist or create new invoices',
                // 'attr' => ['class' => 'd-flex']
            ],
            'switchperiod'=> [
'type' => 'checkbox',
'label' => 'Periods'
            ],

            // 'rows' =>  [
            //     // 'entry_type' => InvoicePlanRowType::class,
            //     'entry_options' => ['label' => false],
            // ],
            'invoice' => [
                'name' => 'invoice', //'Invoice',
                'label' => false, //'Invoice',
                'placeholder' => ll('Select invoice to add hours to'),
                'type' => 'combo',
                'source' => $invoices,
            ],
            'isrounded'=> [
'type'  => 'checkbox',
'label' => ll('Round hours')
            ],

            'iscreated'=> [
'type'  => 'checkbox',
'label' => ll('Only new invoices'),
'help'  => ll('Create new invoices or add to the existing invoices if they exist')
            ],
            'newinvoice'=> [
                'source' => [
                    'Add' => ll('Add to existing'),
                    'New' => ll('Create new invoice')
                ],
                // 'expanded' => true, //'Invoice',
                // 'multiple' => false,
                'value' => 'Add',
                'help' => ll('Add to the existing invoices if they exist or create new invoices'),
                'class' => 'd-flex'
            ]
        ];
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => ZInvoHoursCluster::class,
    //         'invoices' => [],
    //         'projects' => []
    //     ]);
    // }
}
