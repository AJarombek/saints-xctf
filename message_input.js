/*
 * Author: Andrew Jarombek
 * Date: 2/18/2017 - 2/20/2017
 * JavaScript for message input
 * Version 0.6 (GROUPS UPDATE) - 2/20/2017
 */

$(document).ready(function() {

    // Trigger event if the enter key is pressed when entering a message
    $('#new_message').keyup(function(e) {
        if (e.keyCode == 13) {
            var message_content = $(this).val().trim();

            if (message_content != "") {
                $(this).val('');
                submitMessage(message_content);
            }
        }
    });
});

// Submit and display a message after adding it to the database
function submitMessage(content) {    

    // Build an object of the message parameters
    var messageObject = new Object();
    messageObject.content = content;
    messageObject.group_name = sortparam;

    // Encode the array of message parameters
    var messageString = JSON.stringify(messageObject);

    $.post('messagedetails.php', {submitmessage : messageString}, function(response) {

        var newmessage = JSON.parse(response);
        console.info(newmessage);
        if (newmessage != 'false') {
            console.info("Populating new Message...");

            populateMessage(newmessage);

            // After successfully submitting the message, we want to send notifications to all the other group members
            var groupJSON = $('#group_data').val();
            var groupdata = JSON.parse(groupJSON);

            // Build a notification object to be sent to the other team members
            var notifyObject = new Object();
            notifyObject.link = window.location.href;
            notifyObject.viewed = "N";
            notifyObject.description = newmessage['first'] + " " + newmessage['last'] + " Sent a Message in " + groupdata['group_title'];

            var members = groupdata['members'];

            // Go through each group member
            for (member in members) {

                // Only send the message if the member has been accepted
                if (groupdata['members'][member]['status'] === "accepted") {

                    notifyObject.username = groupdata['members'][member]['username'];
                    var notifyString = JSON.stringify(notifyObject);

                    // Asynchronous call to send the notification to the API
                    $.post('messagedetails.php', {notifyofmessage : notifyString}, function(response) {

                        var notification = JSON.parse(response);
                        if (notification != 'false') {
                            console.info("Message Notification Sent!");
                        } else {
                            console.error("Failed to Send Message Notification");
                        }
                    });
                }
            }

        } else {
            console.error("Added Message Failed.");
        }
    });
}