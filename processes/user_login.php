<?php

require_once("../inc/all.inc");
require_once("../inc/classes/User.php");
$user = new User();
if(isset($_POST['email']) && isset($_POST['password'])) {
    status($user -> login($_POST['email'], $_POST['password']));
} else {
    status(false);
}

function status($bool) {
    if($bool) {
        // Account created, prompt the user to login
        echo "SUCCESS";
    } else {
        echo "FAILED";
    }
}

?>