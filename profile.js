/*
 * Author: Andrew Jarombek
 * Date: 10/9/2016 - 
 * JavaScript for the profile page
 */

$(document).ready(function() {

	// Set the date form input to the current date
	document.getElementById('log_date').valueAsDate = new Date();

	// All the log parameters
	var log_name, log_location, log_date, log_type, log_distance, log_metric, log_minutes, log_seconds, log_feel, log_description; 
    
	// Array of Objects for the different feel parameters
	var feel = {
		1: {color: 'rgba(204, 0, 0, .4)', name: 'Terrible', class: 'terrible_feel'},
		2: {color: 'rgba(255, 51, 0, .4)', name: 'Very Bad', class: 'very_bad_feel'},
		3: {color: 'rgba(204, 102, 0, .4)', name: 'Bad', class: 'bad_feel'},
		4: {color: 'rgba(255, 153, 0, .4)', name: 'Pretty Bad', class: 'pretty_bad_feel'},
		5: {color: 'rgba(187, 187, 187, .4)', name: 'Mediocre', class: 'mediocre_feel'},
		6: {color: 'rgba(255, 255, 51, .4)', name: 'Average', class: 'average_feel'},
		7: {color: 'rgba(115, 230, 0, .4)', name: 'Fairly Good', class: 'fairly_good_feel'},
		8: {color: 'rgba(0, 153, 0, .4)', name: 'Good', class: 'good_feel'},
		9: {color: 'rgba(0, 102, 0, .4)', name: 'Great', class: 'great_feel'},
		10: {color: 'rgba(26, 26, 255, .4)', name: 'Fantastic', class: 'fantastic_feel'}
	};

    // Validation for the log parameters
    var log_ok = false;
    var log_date_ok = false;
    var log_distance_ok = false;
    var log_minutes_ok = false;
    var log_seconds_ok = false;

    var log_date_error = false;
    var log_distance_error = false;
    var log_minutes_error = false;
    var log_seconds_error = false;
    var cpassword_error = false;

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

	    	// JSON log object to be processed by the server
	    	var log = {
	    		name: log_name,
	    		location: log_location,
	    		date: log_date,
	    		type: log_type,
	    		distance: log_distance,
	    		metric: log_metric,
	    		minutes: log_minutes,
	    		seconds: log_seconds,
	    		feel: log_feel,
	    		description: log_description
	    	};

	    	console.info("The submitted running log:");
	    	console.info(log);
	    } else {
	    	console.info("Errors in the submitted running log.");
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

    // Changes the color of the log input form background depending on the feel 
	function rangeBackground(feel_params) {
        var background_color = feel_params.color;
        $('#activityinput').css('background', background_color);
    }

    // Changes the text in the feel tag in the log input from 
    function rangeTag(feel_params) {
    	$('#feel_hint').html('').append(feel_params.name);
    }

    // Clears all the fields in the log input form
    function clearFields() {
    	$('#log_name').val('');
    	$('#log_location').val('');
    	$('#log_distance').val('');
    	$('#log_minutes').val('');
    	$('#log_seconds').val('');
    	$('#log_description').val('');

    	$('#log_feel').val('5');
    	$('#log_metric').val('miles');
    	$('#log_type').val('run');

    	document.getElementById('log_date').valueAsDate = new Date();
    }

    // Validates all of the required fields in the log input form
    function validate() {
    	validateDate();
    	validateDistance();
    	validateMinutes();
    	validateSeconds();

    	// If all the forms are valid
    	if (log_seconds_ok && log_minutes_ok && log_distance_ok && log_date_ok) {
    		log_ok = true;
    	}
    }

    function validateDate() {
    	if (log_date.length > 0 && validDate()) {
    		log_date_ok = true;
    		console.info("Valid date inputted.");
    	} else {
    		log_date_ok = false;
    		console.error("Invalid date inputted.");
    	}
    }

    function validateDistance() {

    }

    function validateMinutes() {

    }

    function validateSeconds() {

    }

    function validDate() { 
    	var startDate = new Date("January 1, 2016");
    	var today = new Date();
        var inputDate = new Date(log_date);

        // Make sure the date is in a proper time frame
        if (inputDate.value == " ") {
            return false;
        } else if (inputDate < startDate) {
        	console.info("The date is before 2016.");
            return false;
        } else if (inputDate > today) {
            console.info("The date is in the future.");
            return false;
        } else {
            return true;
        }
    }
});