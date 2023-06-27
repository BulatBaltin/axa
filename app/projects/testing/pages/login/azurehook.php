<?php

$azure = new AzureAuth();
$azure->fetchUserDataCredentials();
$profile = $azure->selectUserData(['displayName','mail']);

echo PHP_EOL . "displayName = " . $profile['displayName'];
echo PHP_EOL . $profile['mail'];

