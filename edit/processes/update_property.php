<?php
require_once("../../inc/SiteBuilderClass.php");
require_once("../../inc/classes/User.php");
require_once("../../inc/classes/Property.php");
require_once("../../inc/classes/PropertyDetails.php");

if(!isset($_POST)) {
    echo "An error occurred.";
     die();
} 
   
$user = new User();   
   
if(!($user -> isLoggedIn && $user -> department < 4)) { ?>
    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
<?php die(); 
} 


if(isset($_POST['property_id'])) {
    $propertyID = $_POST['property_id'];
    $property = new Property($propertyID);
    // UPDATE EXISTING
    $property -> update($_POST);
    $property -> details -> update($_POST);
} else {
    // INSERT NEW
    $property = new Property();
    $propertyID = $property -> insert($_POST);
    $property = new Property($propertyID);
    $property -> details -> insert($_POST, $propertyID);
    
}

$property = new Property($propertyID);
$property -> updateGeocode();

header("Location: /property_details.php?property=" . $propertyID);
?> 

