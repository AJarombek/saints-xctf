/*
 * Author: Andrew Jarombek
 * Date: 11/8/2016 - 6/2/2017
 * JavaScript for the edit profile page form
 * Version 0.4 (BETA) - 12/24/2016
 * Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
 * Version 0.6 (GROUPS UPDATE) - 2/20/2017
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

$(document).ready(function() {

    var user,username,first,last,email,year,location,event,description,week_start,profilepic,profilepic_name;
    var first_error,last_error,email_error,profilepic_error;

    // First get the profile details to fill in current details
    var userJSON = getProfileInfo();

    // When the user finishes uploading a file for the profile picture
    $('#file').on('change', function() {
        var v = this.value;
        profilepic_name = v.replace(/.*[\/\\]/, '');
        var size;

        var files = this.files;

        // If there are no uploaded files
        if (!files) {
            profilepic_error = "File upload not supported by your browser.";
        }

        if (files && files[0]) {
            var file = files[0];
            size = file.size;
            console.info("File Uploaded: ", file);

            // Make sure that the filename ends in .png, .jpeg, .jpg, or .gif
            if ((/\.(png|jpeg|jpg|gif)$/i).test(file.name)) {
                readImage(file);
            } else {
                profilepic_error = file.name +" Unsupported Image extension.";  
            }
        }

        console.info('Selected file: ' + profilepic_name);
        console.info('Selected file size: ' + size);
    });

    // Helper function to read the image with a fileReader and load it to the page
    function readImage(file) {
        var reader = new FileReader();
        reader.readAsDataURL(file);

        // At this point the file has been read
        reader.addEventListener("load", function() {
            $('#profilePic').attr("src", this.result);
            profilepic = this.result;
        });
    }

    // Function for when you want to cancel the edit profile changes
    $('#edit_cancel').on('click', function() {
        // Go back to the profile page
        window.history.back();
    });

    // Function for when you want to submit the edit profile changes
    $('#edit_submit').on('click', function() {
        $("#edit_error").html('');
        
        // Build an object for the updated user information
        var newUser = new Object();

        var regexName = new RegExp("^[a-zA-Z\-']+$");
        var regexEmail = new RegExp("^(([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+)?$");

        // First Name Must Be Filled In and be valid
        if ((first = getFirst()).length != 0 && regexName.test(first)) {
            newUser.first = first;
            valid('#edit_first');
        } else {
            // Display error, return, and don't call server
            console.info("Invalid First Name");
            invalid('#edit_first');
            $("#edit_error").html('').append("<i class='material-icons md-18 error'>error</i><b>First Name is Invalid</b>");
            return;
        }

        // Last Name Must Be Filled In and be valid
        if ((last = getLast()).length != 0 && regexName.test(last)) {
            newUser.last = last;
            valid('#edit_last');
        } else {
            // Display error, return, and don't call server
            console.info("Invalid Last Name");
            invalid('#edit_last');
            $("#edit_error").html('').append("<i class='material-icons md-18 error'>error</i><b>Last Name is Invalid</b>");
            return;
        }

        // Email is not mandatory, but it must be valid
        if ((email = getEmail()).length != 0) { 
            if (regexEmail.test(email)) {
                newUser.email = email;
                valid('#edit_email');
            } else {
                // Display error, return, and don't call server
                console.info("Invalid Email");
                invalid('#edit_email');
                $("#edit_error").html('').append("<i class='material-icons md-18 error'>error</i><b>Email must be Valid</b>");
                return;
            }
        }

        // Year is not mandatory, but it must be an integer
        var regexYear = new RegExp("^[0-9]+$");
        if ((year = getYear()).length != 0) { 
            if (regexYear.test(year)) {
                newUser.year = year;
                valid('#edit_year');
            } else {
                // Display error, return, and don't call server
                console.info("Invalid Year");
                invalid('#edit_year');
                $("#edit_error").html('').append("<i class='material-icons md-18 error'>error</i><b>Year must be Valid</b>");
                return;
            }
        }

        if ((location = getLocation()).length != 0)
            newUser.location = location;
        if ((event = getEvent()).length != 0)
            newUser.event = event;
        if ((description = getDescription()).length != 0)
            newUser.description = description;
        if ((week_start = getWeekStart()).length != 0)
            newUser.week_start = week_start;

        if (profilepic != null)
            newUser.profilepic = profilepic;
        if (profilepic_name != null)
            newUser.profilepic_name = profilepic_name;

        newUser.groups = new Object();
        if (mensxc != null) {
            newUser.groups.mensxc = 
                {
                    "group_name":"mensxc", 
                    "group_title":"Men's Cross Country", 
                    "status":mensxc_status, 
                    "user":mensxc_admin
                };
        }
        if (wmensxc != null) {
            newUser.groups.wmensxc = 
                {
                    "group_name":"wmensxc", 
                    "group_title":"Women's Cross Country", 
                    "status":wmensxc_status, 
                    "user":wmensxc_admin
                };
        }
        if (menstf != null) {
            newUser.groups.menstf = 
                {
                    "group_name":"menstf", 
                    "group_title":"Men's Track & Field", 
                    "status":menstf_status, 
                    "user":menstf_admin
                };
        }
        if (wmenstf != null) {
            newUser.groups.wmenstf = 
                {
                    "group_name":"wmenstf", 
                    "group_title":"Women's Track & Field", 
                    "status":wmenstf_status, 
                    "user":wmenstf_admin
                };
        }
        if (alumni != null) {
            newUser.groups.alumni = 
                {
                    "group_name":"alumni", 
                    "group_title":"Alumni", 
                    "status":alumni_status, 
                    "user":alumni_admin
                };
        }

        // Encode the array of user information
        var userString = JSON.stringify(newUser);

        console.info("New User Info: ", userString);

        // Send an AJAX request to update the user profile information
        $.post('editprofiledetails.php', {updateprofileinfo : userString}, function(response) {
            if (response == 'true') {
                window.history.back();
            } else {
                $("#edit_error").html('').append("<i class='material-icons md-18 error'>error</i><b>Server Error: Unable to Edit Profile</b>");
            }
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
        first = String(user['first']);
        console.info("First Name: ", first);
        last = String(user['last']);
        email = String(user['email']);
        year = String(user['class_year']);
        location = String(user['location']);
        event = String(user['favorite_event']);
        description = String(user['description']);
        week_start = String(user['week_start']);

        // Set current values for the fields if they exist
        if (first != 'null') {
            setFirst(first);
        }
        if (last != 'null') {
            setLast(last);
        }
        if (email != 'null' && email != 'undefined') {
            setEmail(email);
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
        if (week_start != 'null' && week_start != 'undefined') {
            setWeekStart(week_start);
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
        var last = $('#edit_last').val().trim();
        return last;
    }

    // Set the value in the Last Name input
    function setLast(last) {
        console.info("Setting the Current Last Name: ", last);
        $('#edit_last').val(last);
    }

    // Get the value in the Email input
    function getEmail() {
        var email = $('#edit_email').val().trim();
        return email;
    }

    // Set the value in the Email input
    function setEmail(email) {
        console.info("Setting the Current Email: ", email);
        $('#edit_email').val(email);
    }

    // Get the value in the Class Year input
    function getYear() {
        var year = $('#edit_year').val().trim();
        return year;
    }

    // Set the value in the Class Year input
    function setYear(year) {
        console.info("Setting the Current Year: ", year);
        $('#edit_year').val(year);
    }

    // Get the value in the Location input
    function getLocation() {
        var location = $('#edit_location').val().trim();
        return location;
    }

    // Set the value in the Location input
    function setLocation(location) {
        console.info("Setting the Current Location: ", location);
        $('#edit_location').val(location);
    }

    // Get the value in the Event input
    function getEvent() {
        var event = $('#edit_event').val().trim();
        return event;
    }

    // Set the value in the Event input
    function setEvent(event) {
        console.info("Setting the Current Event: ", event);
        $('#edit_event').val(event);
    }

    // Get the value in the Description input
    function getDescription() {
        var description = $('#edit_description').val().trim();
        return description;
    }

    // Set the value in the Description input
    function setDescription(description) {
        console.info("Setting the Current Description: ", description);
        $('#edit_description').val(description);
    }

    // Get the value in the Week Start Radio Button
    function getWeekStart() {
        var week_start = $('input[name=week_start]:checked').val();
        return week_start;
    }

    // Set the value in the Week Start Radio Button
    function setWeekStart(week_start) {
        console.info("Setting the Current Week Start: ", week_start);
        $("input[name=week_start][value='" + week_start + "']").prop("checked", true);
    }

    // Change CSS if input is invalid and check if entire form is ready
    function invalid(selector) {
        $(selector).addClass('invalid');
    }
    
    // Change CSS if input is valid and check if entire form is ready
    function valid(selector) {
        $(selector).removeClass('invalid');
    }
});