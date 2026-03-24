
<script> 
if (navigator.geolocation) {
 navigator.geolocation.getCurrentPosition(getPositionByGPS);
}

function getPositionByGPS(position) {
      lat = position.coords.latitude
      long = position.coords.longitude
     
      document.getElementById('lat').value = lat
     document.getElementById('long').value = long
}

let sendCoordinates = document.getElementById("getCoordinates");

sendCoordinates.addEventListener("submit", e => {
  e.preventDefault()
});

</script>


<?php

echo '
<form action="./" id="getCoordinates" method="post">
  <input type="text" name="lat" id="lat">
  <input type="text" name="long" id="long">
  <button type="submit">Submit</button>
</form>';

echo 'Plaats: ' . $_POST['lat'];
