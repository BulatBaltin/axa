<?php
    // use Space\space_test;

    $base = dirname(dirname(__FILE__));
    $base = str_replace('\\', '/', $base);
    $base = strtolower($base);
    define('ROOT', $base . '/');
    define('DMIGHT', ROOT . 'dmight/');
    define('CONFIG', ROOT . 'config/');
    define('MODELS', ROOT . 'model/');
    define('APPROOT', ROOT . 'app/');
    define('LAYOUT', APPROOT . 'layout/');
    define('DEFAULT_PROJECT', APPROOT . 'projects/');
    define('BUNDLE', APPROOT . DEFAULT_PROJECT. 'testing/');
    define('PUBLIC_HTML', ROOT . 'public/');
    define('CSS', PUBLIC_HTML . 'css/');
    define('JS_CODE', PUBLIC_HTML . 'js/');
    define('IMAGES', PUBLIC_HTML . 'images/');

        define('PARTIALS', BUNDLE . 'partials/');
        define('AJAX', BUNDLE . 'ajax/');

    define('VENDOR', ROOT . 'vendor/');
    define('DLIGHT', VENDOR . 'dlight/');
    
	session_start();
    include( DMIGHT . "core/app.php");

    APP::Run();
?>