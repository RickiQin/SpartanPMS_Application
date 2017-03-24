$(document).ready(function(){
    $("form input[type=text]").focus(function(){
        if($(this).val() == $(this).attr("value")) {
            $(this).val("");
        }
    });
    
    $("form input[type=text]").blur(function() {
        if($(this).val() == "") {
            $(this).val($(this).attr("value"));
        }
    });
    
    
    if($("form[name=login]")) {
    	$loginForm = $("form[name=login]");
	    $loginForm.submit(function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			$processingOverlay = $('<div id="processingOverlay" class="bPopup">' +
                             		'<img src="/image/preloader.gif" />' +
                            		'<p>Logging In...</p>' +
                        			'</div>').appendTo("body");
           	$processingOverlay.bPopup();
			$.post( 
				$(this).attr("action"), 
				$(this).serialize()
			).done(function( result ) {
				if(result == "SUCCESS") {
					window.location = "/";
				} else {
					$processingOverlay.close();
					alert("Username or password is incorrect.");
				}
				
			});
		});
	}
	
	if($("form[name=register]")) {
    	$loginForm = $("form[name=register]");
	    $loginForm.submit(function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			$processingOverlay = $('<div id="processingOverlay" class="bPopup">' +
                             		'<img src="/image/preloader.gif" />' +
                            		'<p>Creating Account...</p>' +
                        			'</div>').appendTo("body");
           	$processingOverlay.bPopup();
			
			$.post( 
				$loginForm.attr("action"), 
				$loginForm.serialize()
			).done(function( result ) {
				if(result == "SUCCESS") {
					window.location = "/login.php?newAccount";
				} else {
					$processingOverlay.close();
					alert("Please complete all of the form with valid data.");
				}
				
			});
		});
	}
});