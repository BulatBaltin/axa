<?php

Database::Connect('DB_REHAB');

$config = [
    'age'       => [ 'field' => 'name' ], 
    'diffculty' => [ 'field' => 'name' ], 
    'diseases'  => [ 'field' => 'name' ], 
    'equipment' => [ 'field' => 'name' ], 
    'goals'     => [ 'field' => 'name' ], 
    'material'  => [ 'field' => 'name' ], 
    'mobility'  => [ 'field' => 'name' ], 
    'movements' => [ 'field' => 'name' ], 
    'position'  => [ 'field' => 'name' ], 
    'specialty' => [ 'field' => 'name' ], 
    'subscription.1' => [ 'field' => 'name' ], 
    'subscription.2' => [ 'field' => 'description', 'field_type' => 'html' ], 
    // 'subscription' => [ 'field' => 'name' ], 
    'support'   => [ 'field' => 'name' ], 
    'email_setting'   => [ 
        'field' => 'title,subject', 'table_type' => '2' ], 
    'email_setting.2'   => [ 
        'field' => 'message', 'field_type' => 'html', 'table_type' => '2' ], 
    // 'tbl_library'   => [ 
    //     'field' => 'title,description', 'table_type' => 'exercise_video'], 
    
    ];

    // tbl_library/exercise_video
    
$keys       = [];
$phrases    = [];
$htmls      = [];

foreach($tabs as $table) {

    $isHtml = false;
    $options    = $config[$table];
    $field      = $options['field'];
    if(isset($options['field_type']) and $options['field_type'] == 'html') {
        $isHtml = true;
    }

    $table_type = $options['table_type'] ?? '1';

    $flds   = explode(',',$field);
    $table  = GetRoot('.',$table);

    dmModel::SetTable($table);
    if($table_type == '2') {
        $data = dmModel::findBy(['language' => 'en']);
    } else {
        $data = dmModel::findAll();
    }

    foreach ($data as $index => $entry) {
        foreach ($flds as $fld) {
            $fld = trim($fld);
            if($isHtml) {
                $brief  = '';
                $field_type  = '(html)';
                $line   = '';
                $html   = $entry[$fld];
            } else {
                $line   = $entry[$fld];
                $brief  = substr($line,0,12).'...';
                $field_type  = '(text)';
                $html   = '';
            }
            $keys[]     = $table .'->'.$fld.'->'.$entry['id'].'->'.$table_type.'->'.$field_type.'->'.$brief;
            $phrases[]  = $line;
            $htmls[]    = $html;
        }
    }
}

$str_keys       = implode( PHP_EOL, $keys );
$str_phrases    = implode( PHP_EOL, $phrases );

//
function GetRoot($seperater, $stuff) {
    $pos = stripos($stuff, $seperater);
    if(!($pos === false)) return substr($stuff, 0, $pos);
    return $stuff;
}