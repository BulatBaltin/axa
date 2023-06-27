<?php
$boss = User::getUser();
$company = User::getCompany($boss);
if (!$company) {
    if (!$company) throw new \Exception('Define company!');
}

$completed = REQUEST::getParam('completed');
$completed = $completed ? true : false;

// calc $fixedtasks, $fixedtotal
include(ROUTER::ModulePath().'assets/patch/fx-hours-controller.php');

$htmlGrid = module_partial(
    'main/include/fx-hours-body.html.php',
    [
        'fixedtasks' => $fixedtasks
    ], 
    true
);
$contents = [
    'htmlGrid' => $htmlGrid, 
    'htmlTotal' => $fixedtotal
];

Json_Response($contents);
