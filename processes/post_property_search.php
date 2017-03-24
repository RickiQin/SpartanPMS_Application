<?php
require_once("../inc/all.inc");
require_once("../inc/classes/Search.php");


if(isset($_POST['mainsearch'])) {
    if($_POST['mainsearch'] == Search::DEFAULT_ADDRESS || $_POST['mainsearch'] == "") {
        echo "FAILED";
        
    } else {
        $_SESSION['searchData'] = $_POST;
        echo "SUCCESS";
    }
    die();
}

if(isset($_POST['sortby'])) {
    $_SESSION['searchData']['sortby'] = $_POST['sortby'];
    echo "SUCCESS";
    die();
}



echo "FAILED";

?>