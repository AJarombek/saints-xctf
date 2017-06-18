/*
 * Author: Andrew Jarombek
 * Date: 6/17/2017
 * JavaScript for the notifications on the main page
 */

$(document).ready(function() {

	// Get the users notifications from the server
    $.get('getmaindetails.php', {getnotifications : true}, function(response) {

        var notifications = JSON.parse(response);
        console.info(notifications);
        populateNotifications(notifications);
    });
});

function populateNotifications(notifications) {

	var notification_display = "";

	for (notification in notifications) {

		var notification_id = notifications[notification]['notification_id'];
		var notification_time = notifications[notification]['time'];
		var notification_link = notifications[notification]['link'];
		var notification_description = notifications[notification]['description'];

		// Format the date and time for the message
        var date = Date.parse(notification_time);
        var formattedDate = date.toString('MMM dd, yyyy h:mm tt');

		notification_display += "<div id='notif_" + notification_id + "' class='notification'>" +
								"<p>" + formattedDate + "</p>" +
                                "<p>" + htmlEntities(message_content) + "</p>" + "</div>";
	}

	$('#notifications').append(notification_display);
}