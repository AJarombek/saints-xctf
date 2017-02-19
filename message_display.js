/*
 * Author: Andrew Jarombek
 * Date: 2/18/2017
 * JavaScript for displaying messages on profile pages, group pages, or the main page
 */

$(document).ready(function() {

    var messageloc = null;

    getMessageFeed(paramtype, sortparam, limit, offset);

    function getMessageFeed(paramtype, sortparam, limit, offset) {

        // Build an object of the logfeed parameters
        var params = new Object();
        params.paramtype = paramtype;
        params.sortparam = sortparam;
        params.limit = limit;
        params.offset = offset;

        // Encode the array of logfeed parameters
        var paramString = JSON.stringify(params);

        $.get('messagedetails.php', {getmessages : paramString}, function(response) {

            var messagefeed = JSON.parse(response);
            console.info(messagefeed);
            if (messagefeed.length > 0) {
                console.info("Populating the MessageFeed...");
                populate(messagefeed, messageloc);
            } else {
                console.info("No messages to display.");
                $('#messagefeed').html('').append("<p class='nofeed'><i>No Activity</i></p>");
            }
        });
    }

    // Populate all the messages from a message feed
    function populate(messagefeed, messageloc) {
        message_count = 0;

        // Go through each message in the feed
        messagefeed.reverse();
        for (message in messagefeed) {
            console.info(message);
            message_count++;

            // Create the identifiers for HTML ids
            var message_id = "logid_" + messagefeed[message]["message_id"];
            var deletemessage_id = "deletemessageid_" + messagefeed[message]["message_id"];
            var deletemessage_ident = "#" + deletemessage_id;
            var message_ident = "#" + message_id;

            var message_date = String(messagefeed[message]["time"]);
            var message_first = String(messagefeed[message]["first"]);
            var message_last = String(messagefeed[message]["last"]);
            var message_username = String(messagefeed[message]["username"]);
            var message_content = String(messagefeed[message]["content"]);

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

            // Decide whether to append the log or insert it at the beginning
            if (messageloc == null) {

                $('#messagefeed').append("<div id='" + message_id + "' class='message' class='feed'>" + usernameDisplay + editLog +
                                "<p>" + formattedDate + "</p>" +
                                "<p>" + htmlEntities(message_content) + "</p>" +
                                "</div>");

            } else {

                $("<div id='" + message_id + "' class='message' class='feed'>" + usernameDisplay + editLog +
                                "<p>" + formattedDate + "</p>" +
                                "<p>" + htmlEntities(message_content) + "</p>" +
                                "</div>").insertBefore(messageloc);
            }

            messageloc = message_ident;

            // Show the editMessage items when you hover on the logs
            $(message_ident).hover(function() {
                var messageid = $(this).attr('id');
                $('#' + messageid + " div:nth-child(2) p").css('display', 'block');

                $('#' + messageid).css('border-color', '#555');
            });

            // Hide the editMessage items when you stop hovering
            $(message_ident).mouseleave(function() {
                var messageid = $(this).attr('id');
                $('#' + messageid + " div:nth-child(2) p").css('display', 'none');

                $('#' + messageid).css('border-color', '#888');
            });

            // Click listener for deleting a message
            $(deletemessage_ident).on("click", function() {
                var deleteid = $(this).attr('id');
                deleteid = deleteid.substring(12, deleteid.length);
                deleteMessage(deleteid);
            });
        }

        // If there are (probably) more messages to load from the database, add a button to load more
        if (message_count == 10) {
            messageloc = '#load_more_messages';
            var loadMessages = $("<input id='load_more_messages' class='submit' type='button' name='load_more' value='Load More'>");
            $('#messagefeed').append(loadLogs);

            $('#load_more_messages').on("click", function() {
                $('#load_more_messages').remove();
                offset = offset + 10;
                getMessageFeed(paramtype, sortparam, limit, offset);
            });
        }
        
    }
});

// Populate a message when given a message object
function populateMessage(messageobject) {

    // Create the identifiers for HTML ids
    var message_id = "logid_" + messageobject["message_id"];
    var deletemessage_id = "deletemessageid_" + messageobject["message_id"];
    var deletemessage_ident = "#" + deletemessage_id;
    var message_ident = "#" + message_id;

    var message_date = String(messageobject["time"]);
    var message_first = String(messageobject["first"]);
    var message_last = String(messageobject["last"]);
    var message_username = String(messageobject["username"]);
    var message_content = String(messageobject["content"]);

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

    $('#messagefeed').prepend("<div id='" + message_id + "' class='message' class='feed'>" + usernameDisplay + editLog +
                        "<p>" + formattedDate + "</p>" +
                        "<p>" + htmlEntities(message_content) + "</p>" +
                        "</div>");

    // Show the editMessage items when you hover on the logs
    $(message_ident).hover(function() {
        var messageid = $(this).attr('id');
        $('#' + messageid + " div:nth-child(2) p").css('display', 'block');

        $('#' + messageid).css('border-color', '#555');
    });

    // Hide the editMessage items when you stop hovering
    $(message_ident).mouseleave(function() {
        var messageid = $(this).attr('id');
        $('#' + messageid + " div:nth-child(2) p").css('display', 'none');

        $('#' + messageid).css('border-color', '#888');
    });

    // Click listener for deleting a message
    $(deletemessage_ident).on("click", function() {
        var deleteid = $(this).attr('id');
        deleteid = deleteid.substring(12, deleteid.length);
        deleteMessage(deleteid);
    });
}

// Remove a message from the database and view
function deleteMessage(id) {
    $.post('messagedetails.php', {deletemessage : id}, function(response) {
        if (response == 'true') {
            console.info("Delete Message Success");
            $("#messageid_" + id).remove();
        } else {
            console.info("Delete Message FAILED!");
        }
    });
}