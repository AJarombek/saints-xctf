/*
 * Author: Andrew Jarombek
 * Date: 12/21/2016 - 12/24/2016
 * JavaScript for the feedback form and button
 * Version 0.4 (BETA) - 12/24/2016
 */

$(document).ready(function() {

    // When the user hits submit, send the feedback info via email
    $('#fb_submit').on("click", function() {

    	// Get all of the log form inputs
    	title = $('#fb_title').val().trim();
    	content = $('#fb_content').val().trim();

    	// JSON log object to be processed by the server
    	var feedback = {
    		title: title,
    		content: content,
    	};

    	console.info("The submitted feedback:");
    	console.info(feedback);

        // Encode the array of feedback information
        var feedbackString = JSON.stringify(feedback);

        // Send an AJAX request to submit a feedback form
        $.get('sendfeedback.php', {submitfeedback : feedbackString}, function(response) {
            if (response == 'false') {
                console.info("Server Error Submitting Feedback");
            } else {
                console.info("Feedback Submitted");
            }

            $("#feedbackform").css('display', 'none');
        });
    });

    // When the user hits cancel, just make the form visibility hidden
    $('#fb_cancel').on("click", function() {
        $("#feedbackform").css('display', 'none');
    });

    // When the user clicks the feedback button, make the form visible with effects
    $('#feedback').on("click", function() {
        $( '#feedbackform' ).fadeIn( 500 );
    });
});