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
		 	<div class="contentWrapper">
			 	<?php $template -> getSearchForm(); ?>
			 	<div class='picshow'>
		 			<img src="image/showingarea.jpg">
		 		</div>
		 		<?php if($user -> isLoggedIn && $user -> department < 4) { ?>
		 		<div class="addp">
                    <a href="edit/property.php"><img src="image/AddNewProperty.png" /></a><br/><br/>
                     <a href="registration.php"><img src="image/Add_User_btn.png"/></a>
                </div>
                <?php } else if(count($user -> getPropertyLeases()) > 0) { ?>
                <div class="addp">
                    <a href="maintenance_request.php"><img src="image/SubmitMaintenanceRequest.png" /></a><br/>
                </div>
                
                    
                <?php } ?>
			 </div>
		 	<div class="foot">
		 		<?php $template -> getNavigation(); ?>
		 	</div>
		</div>
	</body>
</html>
