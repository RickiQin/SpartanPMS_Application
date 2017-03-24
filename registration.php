<?php

require_once("inc/SiteBuilderClass.php");
require_once("inc/classes/User.php");

$template = new SiteBuilder();

$user = new User();

$template -> setCSS(array("/css/registration.css"));
$template -> setJscript(array("/js/registration.js"));

$template -> setPageTitle("Create a Spartan PMS Acount");

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
                    <h6>Please Register</h6>
                    <form method="post" action="processes/user_registration.php" name="register">
                        <ul>
                            <li class="typename">
                                <span>First Name: </span><input type="text" tabindex="1" name="firstname" class="border_radius" value="First Name"/>
                            </li>
                            <li class="typename">
                                <span>Last Name: </span><input type="text" tabindex="2" name="lastname" class="border_radius" value="Last Name"/>
                            </li>
                            <li class="typename">
                                <span>Email Addr: </span><input type="text" tabindex="3" name="email" class="border_radius" value="Email Address"/>
                            </li>

                            <li class="typename">
                                <span>Password: </span><input type="password" tabindex="4" name="password" class="border_radius"/>
                            </li>
                            <li class="typename">
                                <span>Confirm Password: </span><input type="password" tabindex="5" name="passwordconf" class="border_radius"/>
                            </li>
                            <?php if($user -> isLoggedIn && $user -> department == 1) { ?>
                            <li class="typename">
                                <span>Department: </span>
                                <select name="department_id" class="border_radius">
                                    <option value="1">Super Admin</option>
                                    <option value="2">Administrator</option>
                                    <option value="3">Manager</option>
                                    <option value="4">Agent</option>
                                    <option value="5">Client</option>
                                </select>
                            </li>
                            <?php } ?>
                            <li class="submitregi">
                                <input tabindex="5" type="image" src="image/RegiButton.png"/>
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
 