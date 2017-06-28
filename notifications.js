/*
 * Author: Andrew Jarombek
 * Date: 6/17/2017
 * JavaScript for the notifications on the main page
 */

$(document).ready(function() {

	// Get the users notifications from the server
    $.get('getmaindetails.php', {getnotifications : true}, function(response) { 

        if (response !== 'false') { 
        	var notifications = JSON.parse(response);
        	console.info(notifications);
        	populateNotifications(notifications);
		} else {
			console.info("ERROR: Invalid Notifications Received");
		}
    });
});

function populateNotifications(notifications) {

	var notification_display = "";

	for (notification in notifications) {

		var notification_id = notifications[notification]['notification_id'];
		var notification_time = notifications[notification]['time'];
		var notification_link = notifications[notification]['link'];
		var notification_description = notifications[notification]['description'];
		var notification_viewed = notifications[notification]['viewed'];

		// Format the date and time for the message
        var date = Date.parse(notification_time);
        var formattedDate = date.toString('MMM dd, yyyy h:mm tt');

        var n_id = "notif_" + notification_id;
        var viewed_class = "";

        if (notification_viewed === "Y") {
        	viewed_class = " n_viewed";
        } else {
        	viewed_class = " n_notviewed";
        }

		$('#notifications').append("<div id='" + n_id + "' class='notification" + viewed_class + "'>" +
								"<a href=" + notification_link + "><p>" + formattedDate + "</p>" +
                                "<p>" + htmlEntities(notification_description) + "</p></a>" 
                                + "</div>" + notification_display);

		// Register a click listener to the previously appended notification
        $('#' + n_id + ' a').on("click", function() {

            // If the notification has not been viewed yet, change its viewed flag to 'Y'
            if ($(this).parent().hasClass('n_notviewed')) {
                var notif_id = $(this).parent().attr('id').substring(6);
                $.post('getmaindetails.php', {notificationseen : notif_id}, function(response) {
                    console.info("Notification Seen.");
                });
            }
        });
	}
}