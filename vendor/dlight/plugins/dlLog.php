<?php
// dllog
APP::addPlugin("dlLog");

class dlLog
{
  //public static $_filepath = ""; 
  public static $_eos = "\r\n";
  public static $_file = null;

  public static function Write($str, $openclose = true)
  {
    if ($openclose) {
      dlLog::BeginWrite();
    }
    fputs(dlLog::$_file, $str . dlLog::$_eos);
    if ($openclose) {
      dlLog::EndWrite();
    }
  }

  public static function BeginWrite()
  {

    //echo dirname(dirname(__FILE__))."/logs/log.txt";

    dlLog::$_file = fopen(dirname(dirname(dirname(__FILE__))) . "/logs/log.txt", "a");
    if (!dlLog::$_file) {
      echo ("Ошибка открытия файла log.txt");
    }
  }

  public static function EndWrite()
  {
    fclose(dlLog::$_file);
  }
  public static function Read()
  {
    $file_txt = dirname(dirname(dirname(__FILE__))) . "/logs/log.txt";

    if (file_exists($file_txt)) {
      return file_get_contents($file_txt);
    } else {
      return "No such file: " . $file_txt;
    }
  }
  public static function Clear()
  {
    dlLog::BeginWrite();
    ftruncate(dlLog::$_file, 0);
    dlLog::EndWrite();
  }
}
