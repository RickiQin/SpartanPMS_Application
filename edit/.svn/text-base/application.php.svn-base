<?php
require_once("../inc/SiteBuilderClass.php");
require_once("../inc/classes/User.php");
require_once("../inc/classes/PropertyApplication.php");
require_once("../inc/classes/Property.php");

$template = new SiteBuilder();
$user = new User();
$preload = false;
if(isset($_GET['application'])) {
    $application = new PropertyApplication($_GET['application']);
    $preload = true;
}

if(isset($_GET['property'])) {
    $applyingForProperty = new Property($_GET['property']);
}

$template -> setCSS(array("css/editProperty.css", "css/editLease.css")); // none needed for home page
$template -> setJscript(array("js/def.js"));

$template -> setPageTitle("Spartan PMS Edit Application");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="contentWrapper">
                <?php if(!($user -> isLoggedIn && $user -> department <= 5)) { ?>
                    <center>PLEASE LOGIN TO SUBMIT AN APPLICATION</center>
                <?php die(); 
                } ?> 
                
                <?php 
                
                // This checks that a client is only editing their own application, and makes sure the property is set to restrict permissions in the application editor. 
                if($user -> department == 5 && (($preload && !$user -> hasAppliedForProperty($application -> property -> id)) || !isset($_GET['property']))) { ?>
                    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
                <?php die(); 
                } ?> 
                <div class="searchForm1">
                    <h2><?php echo ($preload ? "Update Application" : "Create Application"); ?></h2>
                    <?php if($preload && $user -> isLoggedIn && $user -> department < 4) { ?>
                    <center><a href="lease.php?application=<?php echo $application -> id; ?>"><img src="/image/createLeaseFromApp.png" /></a></center>
                    <?php } ?>
                    <form method="post" name="application" action="processes/update_application.php">
                        <ul>
                            <li class="add">
                                <label>Property: </label>
                                
                                <?php if(isset($applyingForProperty)) { 
                                       echo $applyingForProperty -> address . ", " . $applyingForProperty -> city . ", " . $applyingForProperty -> state . " " . $applyingForProperty -> zip;  
                                       echo '<input type="hidden" name="property_id" value="' . $applyingForProperty -> id . '"/>';
                                } else { ?>
                                <select name="property_id" class="border_radius" tabindex="1">
                                    <?php 
                                    $properties = Property::getAll();

                                    foreach($properties as $property) {
                                        $selected = "";
                                        
                                        if($preload && $property -> id == $application -> property -> id) {
                                            $selected = 'selected="selected"';
                                        }
                                        
                                        echo '<option value="' . $property -> id . '"' . $selected . '>' . $property -> address . ", " . $property -> city . ", " . $property -> state . " " . $property -> zip . '</option>'; 
                                    }
                                    
                                    ?>
                                </select>
                                <?php } ?>
                            </li>
                            <li class="add1">
                                <label>First Name: </label>
                                <input type="text" class="border_radius txt" name="firstName" value="<?php echo ($preload ? $application -> firstName : ""); ?>"/>
                            </li>
                            <li class="add1">
                                <label>Last Name: </label>
                                <input type="text" class="border_radius txt" name="lastName" value="<?php echo ($preload ? $application -> lastName : ""); ?>"/>
                            </li>
                            <li class="add1">
                                <label>Email: </label>
                                <input type="text" class="border_radius txt" name="email" value="<?php echo ($preload ? $application -> email : ""); ?>"/>
                            </li>
                            <li class="add1">
                                <label>Phone: </label>
                                <input type="text" class="border_radius txt" name="phone" value="<?php echo ($preload ? $application -> phone : ""); ?>"/>
                            </li>
                            <li class="add1">
                                <label>Current Address: </label>
                                <input type="text" class="border_radius txt" name="c_address" value="<?php echo ($preload ? $application -> address : ""); ?>"/>
                            </li>
                            <li class="add1">
                                <label>Current City: </label>
                                <input type="text" class="border_radius txt" name="c_city" value="<?php echo ($preload ? $application -> city : ""); ?>"/>
                            </li>
                            <li class="add1">
                                <label>Current State: </label>
                                <input type="text" class="border_radius txt" name="c_state" value="<?php echo ($preload ? $application -> state : ""); ?>"/>
                            </li>
                            <li class="add1">
                                <label>Current Zip: </label>
                                <input type="text" class="border_radius txt" name="c_zip" value="<?php echo ($preload ? $application -> zip : ""); ?>"/>
                            </li>
                            
                            <li class="submitadd">
                                <?php if($preload) { ?>
                                    <input type="hidden" name="application_id" value="<?php echo $application -> id; ?>" />
                                <?php } ?>
                                <input type="hidden" name="user_id" value="<?php echo Authentication::getUserID(); ?>"/>
                                <input  tabindex="19" type="image" class="btn" src="/image/Submit.png"/>
                            </li>
                        </ul>
                    </form>
                </div>
             </div>
            <div class="foot">
                <?php $template -> getNavigation(); ?>
            </div>
        </div>
    </body>
</html>
