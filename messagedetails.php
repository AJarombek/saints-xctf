<?php

// Author: Andrew Jarombek
// Date: 2/18/2017 - 6/2/2017
// Controller for Getting the details necessary for the group messages
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

$LOG_TAG = "[WEB](messagedetails.php): ";

require_once('models/messageclient.php');
require_once('models/messagefeedclient.php');

// If a new message is being submitted, send it to the API
if (isset($_POST['submitmessage'])) {
	session_start();

    // Manual Session Timeout Handling
    require_once('session_utils.php');
    SessionUtils::lastActivityTime();
    SessionUtils::createdTime();

    $messageJSON = $_POST['submitmessage'];

    $messageobject = json_decode($messageJSON, true);
    error_log($LOG_TAG . "Message Received: " . print_r($messageobject, true));

    $messageobject['username'] = $_SESSION['username'];
    $messageobject['first'] = $_SESSION['first'];
    $messageobject['last'] = $_SESSION['last'];
    $messageJSON = json_encode($messageobject);

	$messageclient = new MessageClient();

    $messageJSON = $messageclient->post($messageJSON);

	echo $messageJSON;
	exit();

} else if (isset($_GET['getmessages'])) {
    session_start();

    // Manual Session Timeout Handling
    require_once('session_utils.php');
    SessionUtils::lastActivityTime();
    SessionUtils::createdTime();

    $getmessages = $_GET['getmessages'];

    // loginfo is an array => [paramtype, sortparam, limit, offset]
    $messageinfo = json_decode($getmessages, true);

    error_log($LOG_TAG . "Message Feed Parameters: " . print_r($messageinfo, true));

    $messagefeedclient = new MessageFeedClient();
    $messageFeedJSON = $messagefeedclient->get($messageinfo);

    error_log($LOG_TAG . "The MessageFeed from the API: " . $messageFeedJSON);

    echo $messageFeedJSON;
    exit();

} else if (isset($_POST['deletemessage'])) {
    session_start();

    // Manual Session Timeout Handling
    require_once('session_utils.php');
    SessionUtils::lastActivityTime();
    SessionUtils::createdTime();

    $messageid = $_POST['deletemessage'];
    $messageclient = new MessageClient();

    $response = $messageclient->delete($messageid);
    error_log($LOG_TAG . "The Delete Message Response: " . $response);
    if ($response == "1") {
        echo "true";
    } else {
        echo "false";
    }
    exit();
}
