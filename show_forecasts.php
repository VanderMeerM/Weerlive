
<?php

include ('./assets/variables.php');

// Tijdstip zonsopgang en -ondergang naar timestamp converteren om maan wel/niet te tonen
// (voor zonsopgang danwel na zonsondergang)..

$hour_sup = explode(':', $response['liveweer'][0]['sup'])[0];
$min_sup = explode(':', $response['liveweer'][0]['sup'])[1];

$hour_sup_tstr = $hour_sup * 3600;
$min_sup_tstr = $min_sup * 60;

$hour_sunder = explode(':', $response['liveweer'][0]['sunder'])[0];
$min_sunder = explode(':', $response['liveweer'][0]['sunder'])[1];

$hour_sup_tstr = $hour_sup * 3600;
$min_sup_tstr = $min_sup * 60;

$hour_sunder_tstr = $hour_sunder * 3600;
$min_sunder_tstr = $min_sunder * 60;

$sup_tstr = strtotime("today") + $hour_sup_tstr + $min_sup_tstr;
$sunder_tstr = strtotime("today") + $hour_sunder_tstr + $min_sunder_tstr;


echo '

<div class="container_temperature">

<div class="empty_block"></div>

<div class="temperature_now"> 

<table>
<tr>
<td>
 <div id="location">' . $response['liveweer'][0]['plaats'] . '</div>';

if (!$_POST['place']) {
  echo '<div id="gps"> (GPS) </div>';
}
 
echo '
</td>

<td> 
<div id="image">
 <img src="./assets/iconen-weerlive_zw/' . $response['liveweer'][0]['image'] . '.png">
</div>
</td>
</tr>

<tr id="input_place" colspan="2">
<td> 
<div id="input">

  <form method="post" action="./">
     <input id="place" name="place" placeholder="Voer een plaats in Nederland in..."><br>
    <input id="submit_place" type="submit">
  </form>
 
 </div>
</td>
</tr>

<tr>
<td>
<div class="container_temperature">';

// Kleur (gevoels)temperatuur instellen 

$color = null;

if (floatval($response['liveweer'][0]['gtemp']) <= 5) {
  $color = '#16b7eb';
}
else if (floatval($response['liveweer'][0]['gtemp']) >= 30) {
  $color = '#e5355c';
}
else if (floatval($response['liveweer'][0]['gtemp']) >= 25) {
  $color = '#f59c0b';
}


echo '<div id="current_temperature" style="color: '.$color.'">' . $response['liveweer'][0]['temp'] . ' ºC </div> 
</td>
<td></td>
</tr>

<tr>
<td>
<div id="minmax_temperature"> ' . $response['wk_verw'][0]['min_temp'] . ' / ' . $response['wk_verw'][0]['max_temp'] . ' ºC </div>
<div id="feel_temperature" style="color: '.$color.'"> voelt als: ' . $response['liveweer'][0]['gtemp'] . ' ºC</div>
</div>
</td>
<td></td>
</tr>

</table>

</div>

<div class="moon_block">';

if ( ($sup_tstr > strtotime('now')) || ($sunder_tstr < strtotime('now')) ) {
echo '<div id="moon"></div>';
}

echo '
</div> 

</div>
</div>';

  /*
  <div style="margin: auto">'  
  . $response['uur_verw'][$i]['zond_perc_dag'] . '%' . // kans op zon 
  '</div>
 */       
  
echo '
</div></div>';

//print_r($response['wk_verw']);
