<?php 
	require_once("../../inc/all.inc");
	header('Content-Type: text/javascript');
 	require_once("../../inc/classes/Search.php");
	$search = new Search($_SESSION['searchData']);
    $searchLocation = Geocoder::geocode($_SESSION['searchData']['mainsearch']);
	$result = $search -> performSearch();
?>

var searchLocation = <?php echo (isset($searchLocation) ? json_encode($searchLocation) : "{}"); ?>;
var properties = <?php echo (isset($result['properties']) ? json_encode($result['properties']) : "null"); ?>;

function initialize() {
	var mapOptions = {
	  center: new google.maps.LatLng(searchLocation.latitude, searchLocation.longitude),
	  zoom: 9,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var map = new google.maps.Map(document.getElementById("map-canvas"),
        mapOptions);
        
   	if(properties.length > 0) {
    	loadMarkers(map);
    }
}

function loadMarkers(map) {
	var markerBounds = new google.maps.LatLngBounds();
	
	// PLACE A MARKER FOR THE SEARCH LOCATION
	var latLng = new google.maps.LatLng(searchLocation.latitude, searchLocation.longitude);
	var image = {
		url: '/image/mapMarkers/searchLocation.png',
		size: new google.maps.Size(40, 40),
		origin: new google.maps.Point(0,0),
		anchor: new google.maps.Point(20,20)
	};
	var marker = new google.maps.Marker({
		position: latLng,
		map: map,
		icon: image
	});
	marker.setMap(map);
	markerBounds.extend(latLng);
	
	// CREATE A MARKER FOR EACH PROPERTY
	for(var i = 0; i < properties.length; i++) {
		property = properties[i];
		
		var latLng = new google.maps.LatLng(property.latitude, property.longitude);
		var image = {
			url: '/image/mapMarkers/marker_' + (i + 1) + '.png',
			size: new google.maps.Size(26, 32),
			origin: new google.maps.Point(0,0),
			anchor: new google.maps.Point(13,32)
		};
		var marker = new google.maps.Marker({
		    position: latLng,
		    map: map,
		    icon: image,
		    url: 'property_details.php?property=' + property.property_id
		});
		// Adds marker to map
		marker.setMap(map);
		markerBounds.extend(latLng);
		
		google.maps.event.addListener(marker, 'click', function() {
		  window.location.href = marker.url;
		});

	}
	
	map.fitBounds(markerBounds);
}

google.maps.event.addDomListener(window, 'load', initialize);
