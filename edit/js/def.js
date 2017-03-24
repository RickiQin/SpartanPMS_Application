$(document).ready(function() {
	$("form").submit(function() {	
		$shouldSubmitForm = false;	
		$.ajax({
		    type: "POST",
		    traditional: true,
		    url: 'processes/validation.php?form=' + $(this).attr("name"),
		    async: false,
		    data: $(this).serialize(),
		    dataType: "json",
		    success: function (data) {
		        if(data.status == true) {
		        	$shouldSubmitForm = true;
		        } else {
		        	alert("Please complete form with valid data.");        	
		        }
		    },
		    error: function () {
		        alert("An error occurred. Please try again.");
		    }
		});
		return $shouldSubmitForm;
	});
});
