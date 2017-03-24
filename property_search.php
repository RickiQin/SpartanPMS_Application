<?php
require_once("inc/SiteBuilderClass.php");
require_once("inc/classes/Search.php");
require_once("inc/classes/User.php");
require_once("inc/classes/PropertyDetails.php");

$user = new User();
// SEARCH IS STORED IN SESSION['searchData']
$search = new Search($_SESSION['searchData']);
$result = $search -> performSearch($_GET['page']);
$template = new SiteBuilder();

$template -> setCSS(array('/css/searchResults.css'));
$template -> setJscript(array(
        'https://maps.googleapis.com/maps/api/js?key=AIzaSyDCt8VnFBFrA4T5c1tQU0Mc3TVjMBbn4Y0&sensor=false',
        '/js/googleMaps/propertySearch.php'
    ));

$template -> setPageTitle("Spartan PMS Homepage");

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
                    <h1>Search Results 
                        <?php 
                        if($user -> isLoggedIn) {
                        
                        if($user -> isLoggedIn && $user -> department < 4) { ?>
                            <div class="adminadd">
                                <a href="edit/property.php"><img src="image/AddNewPropertycopy.png" ></a>
                            </div>
                        <?php } else { ?>
                            <div class="adminadd">
                                <a href="processes/save_search.php" id="saveSearch"><img src="image/saveSearch.png"/></a>
                            </div>
                        <?php } 
                        }
                        ?>
                    </h1>
                    <div class="search">
                        <form method="post" action="/processes/post_property_search.php" name="searchSorter" class="searchs"><h2>Sort By:
                            <select name="sortby" class="border_radius">
                                <option value="dist_asc" <?php echo ($_SESSION['searchData']['sortby'] == "dist_asc" ? 'selected="selected"' : ""); ?>>Distance</option>
                                <option value="price_asc" <?php echo ($_SESSION['searchData']['sortby'] == "price_asc" ? 'selected="selected"' : ""); ?>>Price Low to High</option>
                                <option value="price_desc" <?php echo ($_SESSION['searchData']['sortby'] == "price_desc" ? 'selected="selected"' : ""); ?>>Price High to Low</option>
                            </select></h2>
                        </form>
                        <ul>
                        <?php
                        if(count($result['properties']) == 0) { ?>
                            <li class="searchr">
                                <p class="noResultsFound">No properties match your search.</p>
                            </li>
                        <?php } else { 
                            $imgNumber = 0;
                            foreach($result['properties'] as $propertyResult) {
                               $property = new Property($propertyResult['property_id']); 
                               $imgNumber++;
                        ?>
                            <li class="searchr">
                                <table><tr>
                                    <td valign="top"><img class="marker" src="image/mapMarkers/marker_<?php echo $imgNumber; ?>.png"></td>
                                    <td width="131px" align="center"><img src="<?php echo $property -> getDefaultImage() -> thumbnail; ?>"></td>
                                    <td class="srdescri">
                                        <ul>
                                        <li class="sradd"><a href="property_details.php?property=<?php echo $property -> id; ?>"><?php echo $property -> address . "</br>" . $property -> city . ", " . $property -> state . " " . $property -> zip; ?></a></li>
                                        <li><?php echo $property -> details -> getShortDescription(); ?></li>
                                        </ul>
                                    </td>
                                    <td class="srright">
                                        <ul>
                                        <li class="srprice">$<?php echo round($property -> rent); ?>/mo</li>
                                        <li class="srnum"><?php echo $property -> bedrooms; ?> beds <?php echo $property -> bathrooms; ?> baths</li><li class="distance"><?php echo $search -> distanceToString($propertyResult['distance']); ?> miles</li></ul>
                                    </td>
                                </tr></table>
                            </li>
                            
                        <?php } 
                        } ?>
                        </ul>
                        <div class="pagination">
                            <?php 
                            if($search -> getTotalResultsForSearch() > 0) { 
                                echo $search -> getPagination($_GET['page']); 
                            }    
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rightSideWrapper">
                <?php $template -> getSearchForm(1); ?>
                <div class="mapContainer">
                    <div id="map-canvas"></div>
                </div>
             </div>
            <div class="foot">
                <?php $template -> getNavigation(); ?>
            </div>
        </div>
    </body>
</html>