
<?php


echo '

<div class="temperature_day_forecast_container">

<div class="empty_block"></div>

<div class="temperature_now"> 

<table>
<tr>
<td>
 <div id="location">' . $_POST['place'] . '</div>';

if ($_POST['place'] = '') {
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

<div class="moon_block"> 
<div id="moon"></div>
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
