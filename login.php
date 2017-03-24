<?php

require_once("inc/SiteBuilderClass.php");

$template = new SiteBuilder();


$template -> setCSS(array("/css/registration.css"));
$template -> setJscript(array("/js/registration.js"));

$template -> setPageTitle("Login to your Spartan PMS Account");

echo $template -> getHttpHeader();

?>

    <body>
        <div class="main style1">
            <?php $template -> getPageHeader(); ?>
            <div class="navi1">
                <?php $template -> getNavigation(); ?>
            </div>
            <div class="contentWrapper">
                <div class="searchForm">
                    <h5>Please Login</h5>
                    <form method="post" action="/processes/user_login.php" name="login">
                        <ul>
                            <li class="typeuser">
                                <span>Email: </span><input type="text" tabindex="1" name="email" class="border_radius" value="Email Address"/>
                            </li>
                            <li class="typepw">
                                <span>Password: </span><input type="password" tabindex="2" name="password" class="border_radius" autocomplete="off"/>
                            </li>

                            <li class="submitlogin">
                                <input tabindex="3" type="image" src="image/LoginButton.png"/>
                            </li>
                        </ul>
                    </form>
                </div>
                <div class='picshow'>
                    <img src="image/showingarea.jpg">
                </div>
             </div>
            <div class="foot">
                <?php $template -> getNavigation(); ?>
            </div>
        </div>
    </body>
</html>