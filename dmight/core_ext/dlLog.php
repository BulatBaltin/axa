<?php
// dllog
// APP::addPlugin("dlLog");

class dlLog
{
  //public static $_filepath = ""; 
  public static $_eos = "\r\n";
  public static $_file = null;

  public static function WriteDump(...$vars) {
      self::Write(dump_ret(...$vars));
  }
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
    dlLog::$_file = fopen(ROOT . "logs/log.txt", "a");
    if (!dlLog::$_file) {
      echo ("Error opening file log.txt");
    }
  }

  public static function EndWrite()
  {
    fclose(dlLog::$_file);
  }
  public static function Read()
  {
    $file_txt = ROOT . "logs/log.txt";

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

class Messager
{
    static function renderMssg($text, $color, $border, $background, $lingo = null, $style ="")
    {
        if($lingo) {
            $text = ll($text);
        }
        return "<div style='color:{$color}; padding:0.5rem 1rem; background:{$background}; border-left: 6px solid {$border};{$style};'>{$text}</div>";
    }
    static function renderError($text, $lingo = null, $style='')
    {
        return self::renderMssg($text, "red", "red", "var(--redLight)", $lingo, $style);
    }
    static function renderSuccess($text = "Data successfully updated", $lingo = null, $style  = '')
    {
        if(empty($text)) $text = "Data successfully updated"; 
        return self::renderMssg($text, 'green', "lightgreen", "var(--greenLight)", $lingo, $style);
    }
    static function log(string $mssg, $time = null) {

        // dd($_SERVER);
        // $file = dirname($_SERVER['DOCUMENT_ROOT']) . '/var/log/php_log.txt';
        $file = ROOT . 'logs/php_log.txt';
        // dd($file);
        // $file = './var/log/php_log.txt';
        if($time) {
            file_put_contents($file, (new DateTime())->format('c'). " ".$mssg.PHP_EOL, FILE_APPEND);
        } else {
            file_put_contents($file, $mssg.PHP_EOL, FILE_APPEND);
        }
    }
    static function AddTraceInfo(Exception $e, string $exclude, $break = '<br>') {
        $trace = $e->getTrace();
        $mssg = '';
        foreach ($trace as $step) {
            if(strpos($step['file'], $exclude) === false) {
                $mssg .= $break.'File: '.$step['file'].'; Line:'.$step['line'].'; Function: '.$step['function'];
            }
        }
        return "<br> Count(trace)=(". count($trace) .')<br>'. $mssg;

    }
}

function dymp(...$vars) {
  dlLog::WriteDump(...$vars);
}