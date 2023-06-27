<?php
$session    = New DataLinkSession();
$mssg       = $session->get('mssg'); 
$rules      = Rules::findBy(['company' => $company]);
if ($session->get('message')) {
    $mssg = $session->get('message');
    $session->remove('message');
} else {
    $mssg = '';
}

$form = new RuleslistType;
foreach ($rules as $item) {
    $form->rows[] = new RulesType($item);
}

$title      = 'Import rules';
$subtitle   = 'Add Import rules to map your projects to the proper customer';
$hours = true;
$Items = $rules;
$Fields =             [
    ['label' => 'Name',      'name' => 'name'],
    ['label' => 'Field',     'name' => 'field'],
    ['label' => 'Operator',  'name' => 'operator'],
    ['label' => 'Value',     'name' => 'value'],
    ['label' => 'Customer',  'name' => 'client'],
];

$root = 'qv.rules';

        // return $this->render('rules/index.html.twig', $parms);
