<?php
  abstract class dlPlugin extends DBTable
  {
      public function preController()
      {}
      
      public function postController()
      {}
  } 
  
  class PluginManager
  {  
    public static $_app_plugins;
    
    public static function invokeEvent($event)
    {
        if(PluginManager::$_app_plugins and is_array(PluginManager::$_app_plugins))
            foreach(PluginManager::$_app_plugins as $plugin_name)
                {
                    if(class_exists($plugin_name))
                    {
                        $plugin=new $plugin_name();
                        if(method_exists($plugin, $event))
                            $plugin->$event();
                    }
                }       
    }
      
    public static function addPlugin($plugins)
    {
        if(is_array($plugins))
        {
            foreach($plugins as $value)
                PluginManager::$_app_plugins[]=$value;
        }
        else
            PluginManager::$_app_plugins[]=$plugins;
            
    }
    
    public static function activePlugin($plugin_name)
    {
        foreach(PluginManager::$_app_plugins as $value)
            if($value==$plugin_name)
                return true;
                
        return false;
    }  
      
  }
  
  
  
?>