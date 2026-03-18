
<?php


echo '<div class="day_forecast_container">';
 

for ($i=1; $i<5; $i++) {
    echo '
   
    <div class="day_forecast">

    <div style="text-align:center">' .   // datum 
    explode('-', $response['wk_verw'][$i]['dag'])[0] . '-' . 
    explode('-', $response['wk_verw'][$i]['dag'])[1] . 
    '</div>
    
    <div style="margin: auto">

    <img src="./assets/iconen-weerlive-wit/' . $response['wk_verw'][$i]['image'] . '.png">
    ' . $response['wk_verw'][$i]['min_temp'] . ' /  
    ' . $response['wk_verw'][$i]['max_temp'] . ' ºC' . '
    
    </div> 

  <div style="margin: auto">

   <img src="./assets/pics/arrow.png" style="transform: rotate('.($response['wk_verw'][$i]['windrgr']+90).'deg) scale(0.33)">' //wind 
   
   . $response['wk_verw'][$i]['windbft'] . ' Bft' . 
    '</div>

  <div style="margin: auto"> 
   <img src="./assets/pics/regen.png">' 
   . $response['wk_verw'][$i]['neersl_perc_dag'] . '%' . // neerslagkans 

  '</div>

  <div style="margin: auto">
  <img src="./assets/pics/zon.png">'   
  . $response['wk_verw'][$i]['zond_perc_dag'] . '%' . // kans op zon 
  '</div>
                
  </div>';
}

echo '
</div></div>

<div class="hour_forecast_container">';

for ($i=0; $i < 24; $i++) {
    echo '
   
    <div class="hour_forecast">

    <div style="text-align:center">' .   // uurverwachting 
   date('H:i', $response['uur_verw'][$i]['timestamp']) . 
    '</div>
    
    <div style="margin: auto">

    <img src="./assets/iconen-weerlive-wit/' . $response['uur_verw'][$i]['image'] . '.png">
    ' . $response['uur_verw'][$i]['temp'] . ' ºC' . '
    
    </div> 
    
   <div style="margin: auto">
     <img src="./assets/pics/regen.png">'  
   . $response['uur_verw'][$i]['neersl'] . '%' . // neerslagkans 

  '</div>
  </div>';
}


  /*
  <div style="margin: auto">'  
  . $response['uur_verw'][$i]['zond_perc_dag'] . '%' . // kans op zon 
  '</div>
 */       
  
echo '
</div></div>';

//print_r($response['wk_verw']);
