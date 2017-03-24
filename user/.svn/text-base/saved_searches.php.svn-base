<?php

require_once("../inc/SiteBuilderClass.php");
require_once("../inc/classes/User.php");

$template = new SiteBuilder();
$user = new User();

if(!($user -> isLoggedIn && $user -> department <= 5)) {
    header("Location: /login.php");    
} 

$template -> setCSS(array('css/savedItems.css'));
$template -> setJscript();

$template -> setPageTitle("Spartan PMS Saved Searches");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="contentWrapper">
                <div class="savedcontent">
                    <h1>Saved Searches</h1>
                    <div class="savedSearch">
                        <table cellspacing="0" cellpadding="0">
                            <tr>
                                <th>Search Name</th>
                                <th>Date Saved</th>
                                <th>&nbsp;</th>
                            </tr>
                            
                            <?php 
                            $savedSearches = $user -> getSavedSearches();
                            foreach($savedSearches as $savedSearch) { ?>
                            <tr>
                                <td><?php echo $savedSearch -> searchName; ?></td>
                                <td><?php echo $savedSearch -> lastUpdated; ?></td>
                                <td><a href="performSavedSearch.php?searchID=<?php echo $savedSearch -> save_id; ?>">Perform Search</a></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="foot">
                <?php $template -> getNavigation(); ?>
            </div>
        </div>
    </body>
</html>
