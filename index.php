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

 <!--<script defer type="text/javascript" src="./assets/JS/weerlive.js"></script>-->
  <script defer type="text/javascript" src="./assets/JS/neerslag.js"></script>

  <script defer type="text/javascript" src="./assets/JS/moon.js"></script>
  <!--<script defer type="text/javascript" src="./assets/JS/variables.js"></script>
  <script defer type="text/javascript" src="./assets/JS/getWeatherByInput.js"></script> -->
</head>

<body>

<?php

date_default_timezone_set('Europe/Amsterdam');

require('./assets/api.php');

//echo 'Plaats ' . $_POST['place'];

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


/*

 <div class="back-row-toggle splat-toggle">
  <div class="rain front-row"></div>
  <div class="rain back-row"></div>
  <div class="toggles"></div>
  </div>
*/

echo '

  <audio id="rainsound">
    <source src="./assets/rain.mp3" type="audio/mpeg">
  </audio>

<div class="main">';


if ($_POST['place']) {
echo '
<form id="getCoordinates" name="getCoordinates" method="post">
  <input id="input_coordinates" type="text" name="coordinates">
  <input type="image" id="kompas" src="./assets/pics/kompas.png"> 
</form>';
}

echo '
<div id="weer"> '. $response['liveweer'][0]['verw'] . ' </div>

<div class="sunriseset">
<div><img src="./assets/pics/sunrise1.png">  ' . $response['liveweer'][0]['sup'] . '</div>
<div><img src="./assets/pics/sunset1.png"> ' . $response['liveweer'][0]['sunder'] . '</div>
</div>

<div id="last_update"> Laatste update: <br>' . date('d-m-Y H:i' , $response['liveweer'][0]['timestamp']) . '</div>


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

<div class="container_details">

<div class="container_arrow">';

$turndegr = floatval($response['liveweer']['0']['windrgr'])+90;

echo '<div id="arrow" style= "transform: rotate('.$turndegr.'deg);"> 
<img src= "./assets/pics/arrow.png">
</div>

</div>

<div class="info_details">

<table>
<tr>
<td>
Windkracht </td>
<td>' . $response['liveweer']['0']['windbft'] . ' Bft</td>
</tr>
<tr>
<td>
Luchtvochtigheid </td>
<td>' . $response['liveweer']['0']['lv'] . '%</td>
</tr>
<tr>
<td>Luchtdruk </td>
<td>' . $response['liveweer'][0]['luchtd'] . '</td>
</tr>
<tr>
<td>Dauwpunt </td>
<td>' .  $response['liveweer']['0']['dauwp'] .'</td>
</tr>
<tr>
<td>Zicht </td>
<td>' .  $response['liveweer']['0']['zicht'] . '</td>
</tr>
</table>';

//echo '</div>';

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



/*
<div class="location_block">

  <img id="kompas" onclick="getWeatherByLocation()" src="./assets/pics/kompas.png">

 </div>
*/

$days = [
    'Sun' => 'ZO',
    'Mon' => 'MA', 
    'Tue' => 'DI', 
    'Wed' => 'WO',
    'Thu' => 'DO',
    'Fri' => 'VR',
    'Sat' => 'ZA'
];


echo '
</div>
<div class="day_forecast_container">';

for ($i=1; $i<5; $i++) {

    echo '   
    <div class="day_forecast">

   <div id="width_day_forecast">' .   // datum 
 
   $days[date('D', strtotime($response['wk_verw'][$i]['dag']))] . 
   // explode('-', $response['wk_verw'][$i]['dag'])[0] . '-' . 
   // explode('-', $response['wk_verw'][$i]['dag'])[1] . 
    '</div>
    
  <div id="width_day_forecast">
    <img src="./assets/iconen-weerlive-wit/' . $response['wk_verw'][$i]['image'] . '.png">
    ' . $response['wk_verw'][$i]['min_temp'] . ' /  
    ' . $response['wk_verw'][$i]['max_temp'] . ' ºC' . '
   </div> 

  <div id="width_day_forecast">
   <img src="./assets/pics/arrow.png" style="transform: rotate('.($response['wk_verw'][$i]['windrgr']+90).'deg) scale(0.33)">' //wind 
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

 <div id="overlay" onclick="off()">
    <div id="text">
      Deze weersite draag ik op aan mijn vader. <p>
        Als kind was ik al geobsedeerd door de apparaten die in een donkere kamer op zolder stonden. 
        Met behulp van een grote schotelantenne, die bij ons in de tuin stond opgesteld, ontving hij de gegevens van een weersatelliet en ontwikkelde hij de foto. De geluiden tijdens het ontvangen deden me denken aan de eerste internetmodems; om met een modern begrip te praten downloadde hij de foto eigenlijk - en dat in de jaren 80 toen internet nog niet eens bestond! De achtergrond van deze site toont een dergelijke foto die op 14 november 1980 is gemaakt door een NOAA-weersatelliet. <br>
        
        Mijn vader haalde met zijn hobby op 17 september 1988 zelfs
        <a style="color:white;" href="./assets/pics/krantartikel.png"> de regionale krant (De Limburger).</a>

        <div id="addition">Met eveneens Jan als voornaam hadden we in Ulestraten dus eigenlijk onze eigen (legendarische) weerman Pelleboer!</p></div>
      <p>
        Vandaag de dag ontvang ik de meteogegevens middels een API van <a style="color:white;"
          href="https://weerlive.nl" target="_blank">weerlive.nl</a> en verwerk ik ze in deze site. <br>
        
         Voor mij is de creatieve uitdaging om de droge kost aan informatie een beetje bijzonder te tonen. Zo is de pijl in de windrichting gedraaid en beweegt die met een snelheid, afhankelijk van de windkracht. 
        Daarnaast wordt de achtergrondfoto donkerder, zodra de zon is ondergegaan en wordt de maan dan ook zichtbaar (ok, deze laatste functionaliteit heb ik niet zelf verzonnen).<p>
        Mijn vader overleed in juli 2001. Ik houd op deze manier een mooie herinnering aan hem online.
      <p>

        <img id="doc2" src="./assets/pics/Docu_2.png">
        <img id="doc1" src="./assets/pics/Docu_1.png">
        <img src="./assets/pics/artikel_aankondiging.png">

</div>
</div>

<div class="container_footer_blocks">

<div class="empty_block"></div>

<div class="about_block">

  <div id="about"> Over deze site </div>

 </div>

<div class="last_check_block">

<div id="last_check"> ' . $response['api'][0]['rest_verz'] . '</div>

</div>
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