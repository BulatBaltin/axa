<?php

class DataLinkForm extends DataLink
{
    function __construct( $default = 0, $strip = false)
    {
        $this->default = $default;
        $this->strip = $strip;
    }
    function __get($term)
    {
        return REQUEST::getParam($term, $this->default, $this->strip); // null;
    }
}
class DataLinkStock extends DataLink
{
    function setIfNotExist($variables, $value = null)
    {
        foreach ($variables as $term) {
            if (!isset($this->data[$term]))
                $this->data[$term] = $value == null ? $this->default : $value;
        }
    }
    function setFromDataSource($variables, $source)
    {
        foreach ($variables as $term) {
            $this->data[$term] = isset($source[$term]) ? $source[$term] : $this->default;
        }
    }
}
class DataLinkSession extends DataLink
{
    function extract()
    {
        $variables = Session::showSetList();
        foreach ($variables as $term) {
            $$term = Session::get($term);
        }
    }
    function clear()
    {
        Session::unsetAll();
    }
    function __set($term, $value)
    {
        Session::set($term, $value);
    }
    function __get($term)
    {
        return Session::isset($term) ? Session::get($term) : $this->default; // null;
    }
    function set($term, $value)
    {
        Session::set($term, $value);
    }
    function get($term)
    {
        return Session::isset($term) ? Session::get($term) : $this->default; // null;
    }
    function has($term)
    {
        return Session::isset($term); // null;
    }
    function remove($term)
    {
        return Session::isset($term) ? Session::unset($term) : null; // null;
    }
    function setIfNotExist($variables, $value = null)
    {
        foreach ($variables as $term) {
            if (!Session::isset($term)) Session::set($term, $value == null ? $this->default : $value);
        }
    }
    function getIfExist($variables, $value = null)
    {
        foreach ($variables as $term) {
            if (Session::isset($term)) $$term = Session::get($term, $value == null ? $this->default : $value);
        }
    }
}

class DataLink
{
    protected $strip = false;
    protected $default = null;
    protected $data = [];
    function __construct($data = array())
    {
        $this->data = $data;
    }
    function __get($term)
    {
        return isset($this->data[$term]) ? $this->data[$term] : $this->default; // null;
    }
    function __set($term, $value)
    {
        $this->data[$term] = $value;
    }
    function setDefault($value)
    {
        $this->default = $value;
        return $this;
    }
    function getDefault()
    {
        return $this->default;
    }
    function setStrip($value)
    {
        $this->strip = $value;
        return $this;
    }
    function getStrip()
    {
        return $this->strip;
    }
}
