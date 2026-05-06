   
<?php 

$curl_moon = curl_init();

$cur_url_moon = 'https://moon-phase.p.rapidapi.com/basic?lat='.$_GET['lat'].'&lon='.$_GET['long'];
//$cur_url_moon = 'https://moon-phase.p.rapidapi.com/basic';


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

//print_r($response_moon);

/*
print_r($response_moon = array (
    
    "phase_name" => "Waning gibbous", 
    "stage" => "waning",
    "illumination" => "82%",
    "days_until_next_full_moon" => 25,
    "days_until_next_new_moon" => 10
    )
);
*/

$illumination_perc = (explode('%', $response_moon['illumination'])[0]) / 100;
$moon_stage = $response_moon['stage'];
$phase_name = $response_moon['phase_name'];
$moon_width = 50;

echo '
<div class="container_moon">';

if ($phase_name === 'Full Moon') {

   echo '<div class="moon"></div>';
}

elseif ($illumination_perc < 0.5) {

   $moon_stage === 'waning' ? $shade_move = $moon_width  + ($illumination_perc * $moon_width ):
   $shade_move = 50 - ($illumination_perc * $moon_width );

echo '
<div class="moon"></div>
<div class="shade" style=left:'. $shade_move .'px></div>';
}

else {  // verlichting > 0,5 

/* van volle maan naar laatste kwartier 
verlichting van 1 naar 0,5
ovaal van breedte 25 naar 0px; 
right van 25 naar 50 px v
*/

/* van eerste kwartier naar volle maan 
verlichting van 0,5 naar 1
ovaal van breedte 25 naar 0px; 
right van 0 naar 25 px 
*/
   $width_oval = ($illumination_perc * $moon_width ) - ($moon_width / 2);

   if ($moon_stage === 'waning') {
    
    echo '<div class="last_quarter">';
   
    $move_oval = ($moon_width * 0.5) - ($illumination_perc * $moon_width);
   
     echo '<div class="first_quarter" style="right:'.$move_oval.'px; width: '.$width_oval.'px"></div>';

   }
   else {

    echo '<div class="first_quarter">';

    $move_oval =  ($illumination_perc * $moon_width) - ($moon_width / 2);
   
    echo '<div class="last_quarter" style="right:'.$move_oval.'px; width: '.$width_oval.'px"></div>';

   } 
   }

?> 

