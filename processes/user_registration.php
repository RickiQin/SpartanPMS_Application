<?php

require_once("../inc/all.inc");
require_once("../inc/classes/User.php");

$user = new User();

status($user -> validateAndCreate($_POST));

function status($bool) {
    if($bool) {
        // Account created, prompt the user to login
        echo "SUCCESS";
    } else {
        echo "FAILED";
    }
}

?>