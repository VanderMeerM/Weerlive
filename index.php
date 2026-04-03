<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marcels weersite</title>
  <link rel="shortcut icon" href="./assets/pics/favicon.ico">
  <script src="https://code.jquery.com/jquery-2.1.1.js"></script>

  <link rel="stylesheet" href="./assets/CSS/style.css">
  <link rel="stylesheet" href="./assets//CSS/style_rain.css">

  <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@300&display=swap" rel="stylesheet">
  
 <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>

  <script defer type="text/javascript" src="./assets/JS/neerslag.js"></script>
  <script defer type="text/javascript" src="./assets/JS/moon.js"></script>
  
</head>

<body>

<!--  
Direct pagina laden bij aanklikken tabblad in browser en 
elk kwartier pagina herladen om gegevens te updaten..
-->

<script>
  document.addEventListener("visibilitychange", function() {
    if (!document.hidden){
       window.location.reload();
    }
});
      setTimeout(() => {
       window.location.href = window.location;
    }, 60 * 15 * 1000);
</script>

<?php

date_default_timezone_set('Europe/Amsterdam');

require('./assets/api.php');

include ('./assets/variables.php');

if (!$_POST['place']) {

if ( (!$_GET['lat']) && (!$_GET['long']) ) {

include ('./coordinates.php');

$location = $_GET['lat'] + ',' + $_GET['long']; 

}

elseif (!$_POST['place']) {

  $location = $_GET['lat'] . ',' . $_GET['long']; 

}
}
else {
  $location = $_POST['place'];
}


$curl = curl_init();

$cur_url = 'https://weerlive.nl/api/weerlive_api_v2.php?key='. $api_key .'&locatie=' . $location . '';

curl_setopt_array($curl, array(
  CURLOPT_URL => $cur_url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    ),
));

$response = curl_exec($curl);

$response = json_decode($response, true); 

include('./show_forecasts.php');

$wind_bft = $response['liveweer']['0']['windbft'];

/* 'Regenmaker' 

 <div class="back-row-toggle splat-toggle">
  <div class="rain front-row"></div>
  <div class="rain back-row"></div>
  <div class="toggles"></div>
  </div>
*/

// Juiste achtergrond instellen..

if ( (strtotime("now") > ($sunder_tstr- 60 * 30)) ||  (strtotime("now") < ($sup_tstr- 60 * 30)) ) {
  $bgr_picture = '30';
}
else if ( (strtotime("now") > ($sunder_tstr- 60 * 15)) ||  (strtotime("now") < ($sup_tstr- 60 * 15)) ) {
  $bgr_picture = '15';
}
else if ( (strtotime("now") > $sunder_tstr) ||  (strtotime("now") < $sup_tstr) ) {
  $bgr_picture = '100';
} 
else {
  $bgr_picture = '0';
}


echo '

  <audio id="rainsound">
    <source src="./assets/rain.mp3" type="audio/mpeg">
  </audio>

<div class="main" style="background-image: url(./assets/pics/Background/Europa_dark'.$bgr_picture.'.png)">';


if ($_POST['place']) {
echo '
<form id="getCoordinates" name="getCoordinates" method="post">
  <input id="input_coordinates" type="text" name="coordinates">
  <input type="image" id="kompas" src="./assets/pics/kompas.png"> 
</form>';
}

echo '
<div id="weer"> '. $response['liveweer'][0]['verw'] . ' </div>

<div class="container_sun">

<div class="sunriseset">
<div><img src="./assets/pics/zonsopkomst.png">  ' . $response['liveweer'][0]['sup'] . '</div>
<div><img src="./assets/pics/zonsondergang.png"> ' . $response['liveweer'][0]['sunder'] . '</div>
</div>';

$turndegr = floatval($response['liveweer']['0']['windrgr'])+90;

// Snelheid pijl bepalen (aan de hand van de windkracht)..

 if ( ($wind_bft >= 0) && ($wind_bft) <= 3) {
                  $speed = (3 - (0.5 * ($wind_bft - 1)));
                }
  else if ( ($wind_bft >= 4) && ($wind_bft) <= 10) {
                $speed = (1.75 - (0.25 * ($wind_bft - 4)));
                } 
      else {
        $speed = 0.15;
      }
              

echo '
<div class="main_container_arrow">

<div class="container_arrow" style="transform: rotate('.$turndegr.'deg);">

<div id="arrow" style= "animation: movearrow '.$speed.'s infinite;"> 
<img src= "./assets/pics/arrow.png">
</div>
</div>';

echo '
<style>
@keyframes movearrow {
  from {left: 0px;}
  to {left: 150px;}
}
</style>

<div id="wind_text"> <img src="./assets/pics/wind_icon_w.png"> '
. $wind_bft . ' Bft </div>

</div>
</div>

<div class="hour_forecast_container">';

for ($i=0; $i < 24; $i++) {
    echo '
   
    <div class="hour_forecast">

    <div style="text-align:center">' .   // uurverwachting 
   date('H', $response['uur_verw'][$i]['timestamp']) . 
    '</div>
    
    <div>

    <img src="./assets/iconen-weerlive-wit/' . $response['uur_verw'][$i]['image'] . '.png"><br>
    ' . $response['uur_verw'][$i]['temp'] . ' ºC' . '
    
    </div> 
    
   <div style="display: inline-flex">
     <img src="./assets/pics/regen.png">'  
   . $response['uur_verw'][$i]['neersl'] . '%' . // neerslagkans 

  '</div>
  </div>';
}

echo '</div>

<div class="container_day_forecast_and_details">

