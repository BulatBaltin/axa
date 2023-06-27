<?php
try {

    $form_data = REQUEST::getForm();

    $checks = $form_data['check'] ?? [];
    $tables = $form_data['table'] ?? [];
    $tabs  = [];
    foreach ($checks as $index => $val ) {
        $tabs[] = $tables[$index];
    }
    // dd($tabs );

    include_once(ROUTER::ModulePath().'include/fill-from-tables.php');

    $html_textarea = module_partial('include/fill-textareas-trans.php',[
        'description' => $htmls,
        'description_trans' => [],
        'test' => ''
    ], true);
    
    $mssg = Messager::renderSuccess('Data filled ' . date('Y-m-d H:i:s'));

} catch (Exception $e) {

    $html_textarea = '';
    $str_keys = '';
    $str_phrases = '';

    $mssg = Messager::renderError('Error: ' . $e->getMessage());
}

Json_Response(['mssg' => $mssg, 'keys' => $str_keys, 'phrases' => $str_phrases, 'html_textarea' => $html_textarea ]);

// $count = count($phrases);
// for ($i=0; $i < $count; $i++) { 
//     $phrases[$i] = $phrases[$i] .'->'.$trans_phrases[$i];
// }

// dd($phrases, $trans_phrases);

function get_data ($line) {
    $vals = explode('->', $line);
    return $vals;
}
