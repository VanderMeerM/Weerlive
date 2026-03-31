
<script> 

setTimeout(() => getCoordinates(), 0);

function getCoordinates() {

//if (navigator.geolocation) {
 navigator.geolocation.getCurrentPosition(getPositionByGPS);


function getPositionByGPS(position) {
     lat = position.coords.latitude
     long = position.coords.longitude
        
   location.href = `./?lat=${lat}&long=${long}`;
   }

} 
 
</script>








