<?php
  class STAT
{
    public static $_queries_num=0;
    public static $_slow_query_time=1;
    public static $_script_begin_time;
    public static $_queries_log=array();
    
    public static function beginScript($time=false)
    {
        if(!$time)
            $time=microtime(true);
        return STAT::$_script_begin_time = $time;
    }
    
    public static function getScriptTime()
    {
        $time=microtime(true)-STAT::$_script_begin_time;
        return number_format($time,2);
    }
    
    public static function getSlowQueriesNum()
    {
        $count=0;
        foreach(STAT::$_queries_log as $query)
            if($query['duration']>=STAT::$_slow_query_time)
              $count++;  
              
        return $count;
    }
    
    public static function getQueriesTime()
    {
        $time=0;
        foreach(STAT::$_queries_log as $query)
            $time+=$query['duration'];
            
        return number_format($time,2);
    }
    
    // public static function setScriptTime($value)
    // {
    //     STAT::$_script_time=$value;
    // }

    public static function addQueriesNum()
    {
        return STAT::$_queries_num++;
    }
    
    public static function getQueriesNum()
    {
        return STAT::$_queries_num;
    }

    public static function addToQueriesLog($sql,$duration)
    {
        STAT::$_queries_log[]=array("query"=>$sql,"duration"=>$duration);
    }
    
    public static function getQueriesLog()
    {
        return STAT::$_queries_log;
    }

}
?>