<?php

class Geocoder {
    static function geocode($string){
       $string = str_replace (" ", "+", urlencode($string));
       $details_url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$string."&sensor=false";
     
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $details_url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       $response = json_decode(curl_exec($ch), true);
     
       // If Status Code is ZERO_RESULTS, OVER_QUERY_LIMIT, REQUEST_DENIED or INVALID_REQUEST
       if ($response['status'] != 'OK') {
        return null;
       }
       
       $geometry = $response['results'][0]['geometry'];
     
        $longitude = $geometry['location']['lat'];
        $latitude = $geometry['location']['lng'];
     
        $array = array(
            'latitude' => $geometry['location']['lat'],
            'longitude' => $geometry['location']['lng'],
            'location_type' => $geometry['location_type'],
        );
     
        return $array;
    }
}

?>