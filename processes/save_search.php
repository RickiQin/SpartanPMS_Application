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


if(isset($_POST['searchName'])) {
    $search = new Search($_SESSION['searchData']);
    $search -> save($_POST['searchName']);   
} else {
    echo "An error occurred.";
    die();
}


header("Location: /property_search.php?searchSaved=" . true);
?> 

