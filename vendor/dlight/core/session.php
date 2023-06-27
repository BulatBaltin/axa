<?php

class Session
{
    public static function val($label, $value = null)
    {
        if ($value === null)
            return $_SESSION[$label];
        else
            $_SESSION[$label] = $value;
    }
    public static function say($label)
    {
        $once = self::get($label);
        self::unset($label);
        return $once;
    }
    public static function has($label)
    {
        if (isset($_SESSION[$label]))
            return true;
        else
            return false;
    }
    public static function is_set($label)
    {
        if (isset($_SESSION[$label]))
            return true;
        else
            return false;
    }
    public static function unset(string $label)
    {
        unset($_SESSION[$label]);
    }

    // 05-05-2020 +Bulat ------------------]
    public static function isset($label)
    {
        if (isset($_SESSION[$label]))
            return true;
        else
            return false;
    }
    public static function get(string $label, $value = null)
    {
        if (isset($_SESSION[$label]))
            return $_SESSION[$label];
        else
            return $value;
    }
    public static function set(string $label, $value)
    {
        if (!isset($_SESSION['__Set__'])) $_SESSION['__Set__'] = [];

        $_SESSION['__Set__'][$label] = $label;
        $_SESSION[$label] = $value;
        return $value;
    }
    public static function showSetList()
    {
        if (isset($_SESSION['__Set__'])) return $_SESSION['__Set__'];
        return [];
    }
    public static function unsetAll()
    {
        if (isset($_SESSION['__Set__'])) {
            // session_unset();
            foreach ($_SESSION['__Set__'] as $label) {
                if (isset($_SESSION[$label])) { 
                    unset($_SESSION[$label]);                }
            }
            unset($_SESSION['__Set__']);
        }
    }

}