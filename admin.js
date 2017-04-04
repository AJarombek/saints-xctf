/*
 * Author: Andrew Jarombek
 * Date: 4/3/2017
 * JavaScript for interacting with the admin panel
 */

$(document).ready(function() {

    var groupadminJSON = $('#group_data').val();
    var groupadmindata = JSON.parse(groupadminJSON);

    // Populate the pending users

    var members = groupadmindata['members'];
    var groupname = groupadmindata['group_name'];
    console.info(members);
    
    for (member in members) {
        var username = members[member]['username'];
        var first = members[member]['first'];
        var last = members[member]['last'];

        if (members[member]['status'] == 'pending') {
            console.info("pending user: " + first + " " + last);
            pendingUser(username, first, last, groupname);
        
        } else {
            // Add them to the flair dropdown
            $('#flair_username').append(
                '<option value=' + first + ' ' + last + '>' + first + ' ' + last + '</option>');
        }
    }

    // Handle the email send requests

    var regexEmail = new RegExp("^(([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+)?$");
    var email_ok;

    // When Email Is Altered, check if it is in a valid format
    $('#email_input').bind("change keyup input", function() {
        email = $(this).val().trim();
        
        if (email.length == 0 || !regexEmail.test(email)) {
            // No Entry - Invalid
            email_ok = false;
            $(this).addClass('invalid');
            $('#send_email').removeClass('emailvalid');
            $('#send_email').attr('disabled','true');
        } else {
            // Valid Password
            email_ok = true;
            $(this).removeClass('invalid');
            $('#send_email').addClass('emailvalid');
            $('#send_email').removeAttr('disabled');
        }
    });

    // Handle giving flair
});

function pendingUser(username, first, last, groupname) {

    var addusersId = username;
    var rejectId = 'reject_user' + username;
    var acceptId = 'accept_user' + username;

    $('#addusers').append("<div id='" + addusersId + "'><h5>" + first + " " + last + "</h5>" + 
        "<input id='" + acceptId + "' class='submit adduserbutton' type='button' value='Accept'>" + 
        "<input id='" + rejectId + "' class='submit removeuserbutton' type='button' value='Reject'></div>");

    // Accept the user onto the team
    $('#' + acceptId).on('click', function() {
        
        var un = $(this).parent().attr('id');

        $.get('groupdetails.php', {accept_user : [un, groupname]}, function(response) {

            if (response === 'true') {
                console.info("User Accepted");
            } else {
                console.info("User Accept FAILED");
            }
        });
    });

    // Deny the users request onto the team
    $('#' + rejectId).on('click', function() {
        
        var un = $(this).parent().attr('id');

        $.get('groupdetails.php', {reject_user : [un, groupname]}, function(response) {

            if (response === 'true') {
                console.info("User Rejected");
            } else {
                console.info("User Reject FAILED");
            }
        });
    });
}