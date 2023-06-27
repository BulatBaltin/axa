<?php
class InvoiceItemsType extends dmForm
{
    function __construct($item, $options)
    {
        //dd($options);
        // ['label' => false, 'proj_choices' => $options['proj_choices']],        

// dd($options['proj_choices']);


        $this->fields = [
            'position' => ['value' => $item['position'] ],
            'id'    => ['value' => $item['id'] ],
            'status'=> ['value' => $item['status'] ],
            'level' => ['value' => $item['level'] ],
            'score' => ['value' => $item['score'] ],
            'tag'   => ['value' => $item['tag'] ?? '' ],

            'project_name'  => [],//'value' => $item['project_name']],
            'user_name'     => [], //'value' => $item['user_name']],
            'project_id'    => [
                'value' => $item['project_id'],
                // 'cargo' => 'hidden'
            ],
            'project' => [
                'type'      => 'combo',
                'label'     => 'Task list',
                'source'    => $options['proj_choices'],
                // 'value'     => $item['project_id'],
                // 'source' => [ '1' => 'Sailor'], // $options['proj_choices'],
                // 'source' => 'project',
            ],
            'user_id' => [
                'value' => $item['user_id'],
                // 'cargo' => 'hidden'
            ],
            'user' => [
                'type'      => 'combo',
                'source'    => 'user',
                // 'value'     => $item['user_id'],
                'label'     => 'User',
                'presentation' => function ($user) {
                    return sprintf('%s %s', $user['name'], $user['sirname']);
                }
            ],
            'artikul' => [
                'type' => 'combo',
                'source' => 'product',
                'first_rec' => [0, '- Select -'],
                'label' => 'Product',
                'value' => $item['artikul_id'],
                'presentation' => function ($product) {
                    return sprintf('%s € %.2f', $product['name'], $product['price']);
                }
            ],
            'tid' => [ // hidden
                'value' => $item['tid']
            ],
            'task' => [ // hidden
                'label' => 'Task',
                'value' => $item['task']
            ],
            'tasknl' => [
                'value' => $item['tasknl']
            ],
            'quantity' => [
                'type'  => 'number',
                // 'label' => 'Hours',
                'step'  => '0.05',
                'value' => $item['quantity']
            ],
            'quantityplan'=>[
                'type' => 'number',
                'label' => 'Init hours',
                'value' => $item['quantityplan']
            ],
            'quantitylost'=>[
                'type' => 'number',
                'label' => 'Lost hours',
                'value' => $item['quantitylost']
            ],

            'quantity_0' => [ // hidden field
                'type'  => 'number',
                'step'  => '0.05',
                'value' => $item['quantity']
            ],
            'price' => [
                'type' => 'number',
                'value' => $item['price']
            ],
            'total' => [
                'type' => 'number',
                'value' => $item['total']
            ]

        ];
    }

    // public function configureOptions(OptionsResolver $resolver)
    // {
    //     $resolver->setDefaults([
    //         'data_class' => InvoiceGoods::class,
    //         'proj_choices' => []
    //     ],;
    // }
}
