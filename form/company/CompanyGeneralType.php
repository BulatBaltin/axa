<?php

class CompanyGeneralType extends dmForm
{
    function __construct( $company = null )
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id],;
        $this->fields = [
            'isrounded' => [
                'type' => 'checkbox',
                'label' => 'Round hours',
            ],
            'removehtml' => [
                'type' => 'checkbox',
                'label' => 'Remove Html/URLs from tasks',
            ],
            'translatetask' => [
                'type' => 'checkbox',
                'label' => 'Enable automatic task translation',
            ],
            'stackhours' => [
                'type' => 'checkbox',
                'label' => 'Stack hours automatically per month',
            ],
            'createclients' => [
                'type' => 'checkbox',
                'label' => 'Create new customers in Accounting App',
            ],
            'createproducts' => [
                'type' => 'checkbox',
                'label' => 'Create new products in Accounting App',
            ],
            'donetasks' => [
                'type' => 'checkbox',
                'label' => 'Mark submitted tasks as done in Teamwork',
            ],
            'createnewinvoices' => [
                'type' => 'checkbox',
                'label' => 'Automatically create new invoice if no invoices exist',
            ],
            'jobqueue' => [
                'type' => 'checkbox',
                'label' => 'Use Job queue for lengthy operations',
            ],
            'invoicesperiod' => [
                'label' => 'Automatically create new invoices every period',
            ]];

            $this->SetData($company);
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Company::class
    //     ],;
    // }
}
