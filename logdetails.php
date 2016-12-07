<?php

// Author: Andrew Jarombek
// Date: 11/5/2016 - 
// Controller for Getting the details necessary for running log feeds

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

	require_once('models/logclient.php');
	require_once('controller_utils.php');

	$submitlog = $_GET['submitlog'];
	$log = json_decode($submitlog, true);

	// We have to add miles to the log
	$metric = $log['metric'];
	$distance = $log['distance'];

	$miles = ControllerUtils::convertToMiles($distance, $metric);
	$log['miles'] = $miles;

	error_log($LOG_TAG . "The Submitted Log: " . print_r($log, true));

	$logJSON = json_encode($log);

    $logclient = new LogClient();

    $logJSON = $userclient->post($logJSON);
    $logobject = json_decode($logJSON, true);
    error_log($LOG_TAG . "The New Log Received: " . print_r($logobject, true));

    if ($logobject != null && $logobject == $log) {

    } else {

    }
    exit();
}