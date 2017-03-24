<?php

require_once("inc/SiteBuilderClass.php");
require_once("inc/classes/Property.php");
require_once("inc/classes/User.php");
require_once("inc/classes/PropertyLease.php");
require_once("inc/classes/LeaseSearch.php");

$user = new User();

$template = new SiteBuilder();

if(isset($_SESSION['leaseSearchData'])) {
    $search = new LeaseSearch($_SESSION['leaseSearchData']);
    $result = $search -> performSearch($_GET['page']);
    $leases = array();
    for($i=0; $i < count($result); $i++) {
        $leases[] = new PropertyLease($result[$i]['lease_id']);
    }
} else {
    $leases = PropertyLease::getAll();
}

$template -> setCSS(array('/css/searchResults.css','/css/propertyLeases.css','/css/redmond/jquery-ui-1.10.3.custom.min.css')); // none needed for home page
$template -> setJscript(array('js/leaseSearchForm.js'));

$template -> setPageTitle("Spartan PMS Property Leases");

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
                    <h1>Property Leases
                        <div class="adminadd"><a href="edit/lease.php"><img src="image/AddNewLeasecopy.png"></a>
                        </div>
                    </h1>
                    <p style="margin: 15px;">Click on the address to edit a lease.</p>
                    <div class="search">
                        <li class="searchr1">
                            <table>
                                <tr>
                                    <th class="sradd1">Address</th>
                                    <th class="srrenters">Client</th>
                                    <th class="sragent">Agent</th>
                                    <th class="srterm">Term</th>
                                    <th class="srprice1">Rent</th>
                                </tr>
                                <?php
                                if(count($leases) == 0) {
                                    echo '<tr>';
                                    echo '<td colspan="5" class="noResultsFound">No leases found.</td>';
                                    echo '</tr>';
                                }
                                
                                foreach($leases as $lease) { ?>     
                                <tr>
                                    <td valign="top" class="sradd1"><a href="edit/lease.php?lease=<?php echo $lease -> id; ?>"><?php echo $lease -> property -> address . "<br/>" . $lease -> property -> city . ", " . $lease -> property -> state . " " . $lease -> property -> zip; ?></a></td>
                                    <td valign="top" class="srrenters">
                                        <li><?php echo $lease -> user -> firstName . " " . $lease -> user -> lastName; ?></li>
                                    </td>
                                    <td valign="top" class="sragent">
                                        <li><?php echo $lease -> signedBy -> firstName . " " . $lease -> signedBy -> lastName; ?></li>
                                    </td>
                                    <td valign="top" class="srterm">
                                        <li><?php echo date("m/d/Y", strtotime($lease -> leaseStartDate)) . " - " . date("m/d/Y", strtotime($lease -> leaseEndDate)); ?></li>
                                    </td>
                                    <td valign="top" class="srprice1">
                                        <li>$<?php echo $lease -> rent; ?></li>
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
                    <form method="post" action="/processes/post_lease_search.php" name="lease_search">
                        <ul>
                            <li class="mainsearch">
                                <input type="text" tabindex="1" name="mainsearch" class="txt border_radius" value="<?php echo (isset($_SESSION['leaseSearchData']) ? $_SESSION['leaseSearchData']['mainsearch'] : LeaseSearch::DEFAULT_ADDRESS); ?>"/>
                            </li>
                            <li class="subsearch">
                                <label>Rent:</label>
                                <input type="text" tabindex="2" name="rentMin" class="txt border_radius" value="<?php echo (isset($_SESSION['leaseSearchData']) ? $_SESSION['leaseSearchData']['rentMin'] : LeaseSearch::DEFAULT_RENTMIN); ?>"/>
                                <label>to</label>
                                <input type="text" tabindex="3" name="rentMax" class="txt border_radius" value="<?php echo (isset($_SESSION['leaseSearchData']) ? $_SESSION['leaseSearchData']['rentMax'] : LeaseSearch::DEFAULT_RENTMAX); ?>"/>
                            </li>
                            <li class="submitsearch">
                                <input  tabindex="8" type="image" class="btn" src="image/RefineSearch.png"/>
                            </li>
                            <li class="submitsearch">
                                <a href="/processes/clear_lease_search.php" id="clearSearch">Clear Search</a>
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
