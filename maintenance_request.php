<?php

require_once("inc/SiteBuilderClass.php");
require_once("inc/classes/User.php");
require_once("inc/classes/Property.php");
require_once("inc/classes/PropertyLease.php");


$template = new SiteBuilder();
$user = new User();

if($_GET['messageReceived']) {
    $to = "danielc111@gmail.com";
    $subject = "MAINTENANCE REQUEST: " . $_POST['subject'];
    $message = $_POST['prodetail'] . "\n\n";
    
    if($user -> isLoggedIn) {
        $message .= "User Name: " . $user -> firstName . " " . $user -> lastName . "\n";
        $message .= "Email: " . $user -> emailAddress . "\n"; 
        $message .= "Phone: " . $user -> phone . "\n\n";
    }
    
    if(isset($_POST['property_id'])) {
        $property = new Property($_POST['property_id']);
        $message .= "Property Address: " .  $property -> address . ", " . $property -> city . ", " . $property -> state . " " . $property -> zip;
    }
    
    
    $from = $_POST['email'];
    $headers = "From:" . $from;
    mail($to,$subject,$message,$headers);
}


$template -> setCSS(); 
$template -> setJscript();

$template -> setPageTitle("Maintenance Request Spartan PMS");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="contentWrapper">
               <div class="searchForm">
                    <h1>Submit Maintenance Request</h6>
                    <?php if(isset($_GET['messageReceived'])) { ?>
                        <p class="contact">Your maintenance request has been received. A representative will be in contact with you shortly.</p>
                        
                    <?php } else { ?>
                    <form method="post" action="maintenance_request.php?messageReceived=1" name="register">
                        <ul>
                            <li class="typename">
                                <span>Property: </span>
                                <select name="property_id">
                                    <?php 
                                    $leaseResults = $user -> getPropertyLeases();
                                    foreach($leaseResults as $leaseResult) {
                                        $leaseID = $leaseResult['lease_id'];
                                        $lease = new PropertyLease($leaseID);
                                        $property = $lease -> property;
                                                                       
                                        echo '<option value="' . $property -> id . '">' . $property -> address . ", " . $property -> city . ", " . $property -> state . " " . $property -> zip . "</option>";
                                    }
                                    ?>
                                </select>
                            </li>
                            <li class="typename">
                                <span>Subject: </span><input type="text" tabindex="2" name="subject" class="border_radius" value=""/>
                            </li>
                            <li class="typename">
                                <?php if($user -> isLoggedIn) { ?>
                                <span>Your Email: </span><input type="text" tabindex="2" name="email" class="border_radius" value="<?php echo $user -> emailAddress; ?>" readonly="readonly"/>    
                                <?php } else { ?>
                                <span>Your Email: </span><input type="text" tabindex="2" name="email" class="border_radius" value=""/>
                                <?php } ?>
                            </li>
                            <li class="pbdetail">
                                <span>Message:</span>
                                <p><textarea tabindex="3" name="prodetail" class="border_radius" cols='40' rows='8'></textarea></p>
                            </li>                           
                            <li class="submitregi">
                                <input tabindex="4" type="image" src="image/Submit.png"/>
                            </li>
                        </ul>
                    </form>
                    <?php } ?>
                </div>
                <div class='picshow'>
                    <img src="image/showingarea.jpg">
                </div>
             </div>
            <div class="foot">
                <?php $template -> getNavigation(); ?>
            </div>
        </div>
    </body>
</html>
