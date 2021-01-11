<?php
/*  OPDRACHT
    Maak een scriptje dat het tijdstip van de dag omzet naar geschreven tekst.
    Die geschreven tekst wordt in een HTML pagina getoond met de geschreven tekst in een paragraph.
    bvb: Het is nu één uur en drieëntwintig minuten.*/

    /*$time = strtotime("01:58");
    $timeChangedFormat = date("H:i", $time);
    echo $timeChangedFormat;*/

date_default_timezone_set('Europe/Brussels'); //Instellen van tijdzone
$time = time(); //Variabele aanmaken die het huidige tijdstip bevat.
$timeChangedFormat = date("H:i", $time); //Unix timestamp omzetten naar een leesbare tijd.

//echo "<br>";
$hour = substr($timeChangedFormat,0,2); //Variabele die het uur bevat.
//echo $hour;
$hourUnit = substr($hour,1,1); //Eenheden van uur
//echo "<br>";
//echo $hourUnit;
$hourTens = substr($hour,0,1); //Tientallen van uur
//echo "<br>";
//echo $hourTens;

//echo "<br>";
$minute = substr($timeChangedFormat, 3,2); //Variabele die het aantal minuten bevat.
//echo $minute;
//echo "<br>";
$minuteUnit = substr($minute,1,1); //Eenheden van minuut
//echo $minuteUnit;
//echo "<br>";
$minuteTens = substr($minute,0,1); //Tientallen van minuut
//echo $minuteTens;

//We splitsen getallen op in eenheden, het tussenstuk en tientallen.
//SpellOutUnits bevatten de eenheden + enkele tientallen die niet gevormd kunnen worden door
//een eenheid (tussenstuk) + tiental te doen.
$spellOutUnits = array("nul","een","twee","drie","vier","vijf","zes","zeven","acht","negen","tien",
                        "elf","twaalf","dertien","veertien");

$spellOutBetween = array("en","ën"); //Mogelijke tussenstukken.

$spellOutTens = array("tien","twintig","dertig","veertig","vijftig"); //Mogelijke tientallen.

//Berekening notatie uren
if($hour == 0) //Indien het uur bv. 00:15 is moet er "Het is twaalf uur en 15 minuten" getoond worden
{
    $spellOutHour = "twaalf"; //We geven daarom op dat als het uur 0 = "twaalf" en niet "nul".
}
else if($hour == 1) //Indien het uur bv. 01:15 is moet er "één" getoond worden ipv "een"
{                   //die te vinden is in de array van de eenheden ($spellOutUnits).
    $spellOutHour = "één";
}
else if($hour>0 && $hour<10) //Indien de getallen 0< en <10 zijn gaan we werken met "$"minuteUnit".
{
    $spellOutHour = $spellOutUnits[$hourUnit]; //Uur wordt gelijk gesteld aan waarde uit de array "spellOutUnits".
}
else if($hour>=10 && $hour<15) //Indien het uur >=10 en <15 gaan we kijken naar het hele uur.
{
    $spellOutHour = $spellOutUnits[$hour]; //Uur wordt gelijk gestelde aan de waarde uit de array "spellOutUnits".
}
else if($hour>=15 && $hour<20) //Indien het uur >=15 en <20 gaan we waardes uit de array "spellOutUnits" en "spellOutTens" samenvoegen.
{
    //We werken zoal met de eenheden en tientallen. De waardes uit beide arrays voegen we samen.
    $spellOutHour = $spellOutUnits[$hourUnit] . $spellOutTens[$hourTens-1];
}
else //Indien het uur >=20 en <24 gaan we waardes uit de array "spellOutUnits", "spellOutBetween" en "spellOutTens" samenvoegen.
{   //Het getal 20 kunnen we niet niet maken door verschillende arraywaardes te combinteren en geven we gewoon mee.
    if($hour == 20)
    {
        $spellOutHour = "twintig";
    }
    else
    {
        if($hourUnit == 2 || $hourUnit == 3) //Indien de eenheid van een getal = 2 of 3 is het tussenvoegsel "ën" ipv "en"
        {
            $spellOutHour = $spellOutUnits[$hourUnit] . $spellOutBetween[1] . $spellOutTens[$hourTens-1];
        }
        else
        {
            $spellOutHour = $spellOutUnits[$hourUnit] . $spellOutBetween[0] . $spellOutTens[$hourTens-1];
        }
    }
}

//Berekening notatie minuten
if($minute == 1) //Indien het uur bv. 02:01 is moet er "één" getoond worden ipv "een".
{
    $spellOutMinute = "één";
}
else if($minute>=0 && $minute<10) //Zelfde werking als bij uren
{
    $spellOutMinute = $spellOutUnits[$minuteUnit];
}
else if($minute>=10 && $minute<15) //Zelfde werking als bij uren
{
    $spellOutMinute = $spellOutUnits[$minute];
}
else if($minute>=15 && $minute<20) //Zelfde werkding als bij uren
{
    $spellOutMinute = $spellOutUnits[$minuteUnit] . $spellOutTens[$minuteTens-1];
}
else
{   //Er zijn nu meer tientallen die we niet kunne maken door verschillende arraywaardes te combinteren.
    if($minute == 20 || $minute == 30 || $minute == 40 || $minute == 50)
    {   //We geven de waarde gewoon mee. Omdat er deze keer meerdere getallen zijn maken we gebruik van een switch-statement.
        switch ($minute)
        {
            case 20:
               $spellOutMinute = "twintig";
               break;
            case 30:
               $spellOutMinute = "dertig";
               break;
            case 40:
               $spellOutMinute = "veertig";
               break;
            case 50:
               $spellOutMinute = "vijftig";
               break;
        }
    }
    else //Zelfde werkding als bij uren
    {
        if($minuteUnit == 2 || $minuteUnit == 3)
        {
            $spellOutMinute = $spellOutUnits[$minuteUnit] . $spellOutBetween[1] . $spellOutTens[$minuteTens-1];
        }
        else
        {
            $spellOutMinute = $spellOutUnits[$minuteUnit] . $spellOutBetween[0] . $spellOutTens[$minuteTens-1];
        }
    }
}

    /*echo "<br>";
    echo $spellOutHour;
    echo "<br>";
    echo $spellOutMinute;*/

?>

<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oefening 2</title>
</head>
<body>
    <p><? echo $timeChangedFormat ?> <!-- Weergeven van tijdstip -->
        <br>
        <!-- Uitgeschreven versie van tijdstip -->
        Het is <? echo $spellOutHour ?> uur en <? echo $spellOutMinute ?> minuten.</p>
</body>
</html>
