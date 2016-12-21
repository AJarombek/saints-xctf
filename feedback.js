/*
 * Author: Andrew Jarombek
 * Date: 10/9/2016 - 
 * JavaScript for the profile page
 */

$(document).ready(function() {

    // When the user hits submit, save all of the values and create a new log.
    // Also dynamically display the new log at the top of the users profile feed
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

        // Encode the array of user information
        var feedbackString = JSON.stringify(feedback);

        // Send an AJAX request to submit a log
        $.post('logdetails.php', {submitfeedback : feedbackString}, function(response) {
            if (response == 'false') {
                console.info("Server Error Submitting Feedback");
            } else {
                console.info("Feedback Submitted");
            }

            $("#feedbackform").css('visibility', 'hidden');
        });
    });

    $('#fb_cancel').on("click", function() {
        $("#feedbackform").css('visibility', 'hidden');
    });

    $('#feedbackbutton').on("click", function() {
        $("#feedbackform").css('opacity', '0');
        $("#feedbackform").css('visibility', '');
        $("#feedbackform").css('transtion', 'opacity 2s');
    });
});