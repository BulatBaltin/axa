<?php
try {

    $form_data = REQUEST::getForm();

    $lang = $form_data['lang'];

    $keys       = explode(PHP_EOL, $form_data['keys']);
    $phrases    = explode(PHP_EOL, $form_data['phrases']);
    $description            = $form_data['description'];
    $description_trans      = [];
    $lang       = $form_data['lang'];
    $len        = count($phrases);

    $google = new TranslateGoogle('AIzaSyA7HqBVWvBLCTX_WdqD3YrOTgIz78aUQg8');

    $trans = [];
    for($i = 0; $i < $len; $i++) {
        $line = $keys[ $i ];
        [$table, $field, $id, $table_type, $field_type] = get_data($line);
        if($field_type == '(html)') {
            $description_trans[$i] = $google->Translate($description[$i], 'en', $lang);
            $trans[$i] = '';
        } else {
            $trans[$i] = $google->Translate($phrases[$i], 'en', $lang);
        }
    }

    $str_trans = implode(PHP_EOL, $trans);

    $html_textarea = module_partial('include/fill-textareas-trans.php',[
        'description' => $description,
        'description_trans' => $description_trans,
        'test' => ''
    ], true);
    
    $mssg = Messager::renderSuccess('Data filled ' . date('Y-m-d H:i:s'));

} catch (Exception $e) {

    $html_textarea = '';
    $str_trans = '';

    $mssg = Messager::renderError('Error: ' . $e->getMessage());
}

Json_Response(['mssg' => $mssg, 'trans' => $str_trans, 'html_textarea' => $html_textarea ]);

// $count = count($phrases);
// for ($i=0; $i < $count; $i++) { 
//     $phrases[$i] = $phrases[$i] .'->'.$trans_phrases[$i];
// }

// dd($phrases, $trans_phrases);

function get_data ($line) {
    $vals = explode('->', $line);
    return $vals;
}
