<?php
//start time
$time=microtime(true);

//first dice
function first_dice()
{
    $first_dice= mt_rand(1,6);
    return $first_dice;
}
//second dice
function second_dice()
{
    $second_dice= mt_rand(1,6);
    return $second_dice;
}
//rolling
function dice_roll()
{

    $die_roll_1 = first_dice();
    $die_roll_2 = second_dice();
    return array($die_roll_1, $die_roll_2);

}
// continues util boh are 6
function output()
{
    $rolls = 0;

    do
    {
        $dice_roll_final= dice_roll();
        $rolls++;
    } while(!($dice_roll_final[0]===6 && $dice_roll_final[1]===6));

   return "both dices are 6 and it took $rolls rolls to reach this stae";

}

$time2= microtime(true);
$total_time= $time2 - $time;
$short_total= number_format($total_time, 10);
$string_time= "<br>"."it tooks $short_total second";

$final= output();
echo $final,  $string_time;


?>