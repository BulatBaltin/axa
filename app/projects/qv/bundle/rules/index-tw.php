<?php

$session    = New DataLinkSession();
$mssg       = $session->get('mssg'); 
$rules      = Rulestw::findBy(['company' => $company]);
if ($session->get('message')) {
    $mssg = $session->get('message');
    $session->remove('message');
} else {
    $mssg = '';
}

$form = new RuleslistType;
foreach ($rules as $item) {
    $form->rows[] = new RulesTwType($item);
}

$title      = 'Import rules to map Teamwork project to system project';
$subtitle   = 'Add Import rules to map TW projects to the proper inner project';
$hours = true;
$Items = $rules;
$Fields =             [
    ['label' => 'Name',      'name' => 'name'],
    ['label' => 'Field',     'name' => 'field'],
    ['label' => 'Operator',  'name' => 'operator'],
    ['label' => 'Value',     'name' => 'value'],
];

$root = 'qv.rules';

        // return $this->render('rulestw/index.html.twig', $parms);
