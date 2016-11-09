/*
 * Author: Andrew Jarombek
 * Date: 11/8/2016 - 
 * JavaScript for the edit profile page form
 */

$(document).ready(function() {

    var user,username,first,last,year,location,event,description,profilepic,profilepic_name;
    var first_ok,last_ok,profilepic_ok = true;

    // First get the profile details to fill in current details
    var userJSON = getProfileInfo();

    $('#edit_cancel').on('click', function() {
        
    });

    $('#edit_submit').on('click', function() {
        
        // Build an object for the updated user information
        var newUser = new Object();

        if ((first = getFirst()) != null) {
            newUser.first = first;
        } else {
            console.info("Invalid First Name");
            first_ok = false;
        }

        if ((last = getLast()) != null) {
            newUser.last = last;
        } else {
            console.info("Invalid Last Name");
            last_ok = false;
        }

        if ((year = getYear()) != null)
            newUser.year = year;
        if ((location = getLocation()) != null)
            newUser.location = location;
        if ((event = getEvent()) != null)
            newUser.event = event;
        if ((description = getDescription()) != null)
            newUser.description = description;

        if (mensxc != null)
            newUser.groups.mensxc = "Men's Cross Country";
        if (wmensxc != null)
            newUser.groups.wmensxc = "Women's Cross Country";
        if (menstf != null)
            newUser.groups.menstf = "Men's Track & Field";
        if (wmenstf != null)
            newUser.groups.wmenstf = "Women's Track & Field";
        if (alumni != null)
            newUser.groups.alumni = "Alumni";

        // Encode the array of user information
        var userString = JSON.stringify(newUser);

        console.info("New User Info: ", userString);

        // Send an AJAX request to update the user profile information
        $.post('editprofiledetails.php', {updateprofileinfo : userString}, function(response) {

        });
    });

    // Get the Profile Details to fill in form values
    function getProfileInfo() {
        var userJSON;

        $.get('editprofiledetails.php', {getprofileinfo : true}, function(response) {
            if (response != null) {
                console.info("Profile User Info: ", response);
                userJSON = response;
                user = JSON.parse(userJSON);
                setValues(user);
            } else {
                console.error("FAILED to get User Information.");
            }
        });
        return user;
    }

    // Get the Profile Username
    function getUsername() {
        var username;

        $.get('editprofiledetails.php', {getusername : true}, function(response) {
            if (response != null) {
                console.info("Profile Username: ", response);
                username = response;
            } else {
                console.error("FAILED to get Username.");
            }
        });
        return username;
    }

    // Sets the current values for the fields if they exist
    function setValues(user) {
        console.info("User:", user);

        username = String(user['username']);
        console.info("Username: ", username);
        first = String(user[username]['first']);
        console.info("First Name: ", first);
        last = String(user[username]['last']);
        year = String(user[username]['year']);
        location = String(user[username]['location']);
        event = String(user[username]['event']);
        description = String(user[username]['description']);

        // Set current values for the fields if they exist
        if (first != 'null') {
            setFirst(first);
        }
        if (last != 'null') {
            setLast(last);
        }
        if (year != 'null' && year != 'undefined') {
            setYear(year);
        }
        if (location != 'null' && location != 'undefined') {
            setLocation(location);
        }
        if (event != 'null' && event != 'undefined') {
            setEvent(event);
        }
        if (description != 'null' && description != 'undefined') {
            setDescription(description);
        }
    }

    // GETTERS AND SETTERS FOR THE FORM

    // Get the value in the First Name input
    function getFirst() {
        var first = $('#edit_first').val().trim();
        return first;
    }

    // Set the value in the First Name input
    function setFirst(first) {
        console.info("Setting the Current First Name: ", first);
        $('#edit_first').val(first);
    }

    // Get the value in the Last Name input
    function getLast() {
        var first = $('#edit_last').val().trim();
        return first;
    }

    // Set the value in the Last Name input
    function setLast(last) {
        $('#edit_last').val(last);
    }

    // Get the value in the Class Year input
    function getYear() {
        var first = $('#edit_year').val().trim();
        return first;
    }

    // Set the value in the Class Year input
    function setYear(year) {
        $('#edit_year').val(year);
    }

    // Get the value in the Location input
    function getLocation() {
        var first = $('#edit_location').val().trim();
        return first;
    }

    // Set the value in the Location input
    function setLocation(location) {
        $('#edit_location').val(location);
    }

    // Get the value in the Event input
    function getEvent() {
        var first = $('#edit_event').val().trim();
        return first;
    }

    // Set the value in the Event input
    function setEvent(event) {
        $('#edit_event').val(event);
    }

    // Get the value in the Description input
    function getDescription() {
        var first = $('#edit_description').val().trim();
        return first;
    }

    // Set the value in the Description input
    function setDescription(description) {
        $('#edit_description').val(description);
    }
});