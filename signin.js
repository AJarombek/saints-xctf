/*
 * Author: Andrew Jarombek
 * Date: 5/31/2016 - 6/2/2017
 * JavaScript for the signin form
 * Version 0.4 (BETA) - 12/24/2016
 * Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

$(document).ready(function() {
    
    var username, password;
    var username_ok = false;
    var password_ok = false;
    
    // Check if the username is filled in
    $('#si_username').on('keyup', function() {
        username = $('#si_username').val().trim();
        username_ok = (username.length > 0);
        ready();
    });
    
    // Check if the password is filled in
    $('#si_password').on('keyup', function() {
        password = $('#si_password').val().trim();
        password_ok = (password.length > 0);
        ready();
    });
    
    // Try to sign in
    $('#si_submit').on('click', function(event) {
        $('body').addClass('waiting');
        signIn();
    });

    // Click on Forgot Password
    $('#si_forgot_password').on('click', function(event) {
        window.location = "forgotpassword.php";
    });

    // Trigger event to sign in if the enter key is pressed when entering the password
    $('#si_password').keyup(function(e) {
        if (e.keyCode == 13) {
            $('body').addClass('waiting');
            signIn();
        }
    });
    
    // Check if the signin form is ready to submit 
    function ready() {
        if (username_ok && password_ok) {
            $('#si_submit').removeAttr('disabled');
        } else {
            $('#si_submit').attr('disabled', 'true');
        }
    }

    // Function to try and sign the user in
    function signIn() {
        $.get('signin.php', {cred : [username, password]}, function(response) {
            if (response === 'true') {

                // Set up local storage to maintain a signed in state beyond a session length
                if (localStorage) {
                    console.info("local storage is supported");
                    localStorage.setItem("username", username);
                }

                window.location = 'index.php';
                $('body').removeClass('waiting');
            } else {
                $('body').removeClass('waiting');
                // Produce error, clear password form, and disable sign in button
                $('#si_error').html('').append("<i class='material-icons md-18 error'>error</i><b> Invalid Username/Password</b>");
                $('#si_password').val('');
                $('#si_submit').attr('disabled', 'true');
            }
        });
    }
});