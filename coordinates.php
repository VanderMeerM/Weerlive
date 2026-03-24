
<script defer> 

if (navigator.geolocation) {
 navigator.geolocation.getCurrentPosition(getPositionByGPS);
}

if (document.getElementById("getCoordinates") != null) {
 document.getElementById("getCoordinates").submit();
}
 

function getPositionByGPS(position) {
      lat = position.coords.latitude
      long = position.coords.longitude
     
     locationCoordinates= `${lat},${long}`; 
     document.getElementById('input_coordinates').value = locationCoordinates;
}

</script>


<form action="./" id="getCoordinates" method="post">
  <input id="input_coordinates" type="text" name="coordinates">
  <input type="image" id="kompas" src="./assets/pics/kompas.png"> 
  <!-- <input type="submit"> -->

</form>


