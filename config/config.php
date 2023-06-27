<?
APP::setConfig(array(
    
    "MAIN_PAGE"     => "home",
    "DB_SERVER"     => [ // default connection Database::Connect()
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'fantasy',
        'charset'  => 'utf8'
    ],
    // "DB_SERVER"     => "localhost",
    // "DB_USER_NAME"  => "root",
    // "DB_USER_LOGIN" => "",
    // "DB_NAME"       => "fantasy",
    // "DB_CHARSET"    => "utf8",
    "DB_REHAB"     => [
        'hostname' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'rehab_db',
        'charset'  => 'utf8'
    ],
    
    "CHARSET"       => "utf-8",
    "TIME_ZONE" => "Europe/Amsterdam",
    "DOMAIN" => "axa.com",
    "FAV_ICON" => "/images/icons/pt.svg",
    "PROJECT_ID" => "axa-collection",
    "PROJECT_NAME" => "axa-collection.com",
    "404_PAGE"=>'404',
    "PAGE-LIMIT"=>20,
    "DEBUG"=>true,
));

APP::setConstant(
    array(
        "portal_email_no_reply" => "info@123boeknu.nl",  //using in MAILER
        "email_sender" => "123boeknu", //using in MAILER
        "ORDER_PREFIX" => "#",

        "ORDER_NEW_STATUS" => 21,
        "ORDER_PAYED_STATUS" => 22,
        "ORDER_CANCELED_ADMIN" => 23,
        "ORDER_CANCELED_AUTO" => 24,
        "ORDER_PAYMENT_FAILED" => 25,

        "TRIP_DATE_ACTIVE" => 1,
        "TRIP_DATE_CANCELED" => 2,

        // "MOLLIE_KEY" => 'live_Fec4UanMPzGFe7GKSazm8kzPm5FrUy',
        "MOLLIE_KEY" => 'test_hBRgCxDWTgBnVSnwpgvcEGwvg5JW75',
    )
);

APP::setDevEnvironment(false);
?>