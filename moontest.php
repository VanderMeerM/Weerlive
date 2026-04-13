<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<style>

    .container_moon {
    display: flex;
    padding: 50px;
    margin: auto;
    background-color: blue;
    width: fit-content;
    position: relative;
    }

.moon, 
.shade {
  height: 50px;
  width: 50px;
  background-color: white;
  border-radius: 50%;
  display: inline-block;
}

.shade {
    background-color: blue; /* bbb; */
    position: absolute;
 }

 .last_quarter {
    transform: translate(25px);
    border-radius: 0 20px 20px 0;
}

.first_quarter {
    transform: translate(-25px);
    border-radius: 20px 0 0 20px;
}

</style>

<?php 

$curl = curl_init();

$cur_url = 'https://moon-phase.p.rapidapi.com/basic';

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

print_r($response);

$illumination_perc = (explode('%', $response['illumination'])[0]) / 100;
$moon_stage = $response['stage'];


if ($illumination_perc < 50) {

   $moon_stage === 'waning' ? $shade_move = 50 + ($illumination_perc * 50):
   $shade_move = 50 - ($illumination_perc * 50);
};

echo '

<div class="container_moon">
<div class="moon"></div>
<div class="shade" style=left:'. $shade_move .'px></div>
</div>


</body>
</html>';
