<?php

require_once("inc/SiteBuilderClass.php");
require_once("inc/classes/User.php");
require_once("inc/classes/Property.php");

$template = new SiteBuilder();
$user = new User();

$template -> setCSS(array('css/propertyDetails.css','css/featuredListing.css'));
$template -> setJscript();

$template -> setPageTitle("Spartan PMS Homepage");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="contentWrapper">
                <h1>Featured Properties</h1>
                <ul class="featuredProperties">
                    <?php 
                    $fProperty = new FeaturedProperty();
                    $featuredProperties = $fProperty -> getAll();
                    
                    if(count($featuredProperties) == 0) {
                        echo '<li class="detailcon">';
                        echo '<center><h1>No Featured Properties at this time.</h1></center>';
                        echo '</li>';
                    } else {
                        foreach($featuredProperties as $property) { ?>
                        
                        <li class="detailcon">
                            <div class="detailpic">
                               <?php
                               echo $property -> getDefaultImage() -> getMedThumbnailHTML(); 
                               ?>
                            </div>
                            <div class="detailheader">
                                <h1><?php echo $property -> address; ?><br/>
                                    <?php echo $property -> city . ", " . $property -> state . " " . $property -> zip; ?>
                                </h1>
                                <div class="apply"><a href="property_details.php?property=<?php echo $property -> id; ?>"><img src="image/viewProperty_btn.png"></a>
                                            
                                    </div>
                                <h2><?php echo $property -> bedrooms; ?> <span> beds</span> <?php echo $property -> bathrooms; ?> <span> baths</span><p>$<?php echo $property -> rent; ?> </p><span>per month</span></h2>
                                
                                
                            </div>
                        </li>
                    <?php } 
                    } ?>
                </ul>
             </div>
            <div class="foot">
                <?php $template -> getNavigation(); ?>
            </div>
        </div>
    </body>
</html>
