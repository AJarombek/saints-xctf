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

            // Create the identifiers for HTML ids
            var message_id = "logid_" + newmessage["message_id"];
            var deletemessage_id = "deletemessageid_" + newmessage["message_id"];
            var deletemessage_ident = "#" + deletemessage_id;
            var message_ident = "#" + message_id;

            var message_date = String(newmessage["time"]);
            var message_first = String(newmessage["first"]);
            var message_last = String(newmessage["last"]);
            var message_username = String(newmessage["username"]);
            var message_content = String(newmessage["content"]);

            // Format the date and time for the message
            date = new Date(dateString);
            day = date.getDate();
            monthIndex = date.getMonth();
            year = date.getFullYear();
            var hours = date.getHours();
            var minutes = date.getMinutes();
            var tod;

            tod = ((hours / 12.0) > 1) ? 'PM' : 'AM';
            hours = (hours % 12);

            hours = (hours == 0) ? 12 : hours;

            if (String(minutes).length == 1)
                minutes = "0" + String(minutes);

            var formattedDate = monthNames[monthIndex] + ' ' + day + ' ' + year + ' ' + hours + ':' + minutes + tod;

            // Variable to determine if the log belongs to the signed in user
            var myMessage = (message_username == $('#session_username').val());

            // If this is the signed in users log, display the edit and delete options
            var editMessage;
            if (myMessage) {
                editMessage = "<div><p id='" + deletemessage_id + "'><i class='material-icons'>delete</i></p></div>";
            } else {
                editMessage = "<div></div>";
            }

            var fullname = message_first + " " + message_last;
            usernameDisplay = "<a class='loglink' href='profile.php?user=" + htmlEntities(message_username) + "'>" + htmlEntities(fullname) + "</a>";

            // display the new comment
            $('#messagefeed').prepend("<div id='" + message_id + "' class='message' class='feed'>" + usernameDisplay + editLog +
                                "<p>" + formattedDate + "</p>" +
                                "<p>" + htmlEntities(message_content) + "</p>" +
                                "</div>");
        } else {
            console.error("Added Message Failed.");
        }
    });
}