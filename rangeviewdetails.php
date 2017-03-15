<?php

// Author: Andrew Jarombek
// Date: 3/14/2017
// Controller for getting the necessary range views

$LOG_TAG = "[WEB](rangeviewdetails.php): ";

if (isset($_GET['getRangeView'])) {

	$getRangeView = $_GET['getRangeView'];
	
	// loginfo is an array => [paramtype, sortparam, start, end]
	$rangeview = json_decode($getRangeView, true);

	error_log($LOG_TAG . "Range View Parameters: " . print_r($rangeview, true));

	require_once('models/rangeviewclient.php');

    $rangeviewclient = new RangeViewClient();
    $rangeViewJSON = $rangeviewclient->get($rangeview);
    
    error_log($LOG_TAG . "The LogFeed from the API: " . $rangeViewJSON);

	echo $rangeViewJSON;
	exit();
}