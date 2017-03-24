<?php

require_once("../inc/SiteBuilderClass.php");
require_once("../inc/classes/User.php");

$template = new SiteBuilder();
$user = new User();

if(!($user -> isLoggedIn && $user -> department <= 5)) {
    header("Location: /login.php");    
} 

$template -> setCSS(array('/css/searchResults.css','css/savedItems.css'));
$template -> setJscript();

$template -> setPageTitle("Spartan PMS Saved Properties");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="searchResultsWrapper">
                <div class="searchcontent">
                    <h1>Saved Properties</h1>
                    <div class="savedProperties">
                        <ul>
                       <?php
                       $properties = $user -> getSavedProperties(); 
                       
                        if(count($properties) == 0) { ?>
                            <li class="searchr">
                                <p class="noResultsFound">No properties match your search.</p>
                            </li>
                        <?php } else { 
                            $imgNumber = 0;
                            foreach($properties as $property) {
                               $imgNumber++;
                        ?>
                            <li class="searchr">
                                <table><tr>
                                    <td valign="top"><img class="marker" src="/image/mapMarkers/marker_<?php echo $imgNumber; ?>.png"></td>
                                    <td width="131px" align="center"><img src="<?php echo $property -> getDefaultImage() -> thumbnail; ?>"></td>
                                    <td class="srdescri">
                                        <ul>
                                        <li class="sradd"><a href="/property_details.php?property=<?php echo $property -> id; ?>"><?php echo $property -> address . "</br>" . $property -> city . ", " . $property -> state . " " . $property -> zip; ?></a></li>
                                        <li><?php echo $property -> details -> getShortDescription(); ?></li>
                                        </ul>
                                    </td>
                                    <td class="srright">
                                        <ul>
                                        <li class="srprice">$<?php echo round($property -> rent); ?>/mo</li>
                                        <li class="srnum"><?php echo $property -> bedrooms; ?> beds <?php echo $property -> bathrooms; ?> baths</li></ul>
                                    </td>
                                </tr></table>
                            </li>
                            
                        <?php } 
                        } ?>
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
