<?php
require_once("../inc/SiteBuilderClass.php");
require_once("../inc/classes/User.php");
require_once("../inc/classes/Search.php");
require_once("../inc/classes/SavedSearch.php");
   
$user = new User();   
   
if(!($user -> isLoggedIn && $user -> department <= 5)) { ?>
    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
<?php die(); 
} 


if(isset($_GET['searchID'])) {
    $search = new SavedSearch($_GET['searchID']);
    if($search -> user_id != Authentication::getUserID()) {
        echo "You are not authorized to view this page.";
    } else {
        $_SESSION['searchData'] = array(
            "mainsearch" => $search -> lat . ", " . $search -> lng,
            "rentMin" => ($search -> rentMin == 0 ? "min" : $search -> rentMin),
            "rentMax" => ($search -> rentMax == 1000000 ? "max" : $search -> rentMax),
            "bedroomnum" => $search -> bedrooms,
            "bathroomnum" => $search -> bathrooms,
            "onlyavailable" => ($search -> available == 1 ? "on" : "")  
        );
        
    }   
} else {
    echo "An error occurred.";
    die();
}


header("Location: /property_search.php");
?> 

