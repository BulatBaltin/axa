<?php

function echoGoogleMap($id, $latitude, $longitude, $zoom, $width, $height, $editable, $popupHTML)
{
    $widthStr = $width ? "width: {$width}px;" : "";
    $editableStr = $editable ? 'true' : 'false';
    $output = <<< HD
    <div id="map_canvas_$id" style="height: {$height}px; $widthStr"></div>
    <input type="hidden" id="map_latitude_$id" value="$latitude" name="map_latitude_$id">
    <input type="hidden" id="map_longitude_$id" value="$longitude" name="map_longitude_$id">
    <input type="hidden" id="map_zoom_$id" value="$zoom" name="map_zoom_$id">
    
    <script>
        $('#map_canvas_{$id}').googleMap({
            input_latitude: '#map_latitude_$id',
            input_longitude: '#map_longitude_$id',
            input_zoom: '#map_zoom_$id',
            editable: $editableStr,
            popupHTML: '$popupHTML'
        });
        
        lookupAddress = function() {
            var address = getAddressText();
            $('#map_canvas_$id').googleMap( 'findAddress', address );
            return false;
        }
    </script>
HD;
    echo $output;
}




function NowDate2()
{
    return date("d/m/Y");
}



function stringBeforeDBInputWithStripTags($str)
{
    return trim(strip_tags($str));
}

function stringBeforeDBInputWithStripTags2($str)
{
    return strip_tags($str);
}


function stringBefore($str)
{
    return DataBase::real_escape_string(strip_tags($str));
}




function getPhpFile($file)
{
    $ar = explode(".", $file);
    return $ar[0] . ".php";
}

function setCOOKIEmy($name, $value)
{
    $time = mktime(date("H"), date("i"), date("s"), date("m") + 12, date("j"), date("Y"));
    setcookie($name, $value, $time);
}
function getCOOKIEmy($name)
{
    return $_COOKIE[$name];
}
function deleteCOOKIEmy($name)
{
    setcookie($name);
}


function getSearchParam($param_name)
{
    if (isset($_POST[$param_name])) {
        return StringBeforeDB($_POST[$param_name], true);
    } else if (isset($_GET[$param_name])) {
        return StringBeforeDB($_GET[$param_name], true);
    } else {
        return false;
    }
}


function getSearchMultiParamFromPost($post_base, $table_src)
{
    $result = "";
    $gateway = new $table_src();
    $recs = $gateway->getAllRecFields(array("id"));
    while ($rec = DataBase::fetch_array($recs)) {
        if ($_POST[$post_base . $rec['id']]) {
            if ($result != "") {
                $result .= ";";
            }
            $result .= $rec['id'];
        }
    }
    return $result;
}


function getSearchMultiParam($from_search, $post_base, $table_src, $get_param_name)
{
    if ($from_search) {
        return getSearchMultiParamFromPost($post_base, $table_src);
    } else {
        if (isset($_GET[$get_param_name])) {
            return StringBeforeDB($_GET[$param_name], true);
        } else {
            return false;
        }
    }
}

function StringBeforeDB($text, $strip_tags = true)
{
    if ($strip_tags) {
        $text1 = strip_tags($text);
    } else {
        $text1 = $text;
    }
    return DataBase::real_escape_string(trim($text1));
}

function IsAfterDateSec($date, $sec)
{
    $ar = explode(" ", $date);
    $date1 = explode("-", $ar[0]);
    $time1 = explode(":", $ar[1]);

    if (mktime() - mktime($time1[0], $time1[1], $time1[2], $date1[1], $date1[2], $date1[0]) > $sec) {
        return true;
    } else {
        return false;
    }
}

function stringBeforeDBInput($str)
{
    return DataBase::real_escape_string($str);
}

// function getDateFormated($date1)
// {
//     global $monthes_array;

//     if (getPermission() && getUserTZ() != 0) {
//         $delta_hours = getUserTZ();

//         $ar1 = explode(" ", $date1);
//         $ar2 = explode("-", $ar1[0]);
//         $ar3 = explode(":", $ar1[1]);

//         $date = date("Y-m-j H:i:s", mktime($ar3[0] + $delta_hours, $ar3[1], $ar3[2], $ar2[1], $ar2[2], $ar2[0]));;
//     } else {
//         $delta_hours = 0;
//         $date = $date1;
//     }
//     $ar1 = explode(" ", $date);
//     $ar2 = explode("-", $ar1[0]);
//     $ar3 = explode(":", $ar1[1]);

//     if ($ar2[1] < 10) {
//         $month = substr($ar2[1], 1, 1);
//     } else {
//         $month = $ar2[1];
//     }

//     return "{$ar2[2]} {$monthes_array[$month]} {$ar2[0]}, {$ar3[0]}:{$ar3[1]}";
// }

// function getDateOnlyFormated($date)
// {

//     $ar2 = explode("-", $date);


