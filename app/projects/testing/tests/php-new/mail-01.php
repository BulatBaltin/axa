<?

$user_name = "Bulat Baltin";
$trip = "Seehund safari";
$order_id = "3452";
$date = '20/03/2022';
$time = '11:00';
$total = 106;
$tickets = 90;
$discount = 0;
$seats = 16;
$food = 0;
$food_included = '(food included)';

$persons = 5;
$adults = 3;
$children = 2;
$coupon_persons = 0;

$options = [
'Heerlijke lunch of voor de lekkere trek' =>['Uitsmijter (€ 7)','Uitsmijter-2 (€ 3)'],
'Reservering van stoeltype' =>['(Sitze 4) Hocker, abgedeckt und beheizt +€ 3,00','(Sitze 1) Sitzbank mit Rückenlehne, überdacht und beheizt +€ 4,00'],

];
$project_name = "Eendracht1";

$template = "
::HALLO Hallo, %%USER_NAME
::TEXT We informeren u graag over uw boeking.
Let op! Twee dagen van tevoren om 18:00 uur  krijgt u alle verdere informatie.
eenmaal geboekt kunt u de datum niet meer wijzigen, mocht u onverhoopt toch willen wijzigen kost dit 12 euro administratie kosten.
wijzigen kan tot max 6 dagen van te voren!!

::TRIP Trip: %%TRIP

::ORDER Bestelnummer %%ORDER_ID
::DATE Datum: %%DATE
::TIME Tijd: %%TIME

::TOTAL Totaal te betalen: %%TOTAL

::TICKETS Tickets: %%TICKETS
::DISCOUNT Korting: %%DISCOUNT
::SEATS Extra betaling voor een stoel: %%SEATS
::FOOD Maaltijden: %%FOOD %%FOOD_INCLUDED

::PERSONS Aantal personen: %%PERSONS
::ADULTS Volwassenen: %%ADULTS
::COUPONS Coupon personen: %%COUPON_PERSONS
::CHILDREN Kinderen: %%CHILDREN

::OPTIONS Opties: %%OPTIONS

::FOOTER Hartelijk groet, %%PROJECT_NAME
";

$atmpl = explode('::', $template);
$vars = [];
$consts = [];
foreach($atmpl as $line) {
    $sp = explode(' ', $line, 2);
    if(count($sp) > 1) {
        $key = trim($sp[0]);
        $rr = explode('%%', trim($sp[1]));
        if(count($rr) > 1) {
            for($i = 1; $i < count($rr); $i++) {
                $name = strtolower(trim($rr[$i]));
                if(isset($$name)) {
                    $vars[$key][$name] = $$name; 
                }
            }
        }
        $consts[$key] = $rr[0];
    }
}
// echo '<br><br><br><br><br><br><br>';
// var_dump($vars, $consts); 
