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


$cur_url = 'https://weerlive.nl/api/weerlive_api_v2.php?key='. $api_key .'&locatie=Lent';

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
    ),
));

$response = curl_exec($curl);

$response = json_decode($response, true);

//print_r($response['wk_verw']);

/*
$response = 

    [liveweer] => (
            [0] => (
                    [plaats] => Lent
                    [timestamp] => 1773160681
                    [time] => 10-03-2026 17:38:01
                    [temp] => 11.8
                    [gtemp] => 9.4
                    [samenv] => Zwaar bewolkt
                    [lv] => 86
                    [windr] => WZW
                    [windrgr] => 244.8
                    [windms] => 3.93
                    [windbft] => 3
                    [windknp] => 7.6
                    [windkmh] => 14.1
                    [luchtd] => 1015.44
                    [ldmmhg] => 762
                    [dauwp] => 9.5
                    [zicht] => 31400
                    [gr] => 84
                    [verw] => Vandaag af en toe zon en enkele buien. Woensdagochtend regen
                    [sup] => 07:00
                    [sunder] => 18:34
                    [image] => bewolkt
                    [alarm] => 0
                    [lkop] => Er zijn geen waarschuwingen
                    [ltekst] => Er zijn momenteel geen waarschuwingen van kracht. Uitgifte: 10/03/2026 16:52 uur LT
                    [wrschklr] => groen
                    [wrsch_g] => -
                    [wrsch_gts] => 0
                    [wrsch_gc] => -
                )

        )

    [wk_verw] => Array
        (
            [0] => Array
                (
                    [dag] => 10-03-2026
                    [image] => buien
                    [max_temp] => 13
                    [min_temp] => 9
                    [windbft] => 2
                    [windkmh] => 10
                    [windknp] => 6
                    [windms] => 3
                    [windrgr] => 222
                    [windr] => ZW
                    [neersl_perc_dag] => 50
                    [zond_perc_dag] => 23
                )

            [1] => Array
                (
                    [dag] => 11-03-2026
                    [image] => buien
                    [max_temp] => 10
                    [min_temp] => 6
                    [windbft] => 3
                    [windkmh] => 14
                    [windknp] => 8
                    [windms] => 4
                    [windrgr] => 232
                    [windr] => ZW
                    [neersl_perc_dag] => 50
                    [zond_perc_dag] => 25
                )

            [2] => Array
                (
                    [dag] => 12-03-2026
                    [image] => halfbewolkt
                    [max_temp] => 12
                    [min_temp] => 4
                    [windbft] => 3
                    [windkmh] => 18
                    [windknp] => 10
                    [windms] => 5
                    [windrgr] => 224
                    [windr] => ZW
                    [neersl_perc_dag] => 0
                    [zond_perc_dag] => 43
                )

            [3] => Array
                (
                    [dag] => 13-03-2026
                    [image] => buien
                    [max_temp] => 10
                    [min_temp] => 5
                    [windbft] => 4
                    [windkmh] => 21
                    [windknp] => 12
                    [windms] => 6
                    [windrgr] => 225
                    [windr] => ZW
                    [neersl_perc_dag] => 50
                    [zond_perc_dag] => 7
                )

            [4] => Array
                (
                    [dag] => 14-03-2026
                    [image] => halfbewolkt
                    [max_temp] => 8
                    [min_temp] => 3
                    [windbft] => 3
                    [windkmh] => 18
                    [windknp] => 10
                    [windms] => 5
                    [windrgr] => 232
                    [windr] => ZW
                    [neersl_perc_dag] => 0
                    [zond_perc_dag] => 45
                )

        )

    [uur_verw] => Array
        (
            [0] => Array
                (
                    [uur] => 10-03-2026 18:00
                    [timestamp] => 1773162000
                    [image] => lichtbewolkt
                    [temp] => 11
                    [windbft] => 2
                    [windkmh] => 7
                    [windknp] => 4
                    [windms] => 2
                    [windrgr] => 215
                    [windr] => ZW
                    [neersl] => 0
                    [gr] => 8
                )

            [1] => Array
                (
                    [uur] => 10-03-2026 19:00
                    [timestamp] => 1773165600
                    [image] => nachtbewolkt
                    [temp] => 11
                    [windbft] => 2
                    [windkmh] => 7
                    [windknp] => 4
                    [windms] => 2
                    [windrgr] => 212
                    [windr] => Z
                    [neersl] => 0
                    [gr] => 0
                )

            [2] => Array
                (
                    [uur] => 10-03-2026 20:00
                    [timestamp] => 1773169200
                    [image] => nachtbewolkt
                    [temp] => 10
                    [windbft] => 2
                    [windkmh] => 7
                    [windknp] => 4
                    [windms] => 2
                    [windrgr] => 173
                    [windr] => Z
                    [neersl] => 0
                    [gr] => 0
                )

            [3] => Array
                (
                    [uur] => 10-03-2026 21:00
                    [timestamp] => 1773172800
                    [image] => bewolkt
                    [temp] => 10
                    [windbft] => 2
                    [windkmh] => 10
                    [windknp] => 6
                    [windms] => 3
                    [windrgr] => 174
                    [windr] => Z
                    [neersl] => 0
                    [gr] => 0
                )

            [4] => Array
                (
                    [uur] => 10-03-2026 22:00
                    [timestamp] => 1773176400
                    [image] => regen
                    [temp] => 10
                    [windbft] => 2
                    [windkmh] => 10
                    [windknp] => 6
                    [windms] => 3
                    [windrgr] => 193
                    [windr] => Z
                    [neersl] => 0.2
                    [gr] => 0
                )

            [5] => Array
                (
                    [uur] => 10-03-2026 23:00
                    [timestamp] => 1773180000
                    [image] => regen
                    [temp] => 10
                    [windbft] => 3
                    [windkmh] => 18
                    [windknp] => 10
                    [windms] => 5
                    [windrgr] => 212
                    [windr] => Z
                    [neersl] => 0.3
                    [gr] => 0
                )

            [6] => Array
                (
                    [uur] => 11-03-2026 00:00
                    [timestamp] => 1773183600
                    [image] => helderenacht
                    [temp] => 10
                    [windbft] => 2
                    [windkmh] => 10
                    [windknp] => 6
                    [windms] => 3
                    [windrgr] => 208
                    [windr] => Z
                    [neersl] => 0
                    [gr] => 0
                )

            [7] => Array
                (
                    [uur] => 11-03-2026 01:00
                    [timestamp] => 1773187200
                    [image] => nachtbewolkt
                    [temp] => 9
                    [windbft] => 2
                    [windkmh] => 10
                    [windknp] => 6
                    [windms] => 3
                    [windrgr] => 196
                    [windr] => Z
                    [neersl] => 0
                    [gr] => 0
                )

            [8] => Array
                (
                    [uur] => 11-03-2026 02:00
                    [timestamp] => 1773190800
                    [image] => bewolkt
                    [temp] => 9
                    [windbft] => 3
                    [windkmh] => 14
                    [windknp] => 8
                    [windms] => 4
                    [windrgr] => 178
                    [windr] => Z
                    [neersl] => 0
                    [gr] => 0
                )

            [9] => Array
                (
                    [uur] => 11-03-2026 03:00
                    [timestamp] => 1773194400
                    [image] => bewolkt
                    [temp] => 9
                    [windbft] => 3
                    [windkmh] => 14
                    [windknp] => 8
                    [windms] => 4
                    [windrgr] => 186
                    [windr] => Z
                    [neersl] => 0
                    [gr] => 0
                )

            [10] => Array
                (
                    [uur] => 11-03-2026 04:00
                    [timestamp] => 1773198000
                    [image] => regen
                    [temp] => 9
                    [windbft] => 3
                    [windkmh] => 18
                    [windknp] => 10
                    [windms] => 5
                    [windrgr] => 183
                    [windr] => Z
                    [neersl] => 0.3
                    [gr] => 0
                )

            [11] => Array
                (
                    [uur] => 11-03-2026 05:00
                    [timestamp] => 1773201600
                    [image] => regen
                    [temp] => 9
                    [windbft] => 3
                    [windkmh] => 18
                    [windknp] => 10
                    [windms] => 5
                    [windrgr] => 195
                    [windr] => Z
                    [neersl] => 0.3
                    [gr] => 0
                )

            [12] => Array
                (
                    [uur] => 11-03-2026 06:00
                    [timestamp] => 1773205200
                    [image] => regen
                    [temp] => 9
                    [windbft] => 3
                    [windkmh] => 18
                    [windknp] => 10
                    [windms] => 5
                    [windrgr] => 200
                    [windr] => Z
                    [neersl] => 0.3
                    [gr] => 0
                )

            [13] => Array
                (
                    [uur] => 11-03-2026 07:00
                    [timestamp] => 1773208800
                    [image] => regen
                    [temp] => 9
                    [windbft] => 3
                    [windkmh] => 18
                    [windknp] => 10
                    [windms] => 5
                    [windrgr] => 200
                    [windr] => Z
                    [neersl] => 0.5
                    [gr] => 3
                )

            [14] => Array
                (
                    [uur] => 11-03-2026 08:00
                    [timestamp] => 1773212400
                    [image] => regen
                    [temp] => 9
                    [windbft] => 4
                    [windkmh] => 25
                    [windknp] => 14
                    [windms] => 7
                    [windrgr] => 202
                    [windr] => Z
                    [neersl] => 0.7
                    [gr] => 8
                )

            [15] => Array
                (
                    [uur] => 11-03-2026 09:00
                    [timestamp] => 1773216000
                    [image] => regen
                    [temp] => 9
                    [windbft] => 4
                    [windkmh] => 25
                    [windknp] => 14
                    [windms] => 7
                    [windrgr] => 204
                    [windr] => Z
                    [neersl] => 0.9
                    [gr] => 8
                )

            [16] => Array
                (
                    [uur] => 11-03-2026 10:00
                    [timestamp] => 1773219600
                    [image] => regen
                    [temp] => 9
                    [windbft] => 4
                    [windkmh] => 25
                    [windknp] => 14
                    [windms] => 7
                    [windrgr] => 209
                    [windr] => Z
                    [neersl] => 0.7
                    [gr] => 8
                )

            [17] => Array
                (
                    [uur] => 11-03-2026 11:00
                    [timestamp] => 1773223200
                    [image] => regen
                    [temp] => 9
                    [windbft] => 4
                    [windkmh] => 25
                    [windknp] => 14
                    [windms] => 7
                    [windrgr] => 219
                    [windr] => ZW
                    [neersl] => 0.6
                    [gr] => 8
                )

            [18] => Array
                (
                    [uur] => 11-03-2026 12:00
                    [timestamp] => 1773226800
                    [image] => regen
                    [temp] => 9
                    [windbft] => 4
                    [windkmh] => 25
                    [windknp] => 14
                    [windms] => 7
                    [windrgr] => 233
                    [windr] => ZW
                    [neersl] => 0.3
                    [gr] => 14
                )

            [19] => Array
                (
                    [uur] => 11-03-2026 13:00
                    [timestamp] => 1773230400
                    [image] => regen
                    [temp] => 9
                    [windbft] => 3
                    [windkmh] => 18
                    [windknp] => 10
                    [windms] => 5
                    [windrgr] => 260
                    [windr] => W
                    [neersl] => 0.1
                    [gr] => 22
                )

            [20] => Array
                (
                    [uur] => 11-03-2026 14:00
                    [timestamp] => 1773234000
                    [image] => bewolkt
                    [temp] => 10
                    [windbft] => 3
                    [windkmh] => 14
                    [windknp] => 8
                    [windms] => 4
                    [windrgr] => 266
                    [windr] => W
                    [neersl] => 0
                    [gr] => 119
                )

            [21] => Array
                (
                    [uur] => 11-03-2026 15:00
                    [timestamp] => 1773237600
                    [image] => bewolkt
                    [temp] => 10
                    [windbft] => 3
                    [windkmh] => 18
                    [windknp] => 10
                    [windms] => 5
                    [windrgr] => 276
                    [windr] => W
                    [neersl] => 0
                    [gr] => 260
                )

            [22] => Array
                (
                    [uur] => 11-03-2026 16:00
                    [timestamp] => 1773241200
                    [image] => bewolkt
                    [temp] => 10
                    [windbft] => 3
                    [windkmh] => 14
                    [windknp] => 8
                    [windms] => 4
                    [windrgr] => 272
                    [windr] => W
                    [neersl] => 0
                    [gr] => 158
                )

            [23] => Array
                (
                    [uur] => 11-03-2026 17:00
                    [timestamp] => 1773244800
                    [image] => bewolkt
                    [temp] => 10
                    [windbft] => 3
                    [windkmh] => 14
                    [windknp] => 8
                    [windms] => 4
                    [windrgr] => 276
                    [windr] => W
                    [neersl] => 0
                    [gr] => 61
                )

        )

    [api] => Array
        (
            [0] => Array
                (
                    [bron] => Bron: Weerdata KNMI/NOAA via Weerlive.nl
                    [disclaimer] => Deze API is alleen voor studie en hobby, professioneel gebruik via meteoserver.nl
                    [max_verz] => 300
                    [rest_verz] => 288
                )

        )

)


  
*/

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
'<div id="regenzon"> ';
//<img src="./pics/regen.png"> ' . $response['liveweer'][0]['d0neerslag']  . '<br>
//<img src="./pics/zon.png">  ' . $response['liveweer'][0]['d0zon'] . '<br>
echo 
'<img src="./pics/sunrise1.png">  ' . $response['liveweer'][0]['sup'] . '<br>
<img src="./pics/sunset1.png"> ' . $response['liveweer'][0]['sunder'] . '
</div>

<div id="temperatuur">
' . $response['wk_verw'][0]['min_temp'] . '/ ' . $response['wk_verw'][0]['max_temp'] . 'ºC<br><p>'
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