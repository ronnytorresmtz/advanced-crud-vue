 
 $(document).ready(function() {
 	$("input:checkbox").click(function() {
	    if ($(this).is(":checked")) {
	        var group = "input:checkbox[name='" + $(this).attr("name") + "']";
	        $(group).prop("checked", false);
	        $(this).prop("checked", true);
	    } else {
	        $(this).prop("checked", false);
	    }
	});
});
