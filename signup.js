/*
 * Author: Andrew Jarombek
 * Date: 5/31/2016 - 
 * JavaScript for the signup form
 */

$(document).ready(function() {
                
    var username, first, last, password, cpassword;
    var regexUsername = new RegExp("^[a-zA-Z0-9]+$");
    var regexName = new RegExp("^[a-zA-Z\-']+$");
    
    var username_ok = false;
    var first_ok = false;
    var last_ok = false;
    var password_ok = false;
    var cpassword_ok = false;
    var username_error = false;
    var first_error = false;
    var last_error = false;
    var password_error = false;
    var cpassword_error = false;
    
    // When Username Is Altered, check if it is in a valid format
    $('#su_username').keyup(function() {
        username = $('#su_username').val().trim();
        
        // Check if the username is already taken
        $.get('authenticate_username.php', {un : username}, function(response) {
            
            if (response === 'false' && regexUsername.test(username)) {
                // Valid Username
                username_ok = true;
                valid('#su_username');
            } else if (username.length == 0) {
                // No Entry - Unknown Validity
                username_ok = false;
                noValidity('#su_username');
            } else {
                // Inalid Username
                username_ok = false;
                invalid('#su_username');
            }
        });
    });

    // When the user leaves the username form, if it is invalid produce an error message
    $('#su_username').blur(function() {
        // check if there are existing errors
        if (formErrors()) {
            if (username_ok || username.length == 0) {
                username_error = false;
            } else {
                $('#su_error').html('').append('Invalid Username');
                username_error = true;
            }
        // If there are no existing errors
        } else if (username_ok || username.length == 0) {
            $('#su_error').html('');
            username_error = false;
        } else {
            $('#su_error').html('').append('Invalid Username');
            username_error = true;
        }
    });
    
    // When First Name Is Altered, check if it is in a valid format
    $('#su_first').keyup(function() {
        first = $('#su_first').val().trim();
        
        if (regexName.test(first)) {
            // Valid First Name
            first_ok = true;
            valid('#su_first');
        } else if (first.length == 0) {
            // No Entry - Unknown Validity
            first_ok = false;
            noValidity('#su_first');
        } else {
            // Invalid First Name
            first_ok = false;
            invalid('#su_first');
        }
    });

    // When the user leaves the first name form, if it is invalid produce an error message
    $('#su_first').blur(function() {
        
        // check if there are existing errors
        if (formErrors()) {
            if (first_ok || first.length == 0) {
                first_error = false;
            } else {
                $('#su_error').html('').append('Invalid First Name');
                first_error = true;
            }
        // If there are no existing errors
        } else if (first_ok || first.length == 0) {
            $('#su_error').html('');
            first_error = false;
        } else {
            $('#su_error').html('').append('Invalid First Name');
            first_error = true;
        }
    });
    
    // When Last Name Is Altered, check if it is in a valid format
    $('#su_last').keyup(function() {
        last = $('#su_last').val().trim();
        
        if (regexName.test(last)) {
            // Valid Last Name
            last_ok = true;
            valid('#su_last');
        } else if (last.length == 0) {
            // No Entry - Unknown Validity
            last_ok = false;
            noValidity('#su_last');
        } else {
            // Invalid Last Name
            last_ok = false;
            invalid('#su_last');
        }
    });

    // When the user leaves the last name form, if it is invalid produce an error message
    $('#su_last').blur(function() {
        // check if there are existing errors
        if (formErrors()) {
            if (last_ok || last.length == 0) {
                last_error = false;
            } else {
                $('#su_error').html('').append('Invalid Last Name');
                last_error = true;
            }
        // If there are no existing errors
        } else if (last_ok || last.length == 0) {
            $('#su_error').html('');
            last_error = false;
        } else {
            $('#su_error').html('').append('Invalid Last Name');
            last_error = true;
        }
    });
    
    // When Password Is Altered, check if it is in a valid format
    $('#su_password').keyup(function() {
        password = $('#su_password').val().trim();
        
        if (password.length > 5) {
            // Valid Password
            password_ok = true;
            valid('#su_password');
            
            // check if it matches the confirmed password
            if (password == cpassword) {
                cpassword_ok = true;
                valid('#su_cpassword');
            }
            
        } else if (password.length == 0) {
            // No Entry - Unknown Validity
            password_ok = false;
            noValidity('#su_password');
        } else {
            // Invalid Password
            password_ok = false;
            invalid('#su_password');
        }
    });

    // When the user leaves the password form, if it is invalid produce an error message
    $('#su_password').blur(function() {
        // check if there are existing errors
        if (formErrors()) {
            if (password_ok || password.length == 0) {
                password_error = false;
            } else {
                $('#su_error').html('').append('Invalid Password (Must be 6 or More Characters)');
                password_error = true;
            }
        // If there are no existing errors
        } else if (password_ok || password.length == 0) {
            $('#su_error').html('');
            password_error = false;
        } else {
            $('#su_error').html('').append('Invalid Password (Must be 6 or More Characters)');
            password_error = true;
        }
    });
    
    // When Confirm Password Is Altered, check if it is in a valid format
    $('#su_cpassword').keyup(function() {
        cpassword = $('#su_cpassword').val().trim();
        
        if (cpassword.length > 5 && password == cpassword) {
            // Valid Confirmed Password
            cpassword_ok = true;
            valid('#su_cpassword');
        } else if (cpassword.length == 0) {
            // No Entry - Unknown Validity
            cpassword_ok = false;
            noValidity('#su_cpassword');
        } else {
            // Invalid Confirmed Password
            c_password_ok = false;
            invalid('#su_cpassword');
        }
    });

    // When the user leaves the cpassword form, if it is invalid produce an error message
    $('#su_cpassword').blur(function() {
        // check if there are existing errors
        if (formErrors()) {
            if (cpassword_ok || cpassword.length == 0) {
                cpassword_error = false;
            } else {
                $('#su_error').html('').append('Passwords Must Match');
                cpassword_error = true;
            }
        // If there are no existing errors
        } else if (cpassword_ok || cpassword.length == 0) {
            $('#su_error').html('');
            cpassword_error = false;
        } else {
            $('#su_error').html('').append('Passwords Must Match');
            cpassword_error = true;
        }
    });
    
    // Try to Add a User and Make Them Pick Groups
    $('#su_submit').on('click', function() {
        $.post('adduser.php', {userDetails : [username,first,last,password]}, function(response) {
            
            if (response == 'true') {
                console.info("Sign up Successful");
                window.location = 'pickgroups.php';
            } else {
                console.error("Sign up Failed");
                window.location = 'index.php';
            }
        });
    });
    
    // If all the values are submitted properly
    function checkReady() {
        if (username_ok && first_ok && last_ok && password_ok && cpassword_ok) {
            $('#su_submit').removeAttr('disabled');
            $('#su_submit').css('border-color', 'black');
            $('#su_error').val('');
        } else {
            $('#su_submit').attr('disabled','true');
            $('#su_submit').css('border-color', '#999');
        }
    }
    
    // Change CSS if input is invalid and check if entire form is ready
    function invalid(selector) {
        $(selector).removeClass('valid');
        $(selector).addClass('invalid');
        checkReady();
    }
    
    // Change CSS if input is valid and check if entire form is ready
    function valid(selector) {
        $(selector).removeClass('invalid');
        $(selector).addClass('valid');
        checkReady();
    }
    
    // Change CSS if input validity is unknown (empty input form) and check if entire form is ready
    function noValidity(selector) {
        $(selector).removeClass('valid');
        $(selector).removeClass('invalid');
        checkReady();
    }

    // Return whether any of the forms have produced errors
    function formErrors() {
        return (username_error || first_error || last_error || password_error || cpassword_error);
    }
    
});