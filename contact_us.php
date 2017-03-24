<?php

require_once("inc/SiteBuilderClass.php");
require_once("inc/classes/User.php");


$template = new SiteBuilder();
$user = new User();

if($_GET['messageReceived']) {
    $to = "danielc111@gmail.com";
    $subject = "MESSAGE: " . $_POST['subject'];
    $message = $_POST['prodetail'] . "\n\n";
    
    if($user -> isLoggedIn) {
        $message .= "User Name: " . $user -> firstName . " " . $user -> lastName . "\n";
        $message .= "Phone: " . $user -> phone . "\n";
    }
    
    
    $from = $_POST['email'];
    $headers = "From:" . $from;
    mail($to,$subject,$message,$headers);
}


$template -> setCSS(); 
$template -> setJscript();

$template -> setPageTitle("Contact Us Spartan PMS");

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
                    <h1>Contact Us</h6>
                    <?php if(isset($_GET['messageReceived'])) { ?>
                        <p class="contact">Your message has been received. A representative will be in contact with you shortly.</p>
                        
                    <?php } else { ?>
                    <form method="post" action="contact_us.php?messageReceived=1" name="register">
                        <ul>
                            <li class="typename">
                                <span>Subject: </span><input type="text" tabindex="2" name="subject" class="border_radius" value=""/>
                            </li>
                            <li class="typename">
                                <?php if($user -> isLoggedIn) { ?>
                                <span>Your Email: </span><input type="text" tabindex="2" name="email" class="border_radius" value="<?php echo $user -> emailAddress; ?>" readonly="readonly"/>    
                                <?php } else { ?>
                                <span>Your Email: </span><input type="text" tabindex="2" name="email" class="border_radius" value=""/>
                                <?php } ?>
                            </li>
                            <li class="pbdetail">
                                <span>Message:</span>
                                <p><textarea tabindex="3" name="prodetail" class="border_radius" cols='40' rows='8'></textarea></p>
                            </li>                           
                            <li class="submitregi">
                                <input tabindex="4" type="image" src="image/Submit.png"/>
                            </li>
                        </ul>
                    </form>
                    <?php } ?>
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
