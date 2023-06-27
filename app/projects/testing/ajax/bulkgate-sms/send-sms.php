<?php
$id = REQUEST::getParam('id');
$smile = REQUEST::getParam('smile');
$sms_text = REQUEST::getParam('sms_text');

$response = include_partial('sms-bulkgate',['smile' => $smile, 'text' => $sms_text], true);

echo json_encode(['html' => $response ]);
exit;
?>