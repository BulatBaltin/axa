<?php
// use form\customer\ClientType;

try {

    $session = new DataLinkSession();
    $session->clear();

    UrlHelper::RedirectRoute('home');

} catch (Exception $e) {
    dd( DataBase::$sql );
} 
