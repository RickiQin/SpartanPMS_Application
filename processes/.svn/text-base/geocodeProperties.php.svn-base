<pre>
<?php

require_once("../inc/classes/Property.php");

try {
    $dbuser = "spartan";
    $pass = "spartan2013";
    $host = "localhost";  
    $dbname = "spartan_db"; 
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $pass); 
    $DBH -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $DBH -> setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );    
    $DBH -> setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);  
} catch(PDOException $e) {
    echo $e -> getMessage();
    file_put_contents('./logs/sharepoint_PDOErrors.txt', $e->getMessage(), FILE_APPEND);  
}

$STH = $DBH -> query("SELECT properties.* FROM properties LEFT JOIN property_coordinates ON property_coordinates.property_id = properties.property_id WHERE property_coordinates.property_id IS NULL LIMIT 10");
$properties = $STH -> fetchAll(); 
print_r($properties);
foreach($properties AS $property) {
    $property = new Property($property);
    print_r($property);
}

 $STH = $DBH -> query("CALL propertySearch(34.939721, -81.983626, 100, 0, 1000, 3, 1, 1, 10, 0)"); // DESCRIPTION (lat, lng, distance (miles), rentMin, rentMax, beds, baths, available, limit, offset, return Total rows for pagination)
  
 $STH -> execute();
 $properties = $STH -> fetchAll();

 print_r($properties);

?>
</pre>