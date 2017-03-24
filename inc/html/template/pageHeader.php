            <?php require_once("inc/classes/User.php"); 
            $user = new User();
            ?>
            
            <div class="sphead">
                <img src="/image/Logo.png" href="/">
                <div class="loginframe">
                    <?php if(isset($user) && $user -> isLoggedIn) { ?>
                         <a href="/logout.php"><h1>LOGOUT</h1></a>
                    <?php } else { ?>
                        <a href="/login.php"><h1>LOGIN</h1></a>
                    <?php } ?>
                </div> 
                <div class="navi style1">
                    <ul>
                        <?php if(isset($user) && $user -> isLoggedIn) { ?>
                            <?php if($user -> department < 5) { ?>
                            <li class="naviMP"><a href="/property_applications.php">Application Manager</a></li>
                            <li class="naviML"><a href="/property_leases.php">Lease Manager</a></li>
                            <li class="naviMR"><a href="/registration.php">Create User Account</a></li>
                            <?php } else { ?>
                            <li class="naviUserS"><a href="/user/saved_searches.php">Saved Searches</a></li>
                            <li class="naviUserP"><a href="/user/saved_properties.php">Saved Properties</a></li>
                            <?php } ?>
                        <?php } else { ?>
                            <li class="naviPublic"><a href="/registration.php">Create Account</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>