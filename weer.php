<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Marcels weersite</title>
  <link rel="shortcut icon" href="./pics/favicon.ico">
  <script src="https://code.jquery.com/jquery-2.1.1.js"></script>

  <link rel="stylesheet" href="./style.css">
  <link rel="stylesheet" href="./style_rain.css">

  <link href="https://fonts.googleapis.com/css2?family=Comic+Neue:wght@300&display=swap" rel="stylesheet">
  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD5LFmho3OVVZ4pUMfgo8jy0pEHIF9Uib0"></script>

  <script defer type="text/javascript" src="./JS/weerlive.js"></script>
  <script defer type="text/javascript" src="./JS/neerslag.js"></script>

  <script defer type="text/javascript" src="./JS/moon.js"></script>
  <script defer type="text/javascript" src="./JS/variables.js"></script>
  <script defer type="text/javascript" src="./JS/getWeatherByInput.js"></script>
</head>

<?php

require('./api.php');

$cur_url = 'https://weerlive.nl/api/weerlive_api_v2.php?key=6'. $api_key .'&locatie=Lent';

$curl = curl_init();

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
      /*'x-rapidapi-key: ' . $api_key .'',
     'x-rapidapi-key: 863bcd048478f98225b64bced629b376',
     'x-rapidapi-host: v3.football.api-sports.io',
    */
  ),
));

$response = curl_exec($curl);

$response = json_decode($response, true);

//print_r($response['liveweer'][0]);

?>

<body class="back-row-toggle splat-toggle">
  <div class="rain front-row"></div>
  <div class="rain back-row"></div>
  <div class="toggles"></div>
  </div>

  <audio id="rainsound">
    <source src="./rain.mp3" type="audio/mpeg">
  </audio>

  <img id="kompas" onclick="getWeatherByLocation()" src='./pics/kompas.png'>

  <div id="input">
    <input id="plaats" placeholder="Voer een plaats in Nederland in...">
  </div>

  <div id="location">
    Het weer in <br>Lent
  <span style="font-size:10px;"> (huidige locatie) </span>
  </div>

  <div id="moon"></div>

  <?php

echo 
'<div id="regenzon"> 
<img src="./pics/regen.png"> ' . $response['liveweer'][0]['d0neerslag']  . '<br>
<img src="./pics/zon.png">  ' . $response['liveweer'][0]['d0zon'] . '<br>
<img src="./pics/sunrise1.png">  ' . $reponse['liveweer'][0]['sup'] . '<br>
<img src="./pics/sunset1.png"> ' . $response['liveweer'][0]['sunder'] . '
</div>

<div id="temperatuur">
' . $response['liveweer'][0]['min_temp'] . '/ ' . $response['liveweer'][0]['max_temp'] . 'ºC<br><p>'
  . $response['liveweer'][0]['temp'] . '<font size="5">ºC</font></font><br><p>
voelt aan als:</font><br>' . $response['liveweer'][0]['gtemp'] . 'ºC
</div>

<p></p>

  <div id="weer"> </div>
  <div id="image">
    <img src="./iconen-weerlive-wit/' . $response['liveweer'][0]['image'] . '.png">
  </div>';

  ?>

  <div id="arrow"> </div>
  <div id="winds"> </div>

  <div id="map"></div>

  <div id="button"></div>
  <div id="morgen"></div>
  <div id="overmorgen"> </div>

  <div id="about"> Over deze site </div>
  <div id="overlay" onclick="off()">
    <div id="text">
      Deze weersite draag ik op aan mijn vader. <p>
        Als kind was ik al geobsedeerd door de apparaten (met diens geluiden) die in een donkere kamer op zolder
        stonden. Met
        daarbij nog een grote schotelantenne in de tuin kon hij de satellietfoto 'downloaden' en ontwikkelen. De
        achtergrond van deze website toont zo'n foto die op 14 november 1980 door een
        NOAA-weersatelliet is gemaakt. Mijn vader haalde met zijn hobby op 17 september 1988 zelfs
        <a style="color:white;" href="./pics/krantartikel.png"> de regionale krant (De Limburger).</a>

        <div id="addition">Met eveneens Jan als voornaam hadden we onze eigen (legendarische) weerman Pelleboer in Ulestraten!</p></div>
      <p>
        Vandaag de dag ontvang ik de meteogegevens middels een API van <a style="color:white;"
          href="https://index.php" target="_blank">weerlive.nl</a> en verwerk ik ze in deze site. <br>De
        creatieve uitdaging vind ik de 'droge
        kost' aan informatie visueel te verwerken. Zo is de pijl na het achterhalen van de locatie ergens in
        Nederland
        in de opgegeven windrichting gedraaid en beweegt die vijf keer met een snelheid, afhankelijk van de
        windkracht, in die richting.
        Daarnaast wordt de achtergrondfoto donkerder getoond, zodra de zon is ondergegaan en wordt de maan zichtbaar.
        Bij regen zijn druppels zichtbaar en is geluid hoorbaar (toegegeven: de twee laatste functionaliteiten heb ik niet zelf verzonnen).        <p>
        Negentien jaar na zijn dood (in 2001) houd ik op deze manier een mooie herinnering aan hem online.
      <p>


        <img id="doc2" src='./pics/Docu_2.png'>
        <img id="doc1" src='./pics/Docu_1.png'>
        <img src='./pics/artikel_aankondiging.png'>


    </div>
  </div>

</body>

</html>