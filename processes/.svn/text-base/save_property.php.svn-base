<?php
require_once("../inc/SiteBuilderClass.php");
require_once("../inc/classes/User.php");
require_once("../inc/classes/Property.php");
require_once("../inc/classes/SavedProperty.php");
   
$user = new User();   
   
if(!($user -> isLoggedIn && $user -> department <= 5)) { ?>
    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
<?php die(); 
} 


if(isset($_GET['propertyID'])) {
    $property = new Property($_GET['propertyID']);
    $property -> save();   
} else {
    echo "An error occurred.";
    die();
}


header("Location: /property_details.php?property=" . $_GET['propertyID']);
?> 

