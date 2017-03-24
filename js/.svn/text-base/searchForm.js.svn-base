$(document).ready(function(){
    $("form[name=property_search] input[type=text]").focus(function(){
		if($(this).val() == $(this).attr("value")) {
			$(this).val("");
		}
    });
    
    $("form[name=property_search] input[type=text]").blur(function() {
    	if($(this).val() == "") {
    		$(this).val($(this).attr("value"));
    	}
    });
    
    $searchForm = $("form[name=property_search]");
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
					window.location = "/property_search.php";
				} else {
					$processingOverlay.close();
					alert("Please enter an address, zip, or city to search from.");
				}
				
			});
		});
	}
	
	$searchSorter = $("form[name=searchSorter]");
	if($searchSorter) {
		$searchSorter.change(function(e) {
			e.preventDefault();
			e.stopPropagation();
			
			$processingOverlay = $('<div id="processingOverlay" class="bPopup">' +
                             		'<img src="/image/preloader.gif" />' +
                            		'<p>Updating search...</p>' +
                        			'</div>').appendTo("body");
           	$processingOverlay.bPopup();
			
			$.post( 
				$searchSorter.attr("action"), 
				{sortby : $("form[name=searchSorter] option:selected").val()}
			).done(function( result ) {
				if(result == "SUCCESS") {
					window.location = "/property_search.php";
				} else {
					$processingOverlay.close();
					alert("Error handling your request.");
				}
				
			});
		});
	}
	
	$saveSearch = $("#saveSearch");
	if($saveSearch) {
		$saveSearch.click(function(e) {
			e.preventDefault();
			
			$overlay = $('<div id="processingOverlay" class="bPopup"><h1>Save This Search</h1><br/><br/>' +
				'<form name="saveSearch" method="post" action="/processes/save_search.php">' +
				'<label>Name this search:</label><input name="searchName" type="text" value="Saved Search"/><br/><br/>' +
				'<input type="image" src="/image/Submit.png"/></form>' +
				'</div>').appendTo("body");
				
			$overlay.bPopup();	
		});
	}
});