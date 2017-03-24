$(document).ready(function(){
    $("form[name=application_search] input[type=text]").focus(function(){
		if($(this).val() == $(this).attr("value")) {
			$(this).val("");
		}
    });
    
    $("form[name=application_search] input[type=text]").blur(function() {
    	if($(this).val() == "") {
    		$(this).val($(this).attr("value"));
    	}
    });
    
    $searchForm = $("form[name=application_search]");
	if($searchForm) {
		$searchForm.submit(function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			$processingOverlay = $('<div id="processingOverlay" class="bPopup">' +
                             		'<img src="/image/preloader.gif" />' +
                            		'<p>Performing Search...</p>' +
                        			'</div>').appendTo("body");
           	$processingOverlay.bPopup();
			
			$.post( 
				$searchForm.attr("action"), 
				$searchForm.serialize()
			).done(function( result ) {
				if(result == "SUCCESS") {
					window.location = "/property_applications.php";
				} else {
					$processingOverlay.close();
					alert("Please enter an address, zip, or city to search from.");
				}
				
			});
		});
	}
	
	$clearSearch = $("#clearSearch");
	if($clearSearch) {
		$clearSearch.click(function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			$processingOverlay = $('<div id="processingOverlay" class="bPopup">' +
                             		'<img src="/image/preloader.gif" />' +
                            		'<p>Clearing Search...</p>' +
                        			'</div>').appendTo("body");
           	$processingOverlay.bPopup();
			
			$.get( 
				$clearSearch.attr("href")
			).done(function( result ) {
				if(result == "SUCCESS") {
					window.location = "/property_applications.php";
				} else {
					$processingOverlay.close();
					alert("An error occcurred. Try again.");
				}
				
			});
		});
	}
});