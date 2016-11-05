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
}