<?php

require_once("inc/SiteBuilderClass.php");
require_once("inc/classes/User.php");

$template = new SiteBuilder();
$user = new User();

$template -> setCSS(); // none needed for home page
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
            <div class="aboutWrapper">
                <h6 class="abtitle">About Us</h6>
                    <p align="justify">We are a stand-alone real estate management company. This is an intuitive, end-to-end, single data entry real estate management system. This will empower your real estate business growth through enhanced customer service, back office system management and increase staff productivity.</p>
                    <p align="justify">If you have any question, please contact us.</p>
                    <center><a href="contact_us.php"><img src="image/gocontact.png"/></a></center>
                            

            </div>
            <div class="foot">
                <?php $template -> getNavigation(); ?>
            </div>
        </div>
    </body>
</html>
