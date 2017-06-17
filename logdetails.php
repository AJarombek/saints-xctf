<?php

// Author: Andrew Jarombek
// Date: 11/5/2016 - 6/2/2017
// Controller for Getting the details necessary for running log feeds
// Version 0.4 (BETA) - 12/24/2016
// Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

$LOG_TAG = "[WEB](logdetails.php): ";

if (isset($_GET['getlogs'])) {

	$getlogs = $_GET['getlogs'];
	
	// loginfo is an array => [paramtype, sortparam, limit, offset]
	$loginfo = json_decode($getlogs, true);

	error_log($LOG_TAG . "Log Feed Parameters: " . print_r($loginfo, true));

	require_once('models/logfeedclient.php');

    $logfeedclient = new LogFeedClient();
    $logFeedJSON = $logfeedclient->get($loginfo);
    
    error_log($LOG_TAG . "The LogFeed from the API: " . $logFeedJSON);

	echo $logFeedJSON;
	exit();

} else if (isset($_POST['submitlog'])) {

	session_start();

	// Manual Session Timeout Handling
	require_once('session_utils.php');
	SessionUtils::lastActivityTime();
	SessionUtils::createdTime();

	require_once('models/logclient.php');
	require_once('models/userclient.php');
	require_once('controller_utils.php');

	$submitlog = $_POST['submitlog'];
	$log = json_decode($submitlog, true);

	// We have to add miles to the log
	$metric = $log['metric'];
	$distance = $log['distance'];

	$miles = ControllerUtils::convertToMiles($distance, $metric);
	$log['miles'] = $miles;

	// We now have to get the mile pace with miles and time
	$pace = ControllerUtils::milePace($miles, $log['time']);
	$log['pace'] = $pace;

	$log['username'] = $_SESSION['username'];
	$log['first'] = $_SESSION['first'];
	$log['last'] = $_SESSION['last'];

	error_log($LOG_TAG . "The Submitted Log: " . print_r($log, true));

	$logJSON = json_encode($log);

    $logclient = new LogClient();

    $logJSON = $logclient->post($logJSON);
    $logobject = json_decode($logJSON, true);
    error_log($LOG_TAG . "The New Log Received: " . print_r($logobject, true));

    if ($logobject != null) {
    	// We want to reload user statistics when a log is uploaded
    	$userclient = new UserClient();
	    $userJSON = $userclient->get($_SESSION['username']);
	    $userobject = json_decode($userJSON, true);
	    $_SESSION['user'] = $userobject;

    	error_log($LOG_TAG . "The Log was Successfully Uploaded.");
    	echo $logJSON;
    } else {
    	error_log($LOG_TAG . "The Log was UNSUCCESSFULLY Uploaded.");
    	echo 'false';
    }
    exit();
    
} else if (isset($_POST['submitcomment'])) {

	// Submit a comment to the database.  
	// Also we much create a new notification for the user of the log

	session_start();

	// Manual Session Timeout Handling
	require_once('session_utils.php');
	SessionUtils::lastActivityTime();
	SessionUtils::createdTime();

	require_once('models/commentclient.php');

	$submitcomment = $_POST['submitcomment'];
	$comment = json_decode($submitcomment, true);

	$comment['username'] = $_SESSION['username'];
	$comment['first'] = $_SESSION['first'];
	$comment['last'] = $_SESSION['last'];

	error_log($LOG_TAG . "The Submitted Comment: " . print_r($comment, true));
	$commentJSON = json_encode($comment);

	// create a POST request for the new comment
	$commentclient = new CommentClient();
	$commentJSON = $commentclient->post($commentJSON);
    $commentobject = json_decode($commentJSON, true);
    error_log($LOG_TAG . "The New Comment Received: " . print_r($commentobject, true));

    if ($commentobject != null) {
    	error_log($LOG_TAG . "The Comment was Successfully Uploaded.");
    	echo $commentJSON;
    } else {
    	error_log($LOG_TAG . "The Comment was UNSUCCESSFULLY Uploaded.");
    	echo 'false';
    }
    exit();

} else if (isset($_POST['notifyofcomment'])) {

	session_start();

	// Manual Session Timeout Handling
	require_once('session_utils.php');
	SessionUtils::lastActivityTime();
	SessionUtils::createdTime();

	require_once('models/notificationclient.php');

	$notification = json_decode($_POST['notifyofcomment'], true);

	// Only send the notification if the comment is on another users log
	if ($notification['username'] !== $_SESSION['username']) {

		$notificationJSON = json_encode($notification);
		$notificationclient = new NotificationClient();

		$notificationJSON = $notificationclient->post($notificationJSON);
		$notificationobject = json_decode($notificationJSON, true);
		error_log($LOG_TAG . "Th New Notification Received: " . print_r($notificationobject, true));

		if ($notificationobject != null) {
	    	error_log($LOG_TAG . "The Notification was Successfully Uploaded.");
	    	echo 'true';
	    } else {
	    	error_log($LOG_TAG . "The Notification was UNSUCCESSFULLY Uploaded.");
	    	echo 'false';
	    }
	} else {
		error_log($LOG_TAG . "No Notification Sent, Usernames Match.");
		echo 'false';
	}

	exit();

} else if (isset($_POST['deleteid'])) {
	session_start();

	// Manual Session Timeout Handling
	require_once('session_utils.php');
	SessionUtils::lastActivityTime();
	SessionUtils::createdTime();

	require_once('models/logclient.php');

	$logid = $_POST['deleteid'];
	$logclient = new LogClient();

    $response = $logclient->delete($logid);
    error_log($LOG_TAG . "The Delete Log Response: " . $response);
    if ($response == "1") {
    	echo "true";
    } else {
    	echo "false";
    }
    exit();
}