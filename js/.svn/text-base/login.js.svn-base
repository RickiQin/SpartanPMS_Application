$(document).ready(function () {
	if($("#login").length > 0) {
		$loginLink = $("#login");
		$loginPopup = $("#loginBox");
		$loginLink.click(function() {
			$loginPopup.bPopup();
			$("#username").focus();
			return false;
		});
		
		$loginForm = $("#loginForm");
		
		$loginForm.submit(function() {
			
			$username = $("input[name=username]").val();
			$password = $("input[name=password]").val();
			
			$postData = {
				"username" : $username,
				"p" :  hex_sha512($password)
			};
			
			$.ajax( {
		    	type: "POST",
		    	url: $loginForm.attr('action'),
		    	data: $postData,
		    	dataType: "json",
		    	success: function( response ) {
		   			if(response.status == false) {
		   				 // FAILURE
		    			$loginPopup.children("p").html("<strong>Login failed.</strong> " + response.message);
		    			$loginPopup.children("p").css("color","red");
		   			} else {
		   				 // SUCCESS
		    			$loginPopup.children("p").html("<strong>Success.</strong> You are being redirected to the Affiliate Homepage!");
		    			$loginPopup.children("p").css("color","green");
		    			$loginForm.remove();
		    			
		    			window.location = "/affiliate/";
		   			}
		      	}
		    });
		  
		    return false;
  
		});
	}
});
