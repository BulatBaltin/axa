<?php

// get form and data
$data_form = REQUEST::getForm();
$return = "success";

try {

    include_once( ROUTER::ModulePath().'include/rules-emails.html.php');

    [ $Items, $site_root ] = Task::fetchNotMappedTasksData(
        $company, 
        $data_form, 
        $tag_name,
        $rule_list
    );

// dd($Items);    
    $mssg = module_partial('report/report-not-mapped-body.html.php', [ 
        'Items' => $Items,
        'site_root' => $site_root,
        'background' => ''
    ], true);

    $n_records = 'Records: <strong>' . count($Items) . '</strong> Time: ' .(new DateTime())->format('d/m/Y H:i:s');

} catch (Exception $e) {
    $return = "error";
    $n_records = "";
    $sql = Database::$sql; 
    $mssg   = Messager::renderError("Error: $sql <br>" . $e->getMessage());
}

Json_Response([
    "return"    => $return,
    "n_records" => $n_records,
    'mssg'      => $mssg
]);
