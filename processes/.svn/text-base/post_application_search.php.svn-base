<?php
require_once("../inc/all.inc");
require_once("../inc/classes/Search.php");


if(isset($_POST['mainsearch'])) {
    if($_POST['mainsearch'] == Search::DEFAULT_ADDRESS || $_POST['mainsearch'] == "") {
        echo "FAILED";
        
    } else {
        $_SESSION['applicationSearchData'] = $_POST;
        echo "SUCCESS";
    }
    die();
}

echo "FAILED";

?>