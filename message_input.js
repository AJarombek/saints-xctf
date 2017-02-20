/*
 * Author: Andrew Jarombek
 * Date: 2/18/2017
 * JavaScript for message input
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
        } else {
            console.error("Added Message Failed.");
        }
    });
}