/*
 * Author: Andrew Jarombek
 * Date: 10/9/2016 - 2/20/2017
 * JavaScript for log input
 * Version 0.4 (BETA) - 12/24/2016
 * Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
 * Version 0.6 (GROUPS UPDATE) - 2/20/2017
 */

$(document).ready(function() {

    // Set the default input date to today
    date = Date.parse('today');

    if ( $('#log_date').prop('type') != 'date' ) {
        date = date.toString('M/d/yyyy');
    } else {
        date = date.toString('yyyy-MM-dd');
    }

    $('#log_date').val(date);

    // When the user hits submit, save all of the values and create a new log.
    // Also dynamically display the new log at the top of the users profile feed
    $('#log_submit').on("click", function() {

    	// Get all of the log form inputs
    	log_name = $('#log_name').val().trim();
    	log_location = $('#log_location').val().trim();
    	log_date = $('#log_date').val().trim();
    	log_type = $('#log_type').val().trim();
    	log_distance = $('#log_distance').val().trim();
    	log_metric = $('#log_metric').val().trim();
    	log_minutes = $('#log_minutes').val().trim();
    	log_seconds = $('#log_seconds').val().trim();
    	log_feel = $('#log_feel').val().trim();
    	log_description = $('#log_description').val().trim();

    	validate();

    	if (log_ok) {

    		// If the values are just whitespace, store them as null
    		var regexEmpty = new RegExp("^\w+$");
    		if (log_name.length == 0 || regexEmpty.test(log_name)) {
    			log_name = null;
    		}

    		if (log_location.length == 0 || regexEmpty.test(log_location)) {
    			log_location = null;
    		}

    		if (log_description.length == 0 || regexEmpty.test(log_description)) {
    			log_description = null;
    		}

            // Get the time value from the inputted minutes and seconds
            var log_hours = Math.floor(log_minutes / 60);
            log_minutes = (log_minutes % 60);

            if (log_hours < 10)
                log_hours = "0" + String(log_hours);
            if (log_minutes < 10)
                log_minutes = "0" + String(log_minutes);
            if (log_seconds < 10)
                log_seconds = "0" + String(log_seconds);

            var log_time = String(log_hours) + ':' + String(log_minutes) + ':' + String(log_seconds);

            var date = Date.parse(log_date);
            log_date = date.toString('yyyy-MM-dd');

	    	// JSON log object to be processed by the server
	    	var log = {
	    		name: log_name,
	    		location: log_location,
	    		date: log_date,
	    		type: log_type,
	    		distance: log_distance,
	    		metric: log_metric,
	    		time: log_time,
	    		feel: log_feel,
	    		description: log_description
	    	};

	    	clearFields();
	    	resetErrors();
	    	console.info("The submitted running log:");
	    	console.info(log);

            // Encode the array of user information
            var logString = JSON.stringify(log);

            // Send an AJAX request to submit a log
            $.post('logdetails.php', {submitlog : logString}, function(response) {
                if (response == 'false') {
                    server_error = "There was a Server Error Uploading the Log";
                    highlightErrors();
                    displayErrorMessage();
                } else {
                    console.info(response);
                    var newLog = JSON.parse(response);
                    populateLog(newLog);
                    resetErrors();
                    highlightErrors();
                }
            });
	    } else {
	    	console.info("Errors in the submitted running log.");
	    	highlightErrors();
	    	displayErrorMessage();
	    }
    });

    // when the user hits cancel, reset all the fields in the log input form
    $('#log_cancel').on("click", function() {
    	clearFields();
    });

	// When the log feel is changed, get its value and call rangeBackground and rangeTag
    $('#log_feel').on("change mousemove", function() {
    	log_feel = $(this).val().trim();
    	var feel_params = feel[log_feel];
    	rangeBackground(feel_params);
    	rangeTag(feel_params);
	});
});