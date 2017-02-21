<?php

// Author: Andrew Jarombek
// Date: 11/5/2016 - 2/20/2017
// Controller for Getting the details necessary for running log feeds
// Version 0.4 (BETA) - 12/24/2016
// Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
// Version 0.6 (GROUPS UPDATE) - 2/20/2017

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

	session_start();

	require_once('models/commentclient.php');

	$submitcomment = $_POST['submitcomment'];
	$comment = json_decode($submitcomment, true);

	$comment['username'] = $_SESSION['username'];
	$comment['first'] = $_SESSION['first'];
	$comment['last'] = $_SESSION['last'];

	error_log($LOG_TAG . "The Submitted Comment: " . print_r($comment, true));
	$commentJSON = json_encode($comment);

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

} else if (isset($_POST['deleteid'])) {
	session_start();

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