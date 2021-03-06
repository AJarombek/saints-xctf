/*
 * Author: Andrew Jarombek
 * Date: 4/3/2017 - 6/2/2017
 * JavaScript for interacting with the admin panel
 * Version 1.0 (OFFICIAL RELEASE) - 6/2/2017
 */

$(document).ready(function() {

    var groupadminJSON = $('#group_data').val();
    var groupadmindata = JSON.parse(groupadminJSON);

    // Populate the pending users

    var members = groupadmindata['members'];
    var groupname = groupadmindata['group_name'];
    var grouptitle = groupadmindata['group_title'];
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
                '<option id="fl_' + username + '" value=' + first + ' ' + last + '>' + first + ' ' + last + '</option>');
        }
    }

    // Handle the email send requests

    var regexEmail = new RegExp("^(([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+)?$");
    var email, email_ok;

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

    $('#send_email').on('click', function() {

        $.get('groupdetails.php', {send_email : email}, function(response) {

            if (response === 'true') {
                console.info("Email Sent");
                $('#email_input').val('');
            } else {
                console.info("Email FAILED");
            }
        });
    });

    // Handle giving flair

    var flair, flair_ok;

    // When Flair Is Altered, check if it is in a valid format
    $('#flair_input').bind("change keyup input", function() {
        flair = $(this).val().trim();
        
        if (flair.length == 0) {
            // No Entry - Invalid
            flair_ok = false;
            $('#give_flair').removeClass('emailvalid');
            $('#give_flair').attr('disabled','true');
        } else {
            // Valid Flair
            flair_ok = true;
            $('#give_flair').addClass('emailvalid');
            $('#give_flair').removeAttr('disabled');
        }
    });

    $('#give_flair').on('click', function() {

        var username = $('#flair_username').children(":selected").attr("id");
        username = username.substring(3, username.length);

        $.get('groupdetails.php', {give_flair : [username, flair]}, function(response) {

            if (response === 'true') {
                console.info("Flair Given");
                $('#flair_input').val('');
            } else {
                console.info("Flair Gift FAILED");
            }
        });
    });

    var notification, notification_ok;

    // When Notification Is Altered, check if it contains data
    $('#notification_input').bind("change keyup input", function() {
        notification = $(this).val().trim();
        
        if (notification.length == 0) {
            // No Entry - Invalid
            notification_ok = false;
            $(this).addClass('invalid');
            $('#send_notification').removeClass('notificationvalid');
            $('#send_notification').attr('disabled','true');
        } else {
            // Valid Notification
            notification_ok = true;
            $(this).removeClass('invalid');
            $('#send_notification').addClass('notificationvalid');
            $('#send_notification').removeAttr('disabled');
        }
    });

    $('#send_notification').on('click', function() {

        // Build a notification object to be sent to all the accepted group members
        var notifyObject = new Object();
        
        notifyObject.link = window.location.href;
        notifyObject.viewed = "N";
        notifyObject.description = "A Message From " + grouptitle + ": \n" + notification;

        for (member in members) {
            if (members[member]['status'] == 'accepted') { 

                notifyObject.username = members[member]['username'];

                var notifyString = JSON.stringify(notifyObject);

                $.post('groupdetails.php', {send_notification : notifyString}, function(response) {

                    if (response === 'true') {
                        console.info("Notification Sent");
                    } else {
                        console.info("Notification FAILED");
                    }
                });
            }
        }

        $('#notification_input').val('');
    });
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
                $('#' + un).remove();
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
                $('#' + un).remove();
            } else {
                console.info("User Reject FAILED");
            }
        });
    });
}