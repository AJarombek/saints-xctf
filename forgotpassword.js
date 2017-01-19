/*
 * Author: Andrew Jarombek
 * Date: 1/11/2017 - 1/18/2017
 * JavaScript for the signup form
 * Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
 */

$(document).ready(function() {
                
    var email, password, cpassword, code;
    
    var email_ok = false;
    var password_ok = false;
    var cpassword_ok = false;
    var code_ok = false;
    var email_error = false;
    var password_error = false;
    var cpassword_error = false;
    var code_error = false;

    var regexEmail = new RegExp("^(([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+)?$");

    // When Email Is Altered, check if it is in a valid format
    $('#fpw_email').keyup(function() {
        email = $(this).val().trim();
        
        if (email.length == 0 || !regexEmail.test(email)) {
            // No Entry - Invalid
            email_ok = false;
            invalid('#fpw_email');
        } else {
            // Valid Password
            email_ok = true;
            noValidity('#fpw_email');
        }
        checkFirstReady();
    });
    
    // When Password Is Altered, check if it is in a valid format
    $('#fpw_password').keyup(function() {
        password = $(this).val().trim();
        
        if (password.length > 5) {
            // Valid Password
            password_ok = true;
            password_error = false;
            noValidity('#fpw_password');
            
            // check if it matches the confirmed password
            if (password == cpassword) {
                cpassword_ok = true;
                cpassword_error = false;
                noValidity('#fpw_cpassword');
            }
            
        } else if (password.length == 0) {
            // No Entry - Unknown Validity
            password_ok = false;
            password_error = true;
            noValidity('#fpw_password');
        } else {
            // Invalid Password
            password_ok = false;
            password_error = true;
            invalid('#fpw_password');
        }

        checkSecondReady();
    });

    // When the user leaves the password form, if it is invalid produce an error message
    $('#fpw_password').blur(function() {
        // check if there are existing errors
        if (password_ok || password.length == 0) {
            $('#fpw_error').html('');
            password_error = false;
        } else {
            $('#fpw_error').html('').append("<i class='material-icons md-18 error'>error</i><b>" +
                "Invalid Password (Must be 6 or More Characters)</b>");
            password_error = true;
        }

        checkSecondReady();
    });
    
    // When Confirm Password Is Altered, check if it is in a valid format
    $('#fpw_cpassword').keyup(function() {
        cpassword = $(this).val().trim();
        
        if (cpassword.length > 5 && password == cpassword) {
            // Valid Confirmed Password
            cpassword_ok = true;
            cpassword_error = false;
            noValidity('#fpw_cpassword');
        } else if (cpassword.length == 0) {
            // No Entry - Unknown Validity
            cpassword_ok = false;
            cpassword_error = true;
            noValidity('#fpw_cpassword');
        } else {
            // Invalid Confirmed Password
            c_password_ok = false;
            cpassword_error = true;
            invalid('#fpw_cpassword');
        }

        checkSecondReady();
    });

    // When the user leaves the cpassword form, if it is invalid produce an error message
    $('#fpw_cpassword').blur(function() {
        // check if there are existing errors
        if (cpassword_ok || cpassword.length == 0) {
            $('#fpw_error').html('');
        } else {
            $('#fpw_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                "<b> Passwords Must Match</b>");
        }

        checkSecondReady();
    });

    // When Activation Code Is Altered, check if it is in a valid format
    $('#fpw_code').keyup(function() {
        code = $(this).val().trim();
        
        if (code.length == 0) {
            // No Entry - Unknown Validity
            code_ok = false;
            noValidity('#fpw_code');
        } else {
            // Potential Valid code
            code_ok = true;
            noValidity('#fpw_code');
        }

        checkSecondReady();
    });
    
    // If the email is in the database, send an email to that user
    $('#fpw_submit_email').on('click', function() {
        
        $.get('resetpassword.php', {email_request : email}, function(response) {

            if (response === 'true' || true) {
                // Valid Email, Move to Step Two
                console.info("Valid Email Entered");
                $('.first_verify').css('display', 'none');
                $('.second_verify').css('display', 'inline');
                $('#cnpw').css('display', 'block');
            } else {
                // Invalid Username
                console.info("INVALID Email Entered");
                email_ok = false;
                invalid('#fpw_email');
                $('#fpw_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                "<b> Invalid Email Entered</b>");
            }
        });
    });

    // If the email is in the database, send an email to that user
    $('#fpw_submit_new_password').on('click', function() {
        
        $.get('resetpassword.php', {new_password : [password,code]}, function(response) {

            if (response === 'true') {
                // Valid Email, Move to Step Two
                console.info("Password Reset");
                $('.second_verify').css('display', 'none');
                $('.third_verify').css('display', 'inline');
                $('#pwchng').css('display', 'block');
                successTransition();
            } else {
                // Invalid Username
                console.info("Password Reset FAILED");
                code_ok = false;
                invalid('#fpw_code');
                $('#fpw_error').html('').append("<i class='material-icons md-18 error'>error</i>" + 
                "<b> Invalid Code Entered</b>");
            }
        });
    });
    
    // If all the values are submitted properly
    function checkFirstReady() {
        if (email_ok) {
            $('#fpw_submit_email').removeAttr('disabled');
            $('#fpw_submit_email').css('border-color', 'black');
        } else {
            $('#fpw_submit_email').attr('disabled','true');
            $('#fpw_submit_email').css('border-color', '#999');
        }
    }

    // If all the values are submitted properly
    function checkSecondReady() {
        if (password_ok && cpassword_ok && code_ok) {
            $('#fpw_submit_new_password').removeAttr('disabled');
            $('#fpw_submit_new_password').css('border-color', 'black');
        } else {
            $('#fpw_submit_new_password').attr('disabled','true');
            $('#fpw_submit_new_password').css('border-color', '#999');
        }
    }
    
    // Change CSS if input is invalid and check if entire form is ready
    function invalid(selector) {
        $(selector).addClass('invalid');
    }
    
    // Change CSS if input validity is unknown (empty input form) and check if entire form is ready
    function noValidity(selector) {
        $(selector).removeClass('invalid');
    }

    // Return whether any of the forms have produced errors
    function formErrors() {
        return (email_error || password_error || cpassword_error || code_error);
    }

    // Function for transitioning back to the home page after the password has been successfully changed
    function successTransition() {
        $('body').addClass('waiting');
        setTimeout(function() {
            window.location = 'index.php';
            $('body').removeClass('waiting');
        }, 2300);
    }
    
});