/*
 * Author: Andrew Jarombek
 * Date: 2/19/2017
 * Javascript for the main page
 */

$(document).ready(function() {

    $(log_ident + " form").on("click", function() {
	    $(this).submit();
	});
});