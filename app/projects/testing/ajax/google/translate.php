<?php

$text = REQUEST::getParam('text');

$translate = new GoogleTranslate();
var_dump($text);

$dutch = $translate->Translate($text);

var_dump($dutch); die;
echo json_encode(['dutch' => $dutch ]);
exit;
?>