//     if ($ar2[1] < 10) {
//         $month = substr($ar2[1], 1, 1);
//     } else {
//         $month = $ar2[1];
//     }

//     return "{$ar2[2]} {$monthes_array[$month]} {$ar2[0]}";
// }

function PasteInImg($img_path, $string_to_paste)
{
    $ar = explode("[.]", $img_path);
    return $ar[0] . "{$string_to_paste}." . $ar[1];
}

function getDateTimeOnlyFormated($datetime, $view_time = false)
{
    list($date, $time) = explode(" ", $datetime);
    $ar2 = explode("-", $date);

    $month = $ar2[1];

    $month_array = APP::Constant("month_array");
    if ($view_time) {
        list($h, $m, $s) = explode(":", $time);
        return "{$h}:{$m} {$ar2[2]} " . $month_array[$month] . " {$ar2[0]}";
    } else
        return "{$ar2[2]} " . $month_array[$month] . " {$ar2[0]}";
}










function FormatDateForDB($str_date)
{
    if (strpos($str_date, "-") !== false) {
        return $str_date;
    }
    if (strpos($str_date, "/") == false) {
        return $str_date;
    }
    $sep = "/";
    list($day, $month, $year) = explode($sep, $str_date);
    if (strlen($day) == 4 && strlen($month) == 2 && strlen($year) == 2) {
        return $str_date;
    } else {
        return $year . "-" . $month . "-" . $day;
    }
}

function FormatDateTimeForDB($str_date)
{
    list($date, $time) = explode(" ", $str_date);
    $sep = "/";
    list($day, $month, $year) = explode($sep, $date);
    return $year . "-" . $month . "-" . $day . " " . $time;
}




function FormatDateForView($str_date)
{
    if (strpos($str_date, "/") !== false) {
        return $str_date;
    }

    $sep = "-";
    //echo $str_date;
    list($year, $month, $day) = explode($sep, $str_date);
    return $day . "/" . $month . "/" . $year;
}

function FormatDateForView2($str_date)
{
    $sep = "-";
    list($year, $month, $day) = explode($sep, $str_date);
    return $day . "." . $month . "." . $year;
}


function FormatDateTimeForView($str_date)
{
    list($date, $time) = explode(" ", $str_date);
    $sep = "-";
    list($year, $month, $day) = explode($sep, $date);


    list($h, $m, $s) = explode(":", $time);

    return $day . "/" . $month . "/" . $year . " " . $h . ":" . $m;
}

function FormatDateTimeForView2($str_date)
{
    list($date, $time) = explode(" ", $str_date);
    $sep = "-";
    list($year, $month, $day) = explode($sep, $date);


    list($h, $m, $s) = explode(":", $time);

    return $day . "." . $month . "." . $year . " " . $h . ":" . $m;
}






function first_letter_up($string, $coding = 'utf-8')
{
    if (function_exists('mb_strtoupper') && function_exists('mb_substr') && !empty($string)) {
        preg_match('#(.)#us', mb_strtoupper(mb_strtolower($string, $coding), $coding), $matches);
        $string = $matches[1] . mb_substr($string, 1, mb_strlen($string, $coding), $coding);
    } else {
        $string = ucfirst($string);
    }
    return $string;
}






function echoImgLoader($params)
{
    echo "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='660' height='595' id='imgloader'>
                <param name='movie' value='/imgloader/imgloader.swf' />
                <param name='quality' value='high' />
                <param name='bgcolor' value='#ffffff' />
                <param name='allowScriptAccess' value='sameDomain' />
                <param name='allowFullScreen' value='true' />
                <param name=FlashVars value=\"{$params}\" />
                <!--[if !IE]>-->
                <object type='application/x-shockwave-flash' data='/imgloader/imgloader.swf' width='660' height='595'>
                    <param name='quality' value='high' />
                    <param name='bgcolor' value='#ffffff' />
                    <param name='allowScriptAccess' value='sameDomain' />
                    <param name='allowFullScreen' value='true' />
                    <param name=FlashVars value=\"{$params}\" />
                <!--<![endif]-->
                <!--[if gte IE 6]>-->
                    <p> 
                        Either scripts and active content are not permitted to run or Adobe Flash Player version
                        10.2.0 or greater is not installed.
                    </p>
                <!--<![endif]-->
                    <a href='http://www.adobe.com/go/getflashplayer'>
                        <img src='https://www.adobe.com/images/shared/download_buttons/get_flash_player.gif' alt='Get Adobe Flash Player' />
                    </a>
                <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
            </object>";
}



function NowDate()
{
    return date("Y-m-d");
}

function NowDatePlusDays($days, $format = "Y-m-d")
{
    $time = time() + $days * 24 * 60 * 60;
    return date($format, $time);
}
function DatePlusDays($str_date, $days, $format = "Y-m-d")
{
    $time = (new DateTime($str_date))->getTimestamp();
    $time = $time + $days * 24 * 60 * 60;
    return date($format, $time);
}


