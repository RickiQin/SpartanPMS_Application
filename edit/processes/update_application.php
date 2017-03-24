<?php
require_once("../../inc/SiteBuilderClass.php");
require_once("../../inc/classes/User.php");
require_once("../../inc/classes/Property.php");
require_once("../../inc/classes/PropertyApplication.php");

if(!isset($_POST)) {
    echo "An error occurred.";
     die();
} 
   
$user = new User();   
   
if(!($user -> isLoggedIn && $user -> department <= 5)) { ?>
    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
<?php die(); 
} 

if(isset($_POST['application_id'])) {
    if($user -> department == 5 && !$user -> hasAppliedForProperty($_POST['property_id'])) {
        ?>
    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
<?php die(); 
    }
    
    $applicationID = $_POST['application_id'];
    $application = new PropertyApplication($applicationID);
    // UPDATE EXISTING
    $application -> update($_POST);
} else {
    // INSERT NEW
    $application = new PropertyApplication();
    $applicationID = $application -> insert($_POST);
    
}
if($user -> department == 5) {
    header("Location: /property_details.php?property=" . $_POST['property_id']);   
} else {
    header("Location: /property_applications.php");
}
?> 

