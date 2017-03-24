<?php
require_once("../inc/SiteBuilderClass.php");
require_once("../inc/classes/User.php");
require_once("../inc/classes/Property.php");
//require_once("../inc/classes/PropertyDetails.php");

$template = new SiteBuilder();
$user = new User();
$preload = false;
if(isset($_GET['property'])) {
    $property = new Property($_GET['property']);
    $preload = true;
}

$template -> setCSS(array("css/editProperty.css")); // none needed for home page
$template -> setJscript(array("js/def.js"));

$template -> setPageTitle("Spartan PMS Edit Property");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="contentWrapper1">
                <?php if(!($user -> isLoggedIn && $user -> department < 4)) { ?>
                    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
                <?php die(); 
                } ?> 
                <div class="searchForm1">
                    <h2>Add a new property</h2>
                    <form method="post" action="processes/update_property.php" name="property">
                        <ul>
                            <li class="add">
                                <label>Type:</label>
                                <select name="type" class="border_radius" tabindex="1">
                                    <option value="1">Single Family House</option>
                                    <option value="2">Duplex</option>
                                    <option value="3">Apartment</option>
                                </select>
                            </li>
                            <li class="add1">
                                <label>Address: </label>
                                <input type="text" tabindex="2" name="address" class="txt border_radius" value="<?php echo ($preload ? $property -> address : ""); ?>"/>
                            </li>
                            <li class="add2">
                                <label>City: </label>
                                <input type="text" tabindex="3" name="city" class="txt border_radius" value="<?php echo ($preload ? $property -> city : ""); ?>"/>
                                <label>State: </label>
                                <input type="text" tabindex="4" name="state" class="txt border_radius" value="<?php echo ($preload ? $property -> state : ""); ?>"/>
                                <label>Zip Code: </label>
                                <input type="text" tabindex="5" name="zip" class="txt border_radius" value="<?php echo ($preload ? $property -> zip : ""); ?>"/>
                            </li>
                            <li class="add2">
                                <label># of Bedrooms</label>
                                <select name="bedrooms" class="border_radius" tabindex="6" >
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="3+">3+</option>
                                </select>
                                <label># of Bathrooms</label>
                                <select name="bathrooms" class="border_radius" tabindex="7" >
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="2+">2+</option>
                                </select>
                            </li>
                            <li class="add1">
                                <label>Rent: </label>
                                <input type="text" tabindex="8" name="rent" class="txt border_radius" value="<?php echo ($preload ? $property -> rent : ""); ?>"/>
                            </li>
                            <li class="add2">
                                <label>Available:</label>
                                <select name="available" class="border_radius" tabindex="9" >
                                    <option value="1">YES</option>
                                    <option value="2">NO</option>
                                </select>
                                <label>Allow Pet:</label>
                                <select name="pet_allow" class="border_radius" tabindex="10" >
                                    <option value="1">YES</option>
                                    <option value="2">NO</option>
                                </select>
                            </li>
                            <li class="add1">
                                <label>Square Foot:</label>
                                <input type="text" tabindex="11" name="square_foot" class="txt border_radius" value="<?php echo ($preload ? $property -> details -> square_foot : ""); ?>"/>
                            </li>
                            <li class="add2">
                                <label>Laundry:</label>
                                <select name="laundry" class="border_radius" tabindex="12" >
                                    <option value="Washer">Washer</option>
                                    <option value="Dryer">Dryer</option>
                                    <option value="Washer/Dryper">Washer/Dryer</option>
                                    <option value="Hookups">Hookups</option>
                                    <option value="None">None</option>
                                </select>
                                <label>Garage:</label>
                                <select name="garage" class="border_radius" tabindex="13" >
                                    <option value="1">YES</option>
                                    <option value="2">NO</option>
                                </select>
                            </li>
                            <li class="add2">
                                <label>Heating / Air:</label>
                                <select name="heating_air" class="border_radius" tabindex="14">
                                    <option value="1">YES</option>
                                    <option value="2">NO</option>
                                </select>
                            </li>
                            <li class="add2">
                                <label>School District:</label>
                                <input type="text" tabindex="15" name="school_district" class="txt border_radius" value="<?php echo ($preload ? $property -> details -> school_district : ""); ?>"/>
                                <label>Stories:</label>
                                <input type="text" tabindex="16" name="stories" class="txt border_radius" value="<?php echo ($preload ? $property -> details -> stories : ""); ?>"/>     
                            </li>
                            <li class="add1">
                                <label>Utilities Included:</label>
                                <input type="text" tabindex="17" name="utility_include" class="txt border_radius" value="<?php echo ($preload ? $property -> details -> utility_include : ""); ?>"/>
                            </li>
                            <li class="add1">
                                <label>Description:</label>
                                <p><textarea tabindex="18" name="description" class="border_radius" cols='80' rows='10'><?php echo ($preload ? $property -> details -> description : ""); ?></textarea></p>
                            </li>
                            <li class="submitadd">
                                <?php if($preload) { ?>
                                    <input type="hidden" name="property_id" value="<?php echo $property -> id; ?>" />
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
