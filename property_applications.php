<?php

require_once("inc/SiteBuilderClass.php");
require_once("inc/classes/Property.php");
require_once("inc/classes/User.php");
require_once("inc/classes/PropertyApplication.php");
require_once("inc/classes/ApplicationSearch.php");

$user = new User();

$template = new SiteBuilder();

if(isset($_SESSION['applicationSearchData'])) {
    $search = new ApplicationSearch($_SESSION['applicationSearchData']);
    $result = $search -> performSearch($_GET['page']);
    $applications = array();
    for($i=0; $i < count($result); $i++) {
        $applications[] = new PropertyApplication($result[$i]['application_id']);
    }
} else {
    $applications = PropertyApplication::getAll();
}

$template -> setCSS(array('/css/searchResults.css','/css/propertyApplications.css','/css/redmond/jquery-ui-1.10.3.custom.min.css')); // none needed for home page
$template -> setJscript(array('js/applicationSearchForm.js'));

$template -> setPageTitle("Spartan PMS Property Applications");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="searchResultsWrapper">
                <?php if(!($user -> isLoggedIn && $user -> department < 4)) { ?>
                    <center>YOU ARE NOT AUTHORIZED TO VIEW THIS PAGE</center>
                <?php die(); 
                } ?>
                <div class="searchcontent">
                    <h1>Property Applications
                        <div class="adminadd"><a href="edit/application.php"><img src="image/AddNewApplicationcopy.png"></a>
                        </div>
                    </h1>
                    <p style="margin: 15px;">Click on the address to edit an application.</p>
                    <div class="search">
                        <li class="searchr1">
                            <table>
                                <tr>
                                    <th class="sradd1">Property Address</th>
                                    <th class="srrenters">Applicant</th>
                                    <th class="sraddress">Applicant Address</th>
                                    <th class="srent">Rent</th>
                                    <th class="srdate">Date</th>
                                </tr>
                                <?php
                                if(count($applications) == 0) {
                                    echo '<tr>';
                                    echo '<td colspan="5" class="noResultsFound">No applications found.</td>';
                                    echo '</tr>';
                                }
                                
                                foreach($applications as $application) { ?>     
                                <tr>
                                    <td class="sradd1"><a href="edit/application.php?application=<?php echo $application -> id; ?>"><?php echo $application -> property -> address . "<br/>" . $application -> property -> city . ", " . $application -> property -> state . " " . $application -> property -> zip; ?></a></td>
                                    <td class="srrenters">
                                        <li><?php echo $application -> user -> firstName . " " . $application -> user -> lastName; ?></li>
                                    </td>
                                    <td class="sraddress">
                                        <li><?php echo $application -> address . "<br/>" . $application -> city . ", " . $application -> state . " " . $application -> zip; ?></li>
                                    </td>
                                    <td class="srent">
                                        <li><?php echo $application -> property -> rent; ?></li>
                                    </td>
                                    <td class="srdate">
                                        <li><?php echo date("m/d/Y", strtotime($application -> lastUpdated)); ?></li>
                                    </td>
                                </tr>
                                <?php } ?>
                            </table>
                        </li>
                    </div>
                </div>
           </div>
           <div class="rightSideWrapper">
                <div class="searchForm1 searchForm">
                    <h2>Refine Your Search</h2>
                    <form method="post" action="/processes/post_application_search.php" name="application_search">
                        <ul>
                            <li class="mainsearch">
                                <input type="text" tabindex="1" name="mainsearch" class="txt border_radius" value="<?php echo (isset($_SESSION['applicationSearchData']) ? $_SESSION['applicationSearchData']['mainsearch'] : ApplicationSearch::DEFAULT_ADDRESS); ?>"/>
                            </li>
                            <li class="subsearch">
                                <label>Rent:</label>
                                <input type="text" tabindex="2" name="rentMin" class="txt border_radius" value="<?php echo (isset($_SESSION['applicationSearchData']) ? $_SESSION['applicationSearchData']['rentMin'] : ApplicationSearch::DEFAULT_RENTMIN); ?>"/>
                                <label>to</label>
                                <input type="text" tabindex="3" name="rentMax" class="txt border_radius" value="<?php echo (isset($_SESSION['applicationSearchData']) ? $_SESSION['applicationSearchData']['rentMax'] : ApplicationSearch::DEFAULT_RENTMAX); ?>"/>
                            </li>
                            <li class="submitsearch">
                                <input  tabindex="8" type="image" class="btn" src="image/RefineSearch.png"/>
                            </li>
                            <li class="submitsearch">
                                <a href="/processes/clear_application_search.php" id="clearSearch">Clear Search</a>
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
