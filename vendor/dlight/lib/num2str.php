<?

 
function num2str_ru($num,$currency="rur") {
    $nul='ноль';
    $ten=array(
        array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
        array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
    );
    $a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
    $tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
    $hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
    
    
    if($currency!="rur")
        $unit=array( // Units
            array('копейка' ,'копейки' ,'копеек',     1),
            array('гривна'   ,'гривни'   ,'гривней'    ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','милиарда','миллиардов',0),
        );
    else
        $unit=array( // Units
            array('копейка' ,'копейки' ,'копеек',     1),
            array('рубль'   ,'рубля'   ,'рублей'    ,0),
            array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
            array('миллион' ,'миллиона','миллионов' ,0),
            array('миллиард','милиарда','миллиардов',0),
        );
    //
    list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
    $out = array();
    if (intval($rub)>0) {
        foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
            if (!intval($v)) continue;
            $uk = sizeof($unit)-$uk-1; // unit key
            $gender = $unit[$uk][3];
            list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
            // mega-logic
            $out[] = $hundred[$i1]; # 1xx-9xx
            if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
            else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
            // units without rub & kop
            if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
        } //foreach
    }
    else $out[] = $nul;
    $out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
    $out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
    return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
    $n = abs(intval($n)) % 100;
    if ($n>10 && $n<20) return $f5;
    $n = $n % 10;
    if ($n>1 && $n<5) return $f2;
    if ($n==1) return $f1;
    return $f5;
}

function num2str_en($number) {
     
     $hyphen      = '-';
     $conjunction = ' and ';
     $separator   = ', ';
     $negative    = 'negative ';
     $decimal     = ' point ';
     $dictionary  = array(
         0                   => 'zero',
         1                   => 'one',
         2                   => 'two',
         3                   => 'three',
         4                   => 'four',
         5                   => 'five',
         6                   => 'six',
         7                   => 'seven',
         8                   => 'eight',
         9                   => 'nine',
         10                  => 'ten',
         11                  => 'eleven',
         12                  => 'twelve',
         13                  => 'thirteen',
         14                  => 'fourteen',
         15                  => 'fifteen',
         16                  => 'sixteen',
         17                  => 'seventeen',
         18                  => 'eighteen',
         19                  => 'nineteen',
         20                  => 'twenty',
         30                  => 'thirty',
         40                  => 'fourty',
         50                  => 'fifty',
         60                  => 'sixty',
         70                  => 'seventy',
         80                  => 'eighty',
         90                  => 'ninety',
         100                 => 'hundred',
         1000                => 'thousand',
         1000000             => 'million',
         1000000000          => 'billion',
         1000000000000       => 'trillion',
         1000000000000000    => 'quadrillion',
         1000000000000000000 => 'quintillion'
     );
     
     if (!is_numeric($number)) {
         return false;
     }
     
     if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
         // overflow
         trigger_error(
             'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
             E_USER_WARNING
         );
         return false;
     }

     if ($number < 0) {
         return $negative . num2str(abs($number));
     }
     
     $string = $fraction = null;
     
     if (strpos($number, '.') !== false) {
         list($number, $fraction) = explode('.', $number);
     }
     
     switch (true) {
         case $number < 21:
             $string = $dictionary[$number];
             break;
         case $number < 100:
             $tens   = ((int) ($number / 10)) * 10;
             $units  = $number % 10;
             $string = $dictionary[$tens];
             if ($units) {
                 $string .= $hyphen . $dictionary[$units];
             }
             break;
         case $number < 1000:
             $hundreds  = $number / 100;
             $remainder = $number % 100;
             $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
             if ($remainder) {
                 $string .= $conjunction . num2str($remainder);
             }
             break;
         default:
             $baseUnit = pow(1000, floor(log($number, 1000)));
             $numBaseUnits = (int) ($number / $baseUnit);
             $remainder = $number % $baseUnit;
             $string = num2str($numBaseUnits) . ' ' . $dictionary[$baseUnit];
             if ($remainder) {
                 $string .= $remainder < 100 ? $conjunction : $separator;
                 $string .= num2str($remainder);
             }
             break;
     }
     
     if (null !== $fraction && is_numeric($fraction)) {
         $string .= $decimal;
         $words = array();
         foreach (str_split((string) $fraction) as $number) {
             $words[] = $dictionary[$number];
         }
         $string .= implode(' ', $words);
     }
     
     return $string;
}
?>