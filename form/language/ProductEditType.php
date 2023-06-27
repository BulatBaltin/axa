<?php

class ProductEditType extends dmForm
{
    public function __construct( $product )
    {
        $this
            ->add('id',[
                'value'  => $product['id'], 
                'hidden' => true
            ])
            ->add('visibility',[
                'value'  => $product['visibility'], 
                'hidden' => 'hidden'
            ])
            ->add('name', [
                'label' => 'Product name',
                'value'  => $product['name']
            ])
            ->add('code', ['label' => 'Code','value'  => $product['code']])
            ->add('price',[ 
                'type' => 'number', 
                'step' => '0.01' ,
                'label' => 'Price', 
                'value' => $product['price']
            ])
            ->add('pricevat', [ 
                'type'  => 'number', 
                'step'  => '0.01' ,
                'label' => 'Price (VAT)', 
                'value' => $product['pricevat']
            ])
            ->add('unit', [
                'label'     => 'Unit', 
                'value'     => $product['unit']
            ])
            ->add('taxrate', [
                'value' => $product['taxrate'],
                'type'  => 'number', 
                'label' => 'Tax Rate', 
                ])
            ->add('taxcode', [
                'value' => $product['taxcode'],
                'label' => 'Tax Code', 
            ])
            ->add('coaccount', [
                'value' => $product['coaccount'],
                'label' => 'Co-Account'
            ])
            ->add('accountid', [
                'value' => $product['accountid'],
                'label' => 'Accounting ID'
            ])
            ->add('adduser', [
                'type'      => 'combo',
                'source'    => 'user',
                'label'     => 'Assign Product to Employee',
                'first_rec' => [0, '- Select -']
            ])
            ->add('group', [
                'value' => $product['group_id'],
                'name'      => 'group_id',
                'type'      => 'combo',
                'source'    => 'productgroup',
                'label'     => 'Category',
            ])
            // ->add('visibility', TextType::class, ['required' => false])
            // ->add('keywords', TextType::class, ['required' => false])
            // ->add('code', TextType::class, ['required' => false])
        ;
    }
}
