/*
 * Author: Andrew Jarombek
 * Date: 5/31/2016 - 6/2/2017
 * JavaScript for the signup form
 * Version 0.4 (BETA) - 12/24/2016
 * Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
 * Version 0.6 (GROUPS UPDATE) - 2/20/2017
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

$(document).ready(function() {
                
    var username, first, last, email, password, cpassword, code;
    var regexUsername = new RegExp("^[a-zA-Z0-9]+$");
    var regexName = new RegExp("^[a-zA-Z\-']+$");
    var regexEmail = new RegExp("^(([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+)?$");
    
    var username_ok = false;
    var first_ok = false;
    var last_ok = false;
    var email_ok = false;
    var password_ok = false;
    var cpassword_ok = false;
    var code_ok = false;
    var username_error = false;
    var first_error = false;
    var last_error = false;
    var email_error = false;
    var password_error = false;
    var cpassword_error = false;
    var code_error = false;
    
    // When Username Is Altered, check if it is in a valid format
    $('#su_username').keyup(function() {
        username = $('#su_username').val().trim();

        if (regexUsername.test(username)) {
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

    // When the user leaves the username form, if it is invalid produce an error message
    $('#su_username').blur(function() {
        // check if there are existing errors
        if (formErrors()) {
            if (username_ok) {
                $('#su_error').html('');
                username_error = false;
            } else if (username.length == 0) {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                    "<b> Username is Mandatory</b>");
                username_error = true;
            } else {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                    "<b> Invalid Username</b>");
                username_error = true;
            }
        // If there are no existing errors
        } else if (username_ok) {
            $('#su_error').html('');
            username_error = false;
        } else if (username.length == 0) {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                "<b> Username is Mandatory</b>");
            username_error = true;
        } else {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                "<b> Invalid Username</b>");
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
            if (first_ok) {
                $('#su_error').html('');
                first_error = false;
            } else if (first.length == 0) {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                    "<b> First Name is Mandatory</b>");
                first_error = true;
            } else {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                    "<b> Invalid First Name</b>");
                first_error = true;
            }
        // If there are no existing errors
        } else if (first_ok) {
            $('#su_error').html('');
            first_error = false;
        } else if (first.length == 0) {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                "<b> First Name is Mandatory</b>");
            first_error = true;
        } else {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                "<b> Invalid First Name</b>");
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
            if (last_ok) {
                $('#su_error').html('');
                last_error = false;
            } else if (last.length == 0) {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                    "<b> Last Name is Mandatory</b>");
                last_error = true;
            } else {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                    "<b> Invalid Last Name</b>");
                last_error = true;
            }
        // If there are no existing errors
        } else if (last_ok) {
            $('#su_error').html('');
            last_error = false;
        } else if (last.length == 0) {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                "<b> Last Name is Mandatory</b>");
            last_error = true;
        } else {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                "<b> Invalid Last Name</b>");
            last_error = true;
        }
    });

    // When Email Is Altered, check if it is in a valid format
    $('#su_email').bind("change keyup input", function() {
        email = $('#su_email').val().trim();
        
        if (regexEmail.test(email)) {
            // Valid Email
            email_ok = true;
            valid('#su_email');
        } else if (email.length == 0) {
            // No Entry - Unknown Validity
            email_ok = false;
            noValidity('#su_email');
        } else {
            // Invalid Email
            email_ok = false;
            invalid('#su_email');
        }
    });

    // When the user leaves the email form, if it is invalid produce an error message
    $('#su_email').blur(function() {
        // check if there are existing errors
        if (formErrors()) {
            if (email_ok) {
                $('#su_error').html('');
                email_error = false;
            } else if (email.length == 0) {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                    "<b> Email is Mandatory</b>");
                email_error = true;
            } else {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                    "<b> Invalid Email</b>");
                email_error = true;
            }
        // If there are no existing errors
        } else if (email_ok) {
            $('#su_error').html('');
            email_error = false;
        } else if (email.length == 0) {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                "<b> Email is Mandatory</b>");
            email_error = true;
        } else {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                "<b> Invalid Email</b>");
            email_error = true;
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
            if (password_ok) {
                $('#su_error').html('');
                password_error = false;
            } else if (password.length == 0) {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                    "<b> Password is Mandatory</b>");
                password_error = true;
            } else {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i><b>" + 
                    "Invalid Password (Must be 6 or More Characters)</b>");
                password_error = true;
            }
        // If there are no existing errors
        } else if (password_ok) {
            $('#su_error').html('');
            password_error = false;
        } else if (password.length == 0) {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                "<b> Password is Mandatory</b>");
            password_error = true;
        } else {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i><b>" +
                "Invalid Password (Must be 6 or More Characters)</b>");
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
            if (cpassword_ok) {
                $('#su_error').html('');
                cpassword_error = false;
            } else if (cpassword.length == 0) {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                    "<b> Confirm Password is Mandatory</b>");
                cpassword_error = true;
            } else {
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                    "<b> Passwords Must Match</b>");
                cpassword_error = true;
            }
        // If there are no existing errors
        } else if (cpassword_ok) {
            $('#su_error').html('');
            cpassword_error = false;
        } else if (cpassword.length == 0) {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" +
                "<b> Confirm Password is Mandatory</b>");
            cpassword_error = true;
        } else {
            $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                "<b> Passwords Must Match</b>");
            cpassword_error = true;
        }
    });

    // When Activation Code Is Altered, check if it is in a valid format
    $('#su_code').keyup(function() {
        code = $('#su_code').val().trim();
        
        if (code.length == 0) {
            // No Entry - Unknown Validity
            code_ok = false;
            noValidity('#su_code');
        } else {
            // Invalid First Name
            code_ok = true;
            valid('#su_code');
        }
    });
    
    // Try to Add a User and Make Them Pick Groups
    $('#su_submit').on('click', function() {
        
        // First make sure that the username is not already taken
        $.get('authenticate_username.php', {un : username}, function(response) {

            if (response !== 'match') {
                // Valid Username
                console.info("Valid Username Entered");
                username_ok = true;
                valid('#su_username');
                addUsers();

            } else if (username.length == 0) {
                // No Entry - Unknown Validity
                console.info("No Username Entered");
                username_ok = false;
                noValidity('#su_username');
                checkReady();

            } else {
                // Invalid Username
                console.info("INVALID Username Entered");
                username_ok = false;
                invalid('#su_username');
                checkReady();
            }
        });
    });
    
    // If all the values are submitted properly
    function checkReady() {
        if (username_ok && first_ok && last_ok && email_ok && password_ok && cpassword_ok && code_ok) {
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
        return (username_error || first_error || last_error || email_error 
            || password_error || cpassword_error || code_error);
    }

    function addUsers() {
        $.post('adduser.php', {userDetails : [username,first,last,email,password,code]}, function(response) {
            
            if (response == 'true') {
                console.info("Sign up Successful");

                // Set up local storage to maintain a signed in state beyond a session length
                if (localStorage) {
                    console.info("local storage is supported");
                    localStorage.setItem("username", username);
                }
                
                window.location = 'pickgroups.php';
            } else {
                console.error("Sign up Failed");
                code_ok = false;
                invalid('#su_code');
                $('#su_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                    "<b> Invalid Activation Code</b>");
                code_error = true;
                checkReady();
            }
        });
    }
    
});