<?php

class RulesTwType extends dmForm
{
    public function __construct(array $rules)
    {
        $this
            ->add('name',  [
                'value'     => $rules['name'],
                'label' => 'Name',
                ])
            ->add('field', [
                'value'     => $rules['field'],
                'type'      => 'combo',
                'source'    => Rules::getFieldChoices()
            ])
            ->add('operator', [
                'value'     => $rules['operator'],
                'type'      => 'combo',
                'source'    => Rules::getOperatorChoices()
            ])
            ->add('value', [
                'value'     => $rules['value'],
                'label' => 'Value'
                ])
            ;
    }

}
