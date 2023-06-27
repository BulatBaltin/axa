<?php
// namespace form\customer;
// use dmForm;

class ClientType extends dmForm
{
    function __construct( $customer = null )
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id]);
        $this->fields = [
        // 'id' => [],
        'list' => [
            'mapped' => false,
            'required' => false
        ],
        'name' => [
            'label' => 'Customer'
            ],
        'toggl_id' =>[
                'type' => 'number',
                'label' => 'Toggl ID'
            ],
        'address' => [
                'required' => false
            ],
        'telephone' => [
                'required' => false
            ],
        // 'activate' =>[
        //     'label' => ll('Activate person'),
        //     'type' => 'checkbox',
        //     'required' => false
        //     ],
        'email' =>['required' => false
            ],
        'password0' => [
                'type' => 'password',
                'label' => 'Enter password',
                'mapped' => false,
                'required' => false, 
                'empty_data' => '1111', 
                'placeholder' => "*****"
            ],
        'password' => [
                'type' => 'password',
                'label' => 'Repeat password',
                'required' => false, 
                'empty_data' => '1111', 
                'placeholder' => "*****"
            ],

        'person' => ['required' => false],
            // ->add('description', TextareaType::class, ['required' => false])
        'group_id' => [
                'name'      => 'group_id',
                'type'      => 'combo',
                'source'    => 'clientgroup',
                'label'     => 'Customer Group'
            ],
        'adduser' => [
                'name'      => 'adduser',
                'type'      => 'combo',
                'source'    => 'user',
                'label'     => 'Assign Customer to Employee'
                // 'mapped'    => false,
                // 'required'  => false
            ],
        'pilot' =>[
            'type' => 'combo',
            'label' => 'Invoice creation mode',
            'source'  => [
                    0 => ll('Auto-creation of invoices'),
                    1 => ll('Manual creation of invoices'),
                    2 => ll('Auto-creation of invoices only for completed tasks'),
                ],
            ],
        'plustaskid' => [
                'name' => 'plustaskid',
                'type' => 'checkbox',
                'label' => 'Add task ID to invoice entries',
                'required' => false,
            ],
        'plustaskdate'=>[
                'name' => 'plustaskdate',
                'type' => 'checkbox',
                'label' => 'Add task date to invoice entries',
                'required' => false,
        ],
        'linktrack' => [
                'name' => 'linktrack',
                'type' => 'checkbox',
                'label' => 'Add link to time tracking in time entries/tasks',
                'required' => false,
            ]
        ];    


        if($customer) {
            $this->SetData($customer);
        }
            // ->add('visibility', TextareaType::class, [
            //     'label' => 'Add a comma-seperated list of users IDs to restrict',
            //     'required' => false
            // ])
    }
}
