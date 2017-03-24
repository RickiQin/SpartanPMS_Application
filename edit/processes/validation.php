<?php
require_once("../../inc/classes/DataValidation.php");
require_once("../../inc/classes/Property.php");
require_once("../../inc/classes/PropertyApplication.php");
require_once("../../inc/classes/PropertyLease.php");

switch($_GET['form']) {
    case "application":
        if(PropertyApplication::validate($_POST)) {
            success();
        }
    break;
    case "lease":
        if(PropertyLease::validate($_POST)) {
            success();
        }
    break;
    case "property":
        if(Property::validate($_POST)) {
            success();
        }
    break;
}

fail();

function success() {
    echo json_encode(array("status" => true));
    die();
} 

function fail() {
    echo json_encode(array("status" => false));
    die();
} 



?>