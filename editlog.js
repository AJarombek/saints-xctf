/*
 * Author: Andrew Jarombek
 * Date: 2/5/2017 - 
 * JavaScript for the edit log form
 * Functions and variables are in log_utils.js
 */

$(document).ready(function() {

    // Use the get parameter logno to get log details
    var query = window.location.search.substring(1);
    query = query.substring(6, query.length);
    console.info(query);

    $.get('editlogdetails.php', {getlog : query}, function(response) {

        var log = JSON.parse(response);
        console.info(log);
        populate(log);
    });

    // Function for when you want to cancel the edit log changes
    $('#log_cancel').on('click', function() {
        // Go back to the previous page
        window.history.back();
    });

    // function for when the user submits the log changes
    $('#log_submit').on('click', function() {

        // Reset any previous errors diplayed
        resetErrors();

        // This creates a log object and initializes variables for validation
        log = getValues();
        log.log_id = query;

        // Make sure the log object is valid
        validate();

        // If the log is okay send it to the server to update
        if (log_ok) {

            var logString = JSON.stringify(log);

            $.post('editlogdetails.php', {updatelog : logString}, function(response) {

                if (response == "true") {
                    console.log("Log Edit Successful");
                    window.location = document.referrer;
                } else {
                    console.log("Log Edit FAILED");
                    server_error = "There was a Server Error Updating the Log";
                    highlightErrors();
                    displayErrorMessage();
                }
            });

        // Otherwise highlight the errors and display an error message
        } else {
            console.info("Errors in the submitted running log.");
            highlightErrors();
            displayErrorMessage();
        }
    });

    // When the log feel is changed, get its value and call rangeBackground and rangeTag
    $('#log_feel').on("change mousemove", function() {
        log_feel = $(this).val().trim();
        var feel_params = feel[log_feel];
        rangeBackground(feel_params);
        rangeTag(feel_params);
    });
});