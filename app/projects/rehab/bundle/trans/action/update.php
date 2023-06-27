<?php
try {

    $form_data = REQUEST::getForm();

    // dd($form_data);
    
    $lang = $form_data['lang'];

    $keys           = explode(PHP_EOL, $form_data['keys']);
    $phrases        = explode(PHP_EOL, $form_data['phrases']);
    $trans_phrases  = explode(PHP_EOL, $form_data['trans']);
    $description_trans = $form_data['description_trans'] ?? [];

    Database::Connect('DB_REHAB');

    foreach ($keys as $pos => $line) {
        [$table, $field, $id, $table_type, $field_type] = get_data($line);
        
        if($table_type == '1') {
            $lang_table = $table .'_language';
        } elseif($table_type == '2') {
            $lang_table = $table;
        } else {
            $lang_table = $table_type;
        }

        dmModel::SetTable($lang_table);

        $entry = dmModel::findOneBy([$table .'_id' => $id, 'language' => $lang]);
        if(!$entry) {
            if($table_type == '1') { // external table
                $entry = dmModel::GetDefault(true); // null -> ''
            } else { // internal table
                $entry = dmModel::find($id); // make copy first
                $entry['id'] = null;
            }
            $entry[$table .'_id']   = $id;
            $entry['language']      = $lang;
        }
        if($field_type == '(html)') {
            $entry[$field] = $description_trans[$pos];
        } else {
            $entry[$field] = $trans_phrases[$pos];
        }
        $entry['created_date'] = date('Y-m-d H:i:s');

        dmModel::Commit($entry);

    }
    $mssg = Messager::renderSuccess('Translation saved ('. $lang .') '. date('Y-m-d H:i:s'));

} catch (Exception $e) {

    $mssg = Messager::renderError('Error: ' . $e->getMessage());
}

Json_Response(['mssg' => $mssg ]);

// ************* 
function get_data ($line) {
    $vals = explode('->', $line);
    return $vals;
}
