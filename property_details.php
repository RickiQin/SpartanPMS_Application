<?php
require_once("inc/SiteBuilderClass.php");
require_once("inc/classes/Property.php");
require_once("inc/classes/User.php");
require_once("inc/classes/PropertyDetails.php");
require_once("inc/classes/SavedProperty.php");
require_once("inc/classes/FeaturedProperty.php");

if(!isset($_GET['property'])) {
    header("Location: /");
    die();
} 

$user = new User();
$property = new Property($_GET['property']);

$template = new SiteBuilder();


$template -> setCSS(array('/css/propertyDetails.css')); // none needed for home page
$template -> setJscript(array(
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyDCt8VnFBFrA4T5c1tQU0Mc3TVjMBbn4Y0&sensor=false',
        '/js/googleMaps/propertyDetails.php?property=' . $property -> id
    ));

$template -> setPageTitle("Spartan PMS Property Details");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="contentWrapper">
                <div class="detailcon">
                    <div class="detailpic">
                       <?php
                       echo $property -> getDefaultImage() -> getMedThumbnailHTML(); 
                       ?>
                    </div>
                    <div class="detailheader">
                        <h1><?php echo $property -> address; ?><br/>
                            <?php echo $property -> city . ", " . $property -> state . " " . $property -> zip; ?>
                        </h1>
                            <?php if($user -> isLoggedIn && $user -> department < 4) { ?>
                                
                                <div class="apply"><a href="edit/property.php?property=<?php echo $property-> id; ?>"><img src="image/editPropertyBtn.png"></a>         
                                  <?php  echo "<br/>";
                                        $featuredProperty = new FeaturedProperty($property -> id);
                                        if($featuredProperty -> id > 0) {
                                            // This property is saved by the user
                                            echo '<a href="/processes/remove_featured_property.php?propertyID=' . $property -> id . '"/><img src="/image/removeFeaturedListing.png" /></a>';
                                        } else {
                                            echo '<a href="/processes/add_featured_property.php?propertyID=' . $property -> id . '"/><img src="/image/addFeaturedListing.png" /></a>';
                                        }    
                                    
                                 } else { 
                                     if($user -> hasAppliedForProperty($property -> id)) { ?>
                                        <div class="apply"><a href="edit/application.php?application=<?php echo $user -> hasAppliedForProperty($property -> id) ?>&property=<?php echo $property -> id; ?>"><img src="image/EditApplicationBtn.png"></a>
                                    <?php } else { ?>
                                        <div class="apply"><a href="edit/application.php?property=<?php echo $property -> id; ?>"><img src="image/ApplyNowBtn.png"></a>
                                        
                                    <?php }
                                     if($user -> isLoggedIn && $user -> department >= 4) { 
                                        $savedProperty = new SavedProperty($property -> id);
                                        echo "<br/>";
                                        if($savedProperty -> id > 0) {
                                            // This property is saved by the user
                                            echo '<a href="/processes/unsave_property.php?propertyID=' . $property -> id . '"/><img src="/image/unSaveProperty.png" /></a>';
                                        } else {
                                            echo '<a href="/processes/save_property.php?propertyID=' . $property -> id . '"/><img src="/image/saveProperty.png" /></a>';
                                        }
                                       
                                      } // end if userIsLoggedIn and department  >=4
                                }  // end "" < 4 ?>
                            </div>
                        <h2><?php echo $property -> bedrooms; ?> <span> beds</span> <?php echo $property -> bathrooms; ?> <span> baths</span><p>$<?php echo $property -> rent; ?> </p><span>per month</span></h2>
                        <div class="sectionHeader"><h3>Property Details</h3></div>
                        <table class="detailtb">
                            <tr>
                                <td>Available: <?php echo ($property -> available ? "Yes" : "No"); ?></td>
                                <td>Garage: <?php echo $property -> details -> garage; ?></td>
                            </tr>
                            <tr>
                                <td>Deposit: $<?php echo $property -> rent; ?></td>
                                <td>School District: <?php echo $property -> details -> school_district; ?></td>
                            </tr><tr>
                                <td>Pets Allowed: <?php echo $property -> details -> pet_allow; ?></td>
                                <td>Stories: <?php echo $property -> details -> stories; ?></td>
                            </tr><tr>
                                <td>Square Footage: <?php echo $property -> details -> square_foot; ?></td>
                                <td>Utilities Included: <?php echo $property -> details -> utility_include; ?></td>
                            </tr><tr>
                                <td>Laundry: <?php echo $property -> details -> laundry; ?></td>
                            </tr><tr>
                                <td>Heating / Air: <?php echo $property -> details -> heating_air; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="descript">
                        <div class="sectionHeader"><h2>Description</h2></div>
                            <h3><?php echo $property -> details -> description; ?></h3>
                    </div>
                    <div class="locat">
                        <div class="sectionHeader"><h2>Location</h2></div>
                        <div id="map-canvas"></div>
                    </div>
                    <div class="locat">
                        <div class="sectionHeader"><h2>Photos of Property 
                            <?php
                            if($user -> isLoggedIn && $user -> department < 4) { ?> 
                            
                            <a href="edit/addPhotos.php?property=<?php echo $property -> id; ?>"><img src="/image/AddNewImage.png"/></a>
                            <?php } ?>
                            </h2></div>
                        <ul class="thumbpic">
                        <?php 
                        $thumbnails = $property -> getThumbnails();
                        foreach($thumbnails as $thumbnail) {
                            if($user -> isLoggedIn && $user -> department < 4) { 
                                echo '<li class="admin">' . $thumbnail -> getThumbnailHTML()  . '
                                <p><a href="/edit/processes/makeDefaultImage.php?property_id=' . $property -> id . '&image_id=' . $thumbnail -> image_id . '">Make Default</a> - 
                                <a href="/edit/processes/deleteImage.php?property_id=' . $property -> id . '&image_id=' . $thumbnail -> image_id . '">Delete Image</a></p>
                                </li>';
                            } else {
                                echo '<li>' . $thumbnail -> getThumbnailHTML()  . '</li>';
                            }
                        }
                        ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="foot">
                <?php $template -> getNavigation(); ?>
            </div>
        </div>
    </body>
</html>
