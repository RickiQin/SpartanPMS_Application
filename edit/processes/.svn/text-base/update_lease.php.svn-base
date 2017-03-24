<?php
require_once("../../inc/SiteBuilderClass.php");
require_once("../../inc/classes/User.php");
require_once("../../inc/classes/Property.php");
require_once("../../inc/classes/PropertyLease.php");

if(!isset($_POST)) {
    echo "An error occurred.";
     die();
} 
   
$user = new User();   
   
if(!($user -> isLoggedIn && $user -> department < 4)) { ?>
    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
<?php die(); 
} 


if(isset($_POST['lease_id'])) {
    $leaseID = $_POST['lease_id'];
    $lease = new PropertyLease($leaseID);
    // UPDATE EXISTING
    $lease -> update($_POST);
} else {
    // INSERT NEW
    $lease = new PropertyLease();
    $leaseID = $lease -> insert($_POST);
    
}

header("Location: /property_leases.php");
?> 

