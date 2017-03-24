<?php 
    require_once("../../inc/all.inc");
    header('Content-Type: text/javascript');
    require_once("../../inc/classes/PropertyDetails.php");
    require_once("../../inc/classes/Property.php");
     
    if(isset($_GET['property'])) {
        $property = new Property($_GET['property']);
    } else {
        die();
    }
?>

var propertyLoc = <?php echo (isset($property -> coordinates) ? json_encode($property -> coordinates) : "{}"); ?>;

function initialize() {
    var mapOptions = {
      center: new google.maps.LatLng(propertyLoc.latitude, propertyLoc.longitude),
      zoom: 15,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map = new google.maps.Map(document.getElementById("map-canvas"),
        mapOptions);
        
    loadMarkers(map);
}

function loadMarkers(map) {

    
    // PLACE A MARKER FOR THE PROPERTY
    var latLng = new google.maps.LatLng(propertyLoc.latitude, propertyLoc.longitude);
    var image = {
        url: '/image/mapMarkers/house.png',
        size: new google.maps.Size(39, 47),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(19.5,47)
    };
    var marker = new google.maps.Marker({
        position: latLng,
        map: map,
        icon: image
    });
    marker.setMap(map);
 
}

google.maps.event.addDomListener(window, 'load', initialize);