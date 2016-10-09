/*
 * Author: Andrew Jarombek
 * Date: 10/9/2016 - 
 * JavaScript for the profile page
 */

$(document).ready(function() {

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
    var log_date_ok = false;
    var log_distance_ok = false;
    var log_minutes_ok = false;
    var log_seconds_ok = false;

    var log_date_error = false;
    var log_distance_error = false;
    var log_minutes_error = false;
    var log_seconds_error = false;
    var cpassword_error = false;

    $('#log_feel').on("change mousemove", function() {
    	log_feel = $(this).val().trim();
    	var feel_params = feel[log_feel];
    	rangeBackground(feel_params);
    	rangeTag(feel_params);
	});

	function rangeBackground(feel_params) {
        var background_color = feel_params.color;
        $('#activityinput').css('background', background_color);
    }

    function rangeTag(feel_params) {

    }
});