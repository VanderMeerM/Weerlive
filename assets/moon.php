<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maantest</title>
   <link rel="stylesheet" href="./assets/CSS/style.css">

</head>
<body>
    
<?php 

$curl = curl_init();

$cur_url = 'https://moon-phase.p.rapidapi.com/basic?lat='.$_GET['lat'].'&lon='.$_GET['long'];

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
    'x-rapidapi-host: moon-phase.p.rapidapi.com',
	'x-rapidapi-key: eb3c079918mshfb3465ab1f83605p1c526cjsn1ce8ad3c3a15'
    ),
));

$response = curl_exec($curl);

$response = json_decode($response, true); 

$illumination_perc = (explode('%', $response['illumination'])[0]) / 100;
$moon_stage = $response['stage'];


echo '
<div class="container_moon">
<div class="moon"></div>';

if ($illumination_perc < 50) {

   $moon_stage === 'waning' ? $shade_move = 50 + ($illumination_perc * 50):
   $shade_move = 50 - ($illumination_perc * 50);

echo '
<div class="shade" style=left:'. $shade_move .'px></div>';
}

else {
    echo '<div class="oval_shade"></div>';
}

echo '
</div>

</body>
</html>';
