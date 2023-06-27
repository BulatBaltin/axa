<?
$special_header = true;
$english =  "Good morning";

$translate = new TranslateGoogle();
$dutch =  $translate->Translate( $english, 'en', 'ru' ) ;

// $translate = new GoogleTranslater();
// $dutch =  $translate->translateText( $english ) ;

if(REQUEST::isMethodPost()) {
    var_dump('post it!');
    die;
}

