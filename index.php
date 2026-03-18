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
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5LFmho3OVVZ4pUMfgo8jy0pEHIF9Uib0"></script>

 <script src="https://code.jquery.com/jquery-4.0.0.js" integrity="sha256-9fsHeVnKBvqh3FB2HYu7g2xseAZ5MlN6Kz/qnkASV8U=" crossorigin="anonymous"></script>

 <!-- <script defer type="text/javascript" src="./assets/JS/weerlive.js"></script> -->
  <script defer type="text/javascript" src="./assets/JS/neerslag.js"></script>

  <script defer type="text/javascript" src="./assets/JS/moon.js"></script>
  <script defer type="text/javascript" src="./assets/JS/variables.js"></script>
  <!--<script defer type="text/javascript" src="./assets/JS/getWeatherByInput.js"></script> -->
</head>

<body>

<?php

date_default_timezone_set('Europe/Amsterdam');

require('./assets/api.php');

if ($_POST['plaats'] != '') {

$location = 'Lent'; //$_POST['plaats'];

}

/*else {

?>

<script>

if (navigator.geolocation) {
 navigator.geolocation.getCurrentPosition(getPositionByGPS);
}

function getPositionByGPS(position) {
      lat = position.coords.latitude
      long = position.coords.longitude
     
      console.log(lat)
      console.log(long)

   /* form = document.createElement("form");
    form.method = "post";
    form.action = './coordinates.php';
    input = document.createElement("input");
    input.setAttribute("lat", lat);
    input.setAttribute("long", long);
    form.appendChild(input);
    document.body.appendChild(form);
    form.submit();

}

</script> 

<?php

include ('./coordinates.php');

}
*/

$curl = curl_init();

$cur_url = 'https://weerlive.nl/api/weerlive_api_v2.php?key='. $api_key .'&locatie='.$location.'';

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

echo '<div class="main">';

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

<div class="container_top_blocks">

<div class="first_block"> </div>

<div class="location_block">

  <img id="kompas" onclick="getWeatherByLocation()" src="./assets/pics/kompas.png">

<div id="input">

  <form method="post" action="./">
     <input id="plaats" name="plaats" placeholder="Voer een plaats in Nederland in..."><br>
    <input id="submit_place" type="submit">
  </form>
 
 </div>
 </div>

 <div class="moon_block"> 

<div id="moon"></div>

 </div> 
 </div>

<table>
<tr>
<td>
 <div id="location"> ' .$_POST['plaats']. '</div>';

if ($_POST['plaats'] = '') {
  echo '<div id="gps"> (GPS) </div>';
}
 
echo '
</td>

<td> 
<div id="image">
 <img src="./assets/iconen-weerlive-wit/' . $response['liveweer'][0]['image'] . '.png">
</div>
</td>
</tr>

<tr>
<td>
<div class="container_temperature"> 
<div id="current_temperature">' . $response['liveweer'][0]['temp'] . ' ºC </div> 
</td>
<td></td>
</tr>

<tr>
<td>
<div id="minmax_temperature"> ' . $response['wk_verw'][0]['min_temp'] . ' / ' . $response['wk_verw'][0]['max_temp'] . ' ºC </div>
<div id="feel_temperature"> voelt als: ' . $response['liveweer'][0]['gtemp'] . ' ºC</div>
</div>
</td>
<td></td>
</tr>

<tr colspan="2">
<td>
<div class="sunriseset">
<img src="./assets/pics/sunrise1.png">  ' . $response['liveweer'][0]['sup'] . '
<img src="./assets/pics/sunset1.png"> ' . $response['liveweer'][0]['sunder'] . '

</td>
</tr>
</table>

<div id="weer"> '. $response['liveweer'][0]['verw'] . ' </div>';

  ?>

  <div id="arrow"> </div>
  <div id="winds"> </div>

  <div id="map"></div>
<!--
  <div id="button"></div>
  <div id="morgen"></div>
  <div id="overmorgen"> </div>
-->

<?php 

echo '

<div class="container_footer_blocks">

<div class="first_block"></div>

<div class="about_block">

  <div id="about"> Over deze site </div>

  <div id="overlay" onclick="off()">
    <div id="text">
      Deze weersite draag ik op aan mijn vader. <p>
        Als kind was ik al geobsedeerd door de apparaten (met diens geluiden) die in een donkere kamer op zolder
        stonden. Met daarbij nog een grote schotelantenne in de tuin kon hij de satellietfoto <i>downloaden</i> en ontwikkelen. De
        achtergrond van deze website toont een dergelijke foto die op 14 november 1980 door een
        NOAA-weersatelliet is gemaakt. Mijn vader haalde met zijn hobby op 17 september 1988 zelfs
        <a style="color:white;" href="./pics/krantartikel.png"> de regionale krant (De Limburger).</a>

        <div id="addition">Met eveneens Jan als voornaam hadden we onze eigen (legendarische) weerman Pelleboer in Ulestraten!</p></div>
      <p>
        Vandaag de dag ontvang ik de meteogegevens middels een API van <a style="color:white;"
          href="https://index.php" target="_blank">weerlive.nl</a> en verwerk ik ze in deze site. <br>
         Aan mij de creatieve uitdaging om droge kost aan informatie visueel te verwerken. Zo is de pijl na het achterhalen van de locatie ergens in
        Nederland in de opgegeven windrichting gedraaid en beweegt die vijf keer met een snelheid, afhankelijk van de
        windkracht, in die richting. 
        Daarnaast wordt de achtergrondfoto donkerder getoond, zodra de zon is ondergegaan en wordt de maan zichtbaar.
        Bij regen zijn druppels zichtbaar en is geluid hoorbaar (toegegeven: de twee laatste functionaliteiten heb ik niet zelf verzonnen).        <p>
        Negentien jaar na zijn dood (in 2001) houd ik op deze manier een mooie herinnering aan hem online.
      <p>

        <img id="doc2" src="./assets/pics/Docu_2.png">
        <img id="doc1" src="./assets/pics/Docu_1.png">
        <img src="./assets/pics/artikel_aankondiging.png">

</div>
</div>
</div>

<div class="last_check_block">

<div id="last_check"> ' . date('d-m-Y H:i' , $response['liveweer'][0]['timestamp']) . ' / 
' . $response['api'][0]['rest_verz'] . '</div>

</div>

</div>';

?>

</body>

</html>