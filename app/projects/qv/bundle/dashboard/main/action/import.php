<?php

    $impList = REQUEST::getParam('import');
    $boss = User::getUser();
    $response = Importdata::fetchDataQueue($boss, $impList);
    
    Json_Response($response);


    