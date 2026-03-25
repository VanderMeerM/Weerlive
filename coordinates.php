
<form id="getCoordinates" name="getCoordinates" method="post">
  <input id="input_coordinates" type="text" name="coordinates">
  <input type="image" id="kompas" src="./assets/pics/kompas.png"> 
 
</form>


<script> 

window.onload= function() {

if (navigator.geolocation) {
 navigator.geolocation.getCurrentPosition(getPositionByGPS);
}

function getPositionByGPS(position) {
     lat = position.coords.latitude
     long = position.coords.longitude
     
     locationCoordinates= `${lat},${long}`; 
    
   document.getElementById('input_coordinates').value = locationCoordinates;
   }

} 
 
//setTimeout(() => { document.forms["getCoordinates"].submit(); }, 1000);
  
// if (5 > 4) { clearTimeout(send); }

</script>








