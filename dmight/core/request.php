<?php
class REQUEST
{
    public static function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }
    public static function swapLang(
        string $lang, // en, nl, de, ...
        ?string $uri = null // getUri()
    ) {
        if(!$uri) $uri = self::getUri();
        $iend = strpos($uri, '/', 1);
        if ($iend === false) return $uri;
        return '/' . $lang . substr($uri, $iend);
    }
    // 03/05/2020 +Bulat
    public static function isSet($param )
    {
        return isset($_POST[$param]) or isset($_GET[$param]);
    }

    public static function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        }
        return false;
    }

    // public static function isMobile()
    // {
    //     $detect = new Mobile_Detect();
    //     if ($detect->isMobile() && !$detect->isTablet()) {
    //         return true;
    //     }
    //     return false;
    // }

    public static function isSEBot()
    {

        $bot = false;
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return $bot;
        }

        if (strstr($_SERVER['HTTP_USER_AGENT'], 'Yandex')) {
            $bot = 'Yandex';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot')) {
            $bot = 'Google';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot-Mobile')) {
            $bot = 'Googlebot-Mobile';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Googlebot-Image')) {
            $bot = 'Googlebot-Mobile';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'MSNBot-Products')) {
            $bot = 'MSNBot-Products-Google';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Mediapartners-Google')) {
            $bot = 'Mediapartners-Google (Adsense)';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Slurp')) {
            $bot = 'Hot&nbsp;Bot&nbsp;search';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'WebCrawler')) {
            $bot = 'WebCrawler&nbsp;search';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'ZyBorg')) {
            $bot = 'Wisenut&nbsp;search';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'scooter')) {
            $bot = 'AltaVista';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'StackRambler')) {
            $bot = 'Rambler';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Aport')) {
            $bot = 'Aport';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Mail.Ru')) {
            $bot = 'Mail.Ru';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'lycos')) {
            $bot = 'Lycos';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'WebAlta')) {
            $bot = 'WebAlta';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Teoma')) {
            $bot = 'Teoma';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'yahoo')) {
            $bot = 'Yahoo';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'Yahoo! Slurp')) {
            $bot = 'Yahoo! Slurp';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'msnbot')) {
            $bot = 'msn';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'msnbot-media')) {
            $bot = 'msnbot-media';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'msnbot-news')) {
            $bot = 'msnbot-news';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'ia_archiver')) {
            $bot = 'Alexa search engine';
        } else if (strstr($_SERVER['HTTP_USER_AGENT'], 'FAST')) {
            $bot = 'AllTheWeb';
        }

        return $bot;
    }

    public static function isLocalhost()
    {
        if (REQUEST::GetIp() == "127.0.0.1" or REQUEST::GetIp() == "::1") {
            return true;
        }
        return false;
    }

    public static function GetIp()
    {
        $ip = "";
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_Real_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_Real_IP'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public static function request_url()
    {
        $result = ''; // Пока результат пуст
        $default_port = 80; // Порт по-умолчанию

        // А не в защищенном-ли мы соединении?
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on')) {
            // В защищенном! Добавим протокол...
            $result .= 'https://';
            // ...и переназначим значение порта по-умолчанию
            $default_port = 443;
        } else {
            // Обычное соединение, обычный протокол
            $result .= 'http://';
        }
        // Имя сервера, напр. site.com или www.site.com
        $result .= $_SERVER['SERVER_NAME'];

        // А порт у нас по-умолчанию?
        if ($_SERVER['SERVER_PORT'] != $default_port) {
            // Если нет, то добавим порт в URL
            $result .= ':' . $_SERVER['SERVER_PORT'];
        }
        // Последняя часть запроса (путь и GET-параметры).
        $result .= $_SERVER['REQUEST_URI'];
        // Уфф, вроде получилось!
        return $result;
    }

    public static function isMethodPost()
    {
        if (count($_POST) || count($_FILES))
            return true;
        else
            return false;
    }
    public static function getForm() {
        return $_POST;
    }
    public static function get($param, $def_value = false, $strip_tags = false )
    {
        $val = null;
        if (isset($_POST[$param])) {
            if (!$strip_tags)
                $val = $_POST[$param];
            else
                $val = strip_tags($_POST[$param]);
        } elseif (isset($_GET[$param])) {
            if (!$strip_tags)
                $val = $_GET[$param];
            else
                $val = strip_tags($_GET[$param]);
        } else {
            $val = $def_value;

        }
        return $val;
    }
    public static function getParam($param, $def_value = false, $strip_tags = false, $session_cache_name = false)
    {
        $val = null;
        if (isset($_POST[$param])) {
            if (!$strip_tags)
                $val = $_POST[$param];
            else
                $val = strip_tags($_POST[$param]);
        } elseif (isset($_GET[$param])) {
            if (!$strip_tags)
                $val = $_GET[$param];
            else
                $val = strip_tags($_GET[$param]);
        }

        if ($val !== null) {
            if ($session_cache_name) {
                $_SESSION[$session_cache_name] = $val;
            }
            return $val;
        } else {
            if (isset($_SESSION[$session_cache_name])) {
                return $_SESSION[$session_cache_name];
            } elseif ($def_value) {
                if ($session_cache_name) {
                    $_SESSION[$session_cache_name] = $def_value;
                }
                return $def_value;
            } else {
                return null;
            }
        }
    }

    public static function Cookies($param, $value = false, $time = false)
    {
        if ($value === false) {
            if (isset($_COOKIE[$param]))
                return $_COOKIE[$param];
            else
                return null;
        } else {
            if (!$time)
                $time = mktime(date("H"), date("i"), date("s"), date("m") + 12, date("j"), date("Y"));

            if ($value === "") {
                //echo "111";
                return setcookie($param, "", time() - 3600, "/");
            } else {
                //echo "222";
                return setcookie($param, $value, $time, "/");
            }
        }
    }
}
