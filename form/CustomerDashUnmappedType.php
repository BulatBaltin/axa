<?php
// namespace form;
// use dmForm;

class CustomerDashUnmappedType extends dmForm {
    function __construct()
    {
        // $this->action = 'update';
        // $this->redirect = route('qv.project.edit',['id' => $proj_id]);
        $this->fields = [
        'fixedhours' => [
            'name'=>'fixedhours',
            'type'=>'Combo',
            'value'=>'not-completed',
            'params'=>'',
            'source'=>[
                'all'=>'All tasks',
                'not-completed'=>'Not completed tasks',
                'completed' => 'Completed tasks',
            ],
            // 'presentation' => function($entry){return $entry['name'].' ('.$entry['id'] .')';},
        ],
        'tid' => [
            // 'name'=>'name',
            'value'=>'',
            'label'=>'Task ID',
            'mapped' => false,
            'required' => false,
    ],
    ];
    }
}

// class CustomerDashUnmappedType extends AbstractType
// {
//     public function buildForm(FormBuilderInterface $builder, array $options)
//     {
//         // https://symfony.com/doc/current/reference/forms/types/date.html#months        
//         $builder

//         ->add('fixedhours', ChoiceType::class, [
//             'required' => false,
//             'choices'  => [
//                 // '5 tasks fixed hours' => "",
//                 // 'All' => "LL",
//                 'Not completed tasks' => "",
//                 'Completed tasks' => "LL",
//             ],
//         ])
//         ->add('tid', TextType::class, [
//                 'label' => 'Task ID',
//                 'mapped' => false,
//                 'required' => false,
//             ]);
//     }