function NowTime()
{

    return date("H:i:s", mktime(date("H"), date("i"), date("s"), date("m"), date("j"), date("Y")));
}






function DateSmaller($date1, $date2)
{
    list($year1, $month1, $day1) = explode("-", $date1);
    list($year2, $month2, $day2) = explode("-", $date2);

    $date1_ = mktime(0, 0, 0, $month1, $day1, $year1);
    $date2_ = mktime(0, 0, 0, $month2, $day2, $year2);

    if ($date1_ < $date2_) {
        return true;
    } else {
        return false;
    }
}

function DateSmallerOrEqual($date1, $date2)
{
    list($year1, $month1, $day1) = explode("-", $date1);
    list($year2, $month2, $day2) = explode("-", $date2);

    $date1_ = mktime(0, 0, 0, $month1, $day1, $year1);
    $date2_ = mktime(0, 0, 0, $month2, $day2, $year2);

    if ($date1_ <= $date2_) {
        return true;
    } else {
        return false;
    }
}

function NowDateMin($delta_Min)
{
    return date("Y-m-j H:i:s", mktime(date("H"), date("i") + $delta_Min, 0, date("m"), date("j"), date("Y")));
}

function explodeDate($date)
{
    return explode("-", $date);
}

function NowDateMonth($delta_month)
{
    return date("Y-m-d", mktime(0, 0, 0, date("m") + $delta_month, date("j"), date("Y")));
}

function NowDateDay($delta_day)
{
    return date("Y-m-d", mktime(0, 0, 0, date("m"), date("j") + $delta_day, date("Y")));
}


function DateDay($date, $delta_day) //date=dd-mm-YY
{

    return date("Y-m-d", mktime(0, 0, 0, date("m"), date("j") + $delta_day, date("Y")));
}



function NowDateYear($delta_year)
{
    return date("Y-m-j", mktime(0, 0, 0, date("m"), date("j"), date("Y") + $delta_year));
}


function NowDateHour($delta_hour)
{
    return date("Y-m-j H:i:s", mktime(date("H") + $delta_hour, date("i"), date("s"), date("m"), date("j"), date("Y")));
}




function DateAddDay($date, $delta_day)
{
    list($year, $month, $day) = explode("-", $date);
    return date("Y-m-j", mktime(0, 0, 0, $month, $day + $delta_day, $year));
}




function NowDateTime()
{
    return date("Y-m-d H:i:s", mktime(date("H"), date("i"), date("s"), date("m"), date("d"), date("Y")));
}
function NowDateTimeS()
{
    return date("Y-m-d H:i:s", time());
}
function NowDateTimeSS()
{
    return date("Ymd_His", time());
}

















function DidYearPass($date)
{
    list($add_year, $add_month, $add_day) = explode("-", $date);
    $end_period = mktime(0, 0, 0, $add_month, $add_day, $add_year + 1);

    $now = mktime(0, 0, 0, date('m'), date('j'), date('Y'));


    if ($end_period > $now) {
        return false;
    } else {
        return true;
    }
}



function FormatDateTimeForViewWithSec($str_date)
{
    list($date, $time) = explode(" ", $str_date);
    $sep = "-";
    list($year, $month, $day) = explode($sep, $date);
    return $day . "/" . $month . "/" . $year . " " . $time;
}


function FormatDateTimeForDBWithSec($str_date)
{
    $ar = explode(" ", $str_date);

    if (count($ar) == 2) {
        $date = $ar[0];
        $time = $ar[1];
    } else {
        $data = $ar[0];
        if (strpos($data, ":") !== false) {
            //это время
            return $data;
        } else if (strpos($data, "/") !== false) {
            //это дата
            $sep = "[/.-]";
            list($day, $month, $year) = explode($sep, $data);

            return $year . "-" . $month . "-" . $day;
        } else {
            return  $data;
        }
    }

    //list ($date, $time)
    $sep = "[/.-]";
    list($day, $month, $year) = explode($sep, $date);

    return $year . "-" . $month . "-" . $day . " " . $time;
}







function tempname($ext)
{
    $name  = time() . '_';
    for ($i = 0; $i < 8; $i++) {
        $name .= chr(rand(97, 121));
    }
    $name .= '.' . $ext;
    return $name;
}

function tempvalue()
{
    $name  = time() . '_';
    for ($i = 0; $i < 8; $i++) {
        $name .= chr(rand(97, 121));
    }
    return $name;
}

function RandValue($num = 6)
{
    $name  = '';
    for ($i = 0; $i < $num; $i++) {
        $name .= chr(rand(97, 121));
    }
    return $name;
}

function RandNum($num = 6)
{
    $name  = '';
    for ($i = 0; $i < $num; $i++) {
        $name .= rand(0, 9);
    }
    return $name;
}
