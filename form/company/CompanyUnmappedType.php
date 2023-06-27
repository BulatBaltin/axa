<?php

class CompanyUnmappedType extends dmForm
{
    function __construct( $company = null )
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id],;

        $archive_year = (new DateTime())->format('Y') - 1;
        // $form2->get('archive_year')->setData( $archive_year );

        $date = date('Y-m-d');
        // $form2->get('trans_date')->setData( new DateTime());
        // $form2->get('link_date')->setData( new DateTime());
        // $form2->get('hours_date')->setData( new DateTime());
        // $form2->get('action')->setData('1');  // Hello World!
        // $form2->get('phrase')->setData('11278960');  // Hello World!



        $this->fields = [
            'archive_year' => [
                'type' => 'number',
                'label' => 'Archive Year',
                'value' => $archive_year
                ],
            'archiveop' => [
                'type' => 'combo',
                'source'  => [
                    'Archive' => 'Archive',
                    'Activate' => 'Activate'
                ],
            ],
            'hours_date' => [
                'type' => 'date',
                'value' => $date,
            ],
            'notes_date' => [
                'type' => 'date',
                'value' => $date,
            ],
            'link_date' => [
                'type' => 'date',
                'value' => $date,
                'div_class' => 'no-margin-b',
                'div_style' => 'margin-right:1rem;',
            ],
            'trans_date' => [
                'div_class' => 'no-margin-b',
                'type' => 'date',
                'value' => $date,
            ],
            'action' => [
                'type' => 'combo',
                'source' => [
                    '1' => "1.Change start / stop time in invoice goods. Set invoice tag 'S' (submitted) / 'I'",
                    '2' => "2.Set period (yyyy-mm-dd) to start date in time entries",
                    '3' => "3.Set period (yyyy-mm-dd) to start date in invoice goods",
                    '4' => "4.Test Job queue",
                    '5' => "5.Reset Task(nl) to have a date and #Id",
                    '6' => "6.Test getTasksDueDate() from Teamwork; set date to test it",
                ],

                'div_style' => 'height:30px;margin-right:1rem;',
                'div_class' => 'no-margin-b',
                'label' => 'Action',
            ],
            'phrase' => [
                'div_class' => 'no-margin-b',
                'label' => 'Test translation',
            ],
            'tid' => [
                'div_class' => 'no-margin-b',
                'label' => 'Task ID',
            ]];
            // $this->SetData($company);
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => null
    //     ],;
    // }
}
