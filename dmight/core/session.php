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

class SessionObject {
    public $fields;
    public $object;
    public $object_class;
    public $object_name;
    public $object_id;
    public $id;

    function __construct($dbclass)
    {
        $this->fields = $dbclass::GetDefault();
        $this->object_class  = $dbclass;
        $this->object_name   = 'object';
        $this->object = [];
        $this->id = "id";
    }

    function set($object) {
        $session = new DataLinkSession();
        $session->set($this->object_name, $object);
        return $object;
    }
    function get() {
        $session = new DataLinkSession();
        $object = $session->get($this->object_name);
        return $object;
    }
    function remove() {
        $session = new DataLinkSession();
        $session->remove($this->object_name);
    }

    function GetDefault() {
        return $this->fields;
    }
    function GetFromSession($object_name = null) {
        $session = new DataLinkSession();
        if($object_name) $this->object_name = $object_name;
        $table_session  = $session->get($this->object_name);
        if ($table_session) {
            $this->object        = $table_session['object'];
            $this->object_class  = $table_session['class'];
            return $this;
        } 
        $this->object = [];
        return false;
    }
    function ClearTable($object_name = null) {
        if($object_name) $this->object_name = $object_name;
        $session = new DataLinkSession();
        $session->remove($this->object_name);
        $this->object = [];
        return $this;
    }
    function SaveIntoSession() {
        $session = new DataLinkSession();
        $table_session = [
            'object' => $this->object,
            'class' => $this->object_class
        ];
        $session->set($this->object_name, $table_session);
        return $this;
    }

    function find($id) {
        foreach ($this->object as $row) {
            if(isset($row[ $this->id]) and  $row[ $this->id] == $id) return $row;
        }
        return false;
    }
    function findBy($conds, $options = []) {
        // ?array  $parms = null, 
        // ?array  $sort = null, 
        // ?array  $names = null,
        // ?array  $fields = null,
        // ?int    $limit = null,
        // ?bool   $debug = false

        $subtable = [];
        if(isset($options['sort'])) {
            //...
            $object = $this->object;
        } else {
            $object = $this->object;
        }

        foreach ($object as $row) {
            foreach ($conds as $key => $value) {
                if(!(isset($row[$key]) and $row[$key] == $value)) continue(2);
            }
            if(isset($options['limit'])) {
                if($options['limit'] == 1) return $row;
                if(count($subtable) == $options['limit']) return $subtable;
            }
            $subtable[] = $row;
        }
        return $subtable;
    }
    function findOneBy($conds) {
        return $this->findBy($conds, ['limit' => 1]);
    }

    private function CheckEntry(&$entry) {
        foreach ($this->fields as $field => $value) {
            if(!array_key_exists($field, $entry)) {
                $entry[$field] = $this->fields[$field];
            };
        }
    }
    function addArray($items) {
        foreach ($items as $entry) {
            $this->add($entry);
        }
    }

    function add($entry) {
        $this->CheckEntry($entry);
        // $last_key = key($this->object);
        // $last_key = isset($last_key) ? $last_key + 1 : 0 ;
        $entry['rec_key'] = count($this->object);
        $this->object[] = $entry;
        // $this->object[$last_key]['rec_key'] = $last_key;
    }
    function update($entry) {
        $this->CheckEntry($entry);
        $rec_key = $entry['rec_key'];
        $this->object[$rec_key] = $entry;
    }
}