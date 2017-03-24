<?php
require_once("../inc/SiteBuilderClass.php");
require_once("../inc/classes/User.php");
require_once("../inc/classes/Property.php");
require_once("../inc/classes/PropertyDetails.php");

$template = new SiteBuilder();
$user = new User();
$preload = false;
if(isset($_GET['property'])) {
    $property = new Property($_GET['property']);
    $preload = true;
} else {
    echo "AN ERROR OCCURRED.";
    die();
}

$template -> setCSS(array("css/editProperty.css")); // none needed for home page
$template -> setJscript();

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
                    <h2>Add Photos</h2>
                    <p><?php echo $property -> address . "<br/>" . $property -> city . ", " . $property -> state . " " . $property -> zip; ?></p>
                    <form action="processes/uploadPhotos.php" method="post" enctype="multipart/form-data">
                      <br />
                      <input name="propertyimage[]" type="file" /><br />
                      <input name="propertyimage[]" type="file" /><br />
                      <input name="propertyimage[]" type="file" /><br />
                      <input name="propertyimage[]" type="file" /><br />
                      <input name="propertyimage[]" type="file" /><br />
                      <input type="hidden" name="property_id" value="<?php echo $property -> id; ?>" />
                      <input type="submit" value="Upload Images" />
                    </form>
                </div>
             </div>
            <div class="foot">
                <?php $template -> getNavigation(); ?>
            </div>
        </div>
    </body>
</html>
