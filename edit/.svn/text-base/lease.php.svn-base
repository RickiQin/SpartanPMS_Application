<?php
require_once("../inc/SiteBuilderClass.php");
require_once("../inc/classes/User.php");
require_once("../inc/classes/PropertyLease.php");
require_once("../inc/classes/Property.php");
require_once("../inc/classes/PropertyApplication.php");

$template = new SiteBuilder();
$user = new User();
$preload = false;
if(isset($_GET['lease'])) {
    $lease = new PropertyLease($_GET['lease']);
    $preload = true;
}

if(isset($_GET['application'])) {
    // Prefill user and property
    $application = new PropertyApplication($_GET['application']);
}

$template -> setCSS(array("css/editProperty.css", "css/editLease.css",'/css/redmond/jquery-ui-1.10.3.custom.min.css')); // none needed for home page
$template -> setJscript(array("js/def.js","/js/jquery-ui-1.10.3.custom.min.js","js/editLease.js"));

$template -> setPageTitle("Spartan PMS Edit Lease");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="contentWrapper">
                <?php if(!($user -> isLoggedIn && $user -> department < 4)) { ?>
                    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
                <?php die(); 
                } ?> 
                <div class="searchForm1">
                    <h2><?php echo ($preload ? "Update Lease" : "Create Lease"); ?></h2>
                    <form method="post" action="processes/update_lease.php" name="lease">
                        <ul>
                            <li class="add">
                                <label>Property: </label>
                                <select name="property_id" class="border_radius" tabindex="1">
                                    <?php 
                                    $properties = Property::getAll();

                                    foreach($properties as $property) {
                                        $selected = "";
                                        if(is_object($application) && $property -> id == $application -> property -> id) {
                                            $selected = 'selected="selected"';
                                        }
                                        
                                        if($preload && $property -> id == $lease -> property -> id) {
                                            $selected = 'selected="selected"';
                                        }
                                        
                                        echo '<option value="' . $property -> id . '"' . $selected . '>' . $property -> address . ", " . $property -> city . ", " . $property -> state . " " . $property -> zip . '</option>'; 
                                    }
                                    
                                    ?>
                                </select>
                            </li>
                            <li class="add">
                                <label>Client: </label>
                                <select name="user_id" class="border_radius" tabindex="1">
                                    <?php
                                    $clients = User::getUsersByDepartment(5);
                                    
                                    foreach($clients as $client) {
                                        $selected = "";
                                        if((is_object($application) && $client -> id == $application -> user -> id)) {
                                            $selected = 'selected="selected"';
                                        }
                                        
                                        if($preload && $client -> id == $lease -> user -> id) {
                                            $selected = 'selected="selected"';
                                        }
                                        
                                        
                                        echo '<option value="' . $client -> id . '"' . $selected . '>' . $client -> lastName . ", " . $client -> firstName . " (" . $client -> emailAddress . ')</option>'; 
                                    }
                                    ?>
                                </select>
                            </li>
                            <li class="add">
                                <label>Agent: </label>
                                <select name="signed_by_agent" class="border_radius" tabindex="1">
                                    <?php
                                    $agents = User::getUsersByDepartment(1,4);
                                    
                                    foreach($agents as $agent) {
                                        $selected = '';
                                        if($preload && $agent -> id == $lease -> signedBy -> id) {
                                            $selected = 'selected="selected"';
                                        }
                                        
                                        echo '<option value="' . $agent -> id . '"' . $selected . '>' . $agent -> lastName . ", " . $agent -> firstName . " (" . $agent -> emailAddress . ')</option>'; 
                                    }
                                    ?>
                                </select>
                            </li>
                            <li class="add1">
                                <label>Term: </label>
                                <input type="text" class="border_radius date txt" name="lease_start_date" value="<?php echo ($preload ? date("m/d/Y", strtotime($lease -> leaseStartDate)) : ""); ?>"/> to 
                                <input type="text" class="border_radius date txt" name="lease_end_date" value="<?php echo ($preload ? date("m/d/Y", strtotime($lease -> leaseEndDate)) : ""); ?>"/>
                            </li>
                            <li class="add1">
                                <label>Rent: </label>
                                <input type="text" class="border_radius txt" name="rent" value="<?php echo ($preload ? $lease -> rent : ""); ?>" />
                            </li>
                            <li class="submitadd">
                                <?php if($preload) { ?>
                                    <input type="hidden" name="lease_id" value="<?php echo $lease -> id; ?>" />
                                <?php } ?>
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
