/*
 * Author: Andrew Jarombek
 * Date: 11/8/2016 - 
 * JavaScript for the edit profile page form
 */

$(document).ready(function() {

    var first,last,year,location,event,description,profilepic,profilepic_name;

    // First get the profile details to fill in current details
    var userJSON = getProfileInfo();
    var user = JSON.parse(userJSON);

    $('#edit_cancel').on('click', function() {
        
    });

    $('#edit_submit').on('click', function() {
        
        // Build an object for the updated user information
        var newUser = new Object();
        if (mensxc != null)
            joined.groups.mensxc = "Men's Cross Country";
        if (wmensxc != null)
            joined.groups.wmensxc = "Women's Cross Country";
        if (menstf != null)
            joined.groups.menstf = "Men's Track & Field";
        if (wmenstf != null)
            joined.groups.wmenstf = "Women's Track & Field";
        if (alumni != null)
            joined.groups.alumni = "Alumni";

        // Encode the array of user information
        var userString = JSON.stringify(newUser);

        console.info("New User Info: ", userString);

        // Send an AJAX request to update the user profile information
        $.post('editprofiledetails.php', {updateprofileinfo : userString}, function(response) {

        });
    });

    // Get the Profile Details to fill in form values
    function getProfileInfo() {
        var user;

        $.get('editprofiledetails.php', {getprofileinfo : true}, function(response) {
            user = response;
        });
        return user;
    }

    // GETTERS AND SETTERS FOR THE FORM

    // Get the value in the First Name input
    function getFirst() {
        var first = $('#edit_first').val().trim();
        return first;
    }

    // Set the value in the First Name input
    function setFirst(first) {
        $('#edit_first').html('').append(first);
    }

    // Get the value in the Last Name input
    function getLast() {
        var first = $('#edit_last').val().trim();
        return first;
    }

    // Set the value in the Last Name input
    function setLast(last) {
        $('#edit_first').html('').append(last);
    }

    // Get the value in the Class Year input
    function getYear() {
        var first = $('#edit_year').val().trim();
        return first;
    }

    // Set the value in the Class Year input
    function setYear(year) {
        $('#edit_year').html('').append(year);
    }

    // Get the value in the Location input
    function getLocation() {
        var first = $('#edit_location').val().trim();
        return first;
    }

    // Set the value in the Location input
    function setLocation(location) {
        $('#edit_location').html('').append(location);
    }

    // Get the value in the Event input
    function getEvent() {
        var first = $('#edit_event').val().trim();
        return first;
    }

    // Set the value in the Event input
    function setEvent(event) {
        $('#edit_event').html('').append(event);
    }

    // Get the value in the Description input
    function getDescription() {
        var first = $('#edit_description').val().trim();
        return first;
    }

    // Set the value in the Description input
    function setDescription(description) {
        $('#edit_description').html('').append(description);
    }
});