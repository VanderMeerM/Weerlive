
<?php


echo '

<div class="temperature_day_forecast_container">

<div class="temperature_now"> 

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

</table>

</div>

<div class="sunriseset">
<div><img src="./assets/pics/sunrise1.png">  ' . $response['liveweer'][0]['sup'] . '</div>
<div><img src="./assets/pics/sunset1.png"> ' . $response['liveweer'][0]['sunder'] . '</div>
</div>

<div class="day_forecast_container">';
 

for ($i=1; $i<5; $i++) {
    echo '
   
    <div class="day_forecast">

   <div id="width_day_forecast">' .   // datum 
    explode('-', $response['wk_verw'][$i]['dag'])[0] . '-' . 
    explode('-', $response['wk_verw'][$i]['dag'])[1] . 
    '</div>
    
<div id="width_day_forecast">
</div>

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
