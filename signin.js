/*
 * Author: Andrew Jarombek
 * Date: 5/31/2016 - 
 * JavaScript for the signin form
 */

$(document).ready(function() {
    
    var username, password;
    var username_ok = false;
    var password_ok = false;
    
    // Check if the username is filled in
    $('#si_username').on('keyup', function() {
        username = $('#si_username').val.trim();
        username_ok = (username.length > 0);
        ready();
    });
    
    // Check if the password is filled in
    $('#si_password').on('keyup', function() {
        password = $('#si_password').val.trim();
        password_ok = (password.length > 0);
        ready();
    });
    
    $('#si_submit').on('click', function(event) {
        
    });
    
    // Check if the signin form is ready to submit 
    function ready() {
        if (username_ok && password_ok) {
            $('#si_submit').removeAttr('disabled');
        } else {
            $('#si_submit').attr('disabled', 'true');
        }
    }
});