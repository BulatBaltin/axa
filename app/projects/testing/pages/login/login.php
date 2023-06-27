<?php

$azure = new AzureAuth([]);
$azure->redirectToMicrosoft2();

/*
$options = [
    'appId' => '163a34ab-e299-4793-8092-1a0b5c76d7f1',
    'tenantId' => '51976ccc-ae7a-4fcc-b1ec-3647772c1648',
    'secretVal' => 'b3RpLQAkfFiwcSc9~_2c1hKw6x.f9D_jqr',
    'redirectUri' => "https://www.profitesting.kz/backend/ms-login"
];
$azure = new AzureAuth($options);
$azure->redirectToMicrosoft();
*/