<div class="day_forecast_container">';

for ($i=1; $i<5; $i++) {

    echo '   
    <div class="day_forecast">

   <div id="width_day_forecast">' .   // datum 
 
   $days[date('D', strtotime($response['wk_verw'][$i]['dag']))] . 
  '</div>
    
  <div id="width_day_forecast">
    <img src="./assets/iconen-weerlive-wit/' . $response['wk_verw'][$i]['image'] . '.png">
    ' . $response['wk_verw'][$i]['min_temp'] . ' /  
    ' . $response['wk_verw'][$i]['max_temp'] . ' ºC' . '
   </div> 

  <div id="width_day_forecast">
   <img id="arrow_forecast_day" src="./assets/pics/arrow.png" style="transform: rotate('.($response['wk_verw'][$i]['windrgr']+90).'deg) scale(0.33)">' //wind 
   . $response['wk_verw'][$i]['windbft'] . ' Bft' . '
   </div>

  <div id="width_day_forecast">
   <img src="./assets/pics/regen.png">' 
   . $response['wk_verw'][$i]['neersl_perc_dag'] . '%' .  // neerslagkans 
  '</div>

 <div id="width_day_forecast">
  <img src="./assets/pics/zon.png">'   
  . $response['wk_verw'][$i]['zond_perc_dag'] . '%' . // kans op zon 
  '</div>
                
  </div>';
}


echo '</div>
<div class="container_details">

<div class="info_details">

<table>
<tr>
<td>
Rel. luchtvochtigheid </td>
<td>' . $response['liveweer']['0']['lv'] . '%</td>
</tr>
<tr>
<td>Luchtdruk </td>
<td>' . $response['liveweer'][0]['luchtd'] . ' hPa</td>
</tr>
<tr>
<td>Dauwpunt </td>
<td>' .  $response['liveweer']['0']['dauwp'] .'°C</td>
</tr>
<tr>
<td>Zicht </td>
<td>' .  $response['liveweer']['0']['zicht'] . ' m</td>
</tr>
<tr>
<td>Glob. zonnestraling </td>
<td>' .  $response['liveweer']['0']['gr'] . ' Watt/m2</td>
</tr>
</table>';

echo '
</div>';

echo '</div></div>';

echo '<div class="weather_warning">

' . $response['liveweer']['0']['ltekst'] . '<br>';


if ($response['liveweer']['0']['alarm'] != 0) {
echo '
Kleurcode: ' .  $response['liveweer']['0']['wrschklr']  . '<br>';
}

if ($response['liveweer']['0']['wrsch_gts'] != 0) {
echo '
Weerwaarschuwing vanaf: ' . $response['liveweer']['0']['wrsch_g'] . '/'
 . $response['0']['wrsch_gc'] . '';
}         


echo '
</div>

 <div id="overlay" onclick="off()">
    <div id="text">
      Deze weersite draag ik op aan mijn vader. <p>
        Als kind was ik al geobsedeerd door de apparaten die in een donkere kamer bij ons thuis op zolder stonden. 
        Met behulp van een grote schotelantenne, die bij ons in de tuin stond, ontving hij de gegevens van een weersatelliet en ontwikkelde hij de satellietfoto. De geluiden tijdens het ontvangen deden me denken aan de eerste internetmodems; om met een modern begrip te praten downloadde hij de foto - in een tijd dat internet nog niet eens bestond! De achtergrond van deze site toont een dergelijke foto die op 14 november 1980 is gemaakt door een NOAA-weersatelliet. <br>
        
        Mijn vader haalde met zijn hobby op 17 september 1988 zelfs
        <a style="color:white;" href="./assets/pics/krantartikel.png"> de regionale krant (De Limburger).</a>

        <p>
        Vandaag ontvang ik de meteogegevens middels een API van <a style="color:white;"
          href="https://weerlive.nl" target="_blank">weerlive.nl</a> en verwerk ik ze in deze site. Voor mij is de creatieve uitdaging om de droge kost aan informatie een beetje bijzonder te tonen. Zo is de pijl in de windrichting gedraaid en beweegt die met een snelheid die afhankelijk is van de windkracht. 
        Daarnaast wordt de achtergrondfoto donkerder, zodra de zon opkomt of ondergaat en wordt de maan zichtbaar (ok, deze laatste functionaliteit heb ik niet zelf verzonnen).<p>
        Mijn vader overleed in juli 2001. Op deze manier houd ik een mooie herinnering aan hem online.
      <p>

        <img id="doc2" src="./assets/pics/Docu_2.png">
        <img id="doc1" src="./assets/pics/Docu_1.png">
        <img src="./assets/pics/artikel_aankondiging.png">
<p><u>Disclaimer:</u> <br>
Afbeeldingen zon: Isfan Wahyudi
</div>
</div>

<div class="container_footer_blocks">

<div class="empty_block"></div>

<div class="about_block">

  <div id="about"> Over deze site </div>

 </div>

<div class="last_check_block">

<div id="last_update"> Update: ' . date('H:i' , $response['liveweer'][0]['timestamp']) . ' / ' .$response['api'][0]['rest_verz'] .'</div>

</div>
</div>';

?>

<script>
  document.getElementById('location').addEventListener('click', () => {
    document.getElementById('input_place').style.display = 'block';
    });


document.getElementById('about').addEventListener('click', () => {
    console.log('test'); 
    on()
})

function on() {
    document.getElementById("overlay").style.display = "block";
}

function off() {
    document.getElementById("overlay").style.display = "none";
}


</script>

</body>

</html>