<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maantest</title>
   <link rel="stylesheet" href="./CSS/style.css">

</head>
<body>
    
<?php 

$curl_moon = curl_init();

//$cur_url_moon = 'https://moon-phase.p.rapidapi.com/basic?lat='.$_GET['lat'].'&lon='.$_GET['long'];
$cur_url_moon = 'https://moon-phase.p.rapidapi.com/basic';


curl_setopt_array($curl_moon, array(
  CURLOPT_URL => $cur_url_moon,
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

$response_moon = curl_exec($curl_moon);
    
$response_moon = json_decode($response_moon, true); 

print_r($response_moon);

/*
print_r($response_moon = array (
    
    "phase_name" => "New Moon", 
    "stage" => "waning",
    "illumination" => "55%",
    "days_until_next_full_moon" => 14,
    "days_until_next_new_moon" => 0
    )
);
*/

$illumination_perc = (explode('%', $response_moon['illumination'])[0]) / 100;
$moon_stage = $response_moon['stage'];

echo '
<div class="container_moon">';
//<div class="moon"></div>';

if ($illumination_perc < 0.5) {

   $moon_stage === 'waning' ? $shade_move = 50 + ($illumination_perc * 50):
   $shade_move = 50 - ($illumination_perc * 50);

echo '
<div class="moon"></div>
<div class="shade" style=left:'. $shade_move .'px></div>';
}

else { 

echo '<div class="last_quarter">';
  
// van volle maan naar laatste kwartier 
// ovaal van breedte 50px naar 0 px; 
//left van 50 naar 25 px

   if($moon_stage === 'waning') {
    $move_oval = ($illumination_perc * 25) + 25;
    $width_oval = $illumination_perc * 50;
      echo '<div class="oval_shade" style=left:'.$move_oval.'px; width: '.$width_oval.'px></div>';
   }
   else {
    echo 'test';
   } 
   /*? $shade_move = 50 + ($illumination_perc * 50):
   $shade_move = 50 - ($illumination_perc * 50);

   // echo '<div class="shade" style=left:'. $shade_move .'px></div>
  echo '<div class="oval_shade"></div>';
*/
   }

?> 
</div>

</body>
</html>
