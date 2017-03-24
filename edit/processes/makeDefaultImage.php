<?php
require_once("../../inc/SiteBuilderClass.php");
require_once("../../inc/classes/User.php");
require_once("../../inc/classes/Property.php");
require_once("../../inc/classes/PropertyImage.php");
require_once("../../inc/classes/PropertyDetails.php");
   
$user = new User();   
   
if(!($user -> isLoggedIn && $user -> department < 4)) { ?>
    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
<?php die(); 
} 


if(isset($_GET['property_id']) && isset($_GET['image_id'])) {
    $propertyID = $_GET['property_id'];
    $imageID = $_GET['image_id'];
    
    $image = new PropertyImage($imageID);
    $image -> makeDefault();
} else {
    echo "An error occurred.";
    die();
}


header("Location: /property_details.php?property=" . $propertyID);
?> 

