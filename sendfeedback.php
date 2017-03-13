<?php

// Author: Andrew Jarombek
// Date: 12/21/2016 - 12/24/2016
// Controller for Sending a feedback via email
// Version 0.4 (BETA) - 12/24/2016

$LOG_TAG = "[WEB](sendfeedback.php): ";

require_once('controller_utils.php');

if (isset($_GET['submitfeedback'])) {

    session_start();

    // Manual Session Timeout Handling
    require_once('session_utils.php');
    SessionUtils::lastActivityTime();
    SessionUtils::createdTime();

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to send feedback.");
    $name = $_SESSION['first'] . ' ' . $_SESSION['last'];
    $feedbackobject = json_decode($_GET['submitfeedback'], true);
    $content = $feedbackobject['title'] . "\n\n" . $feedbackobject['content'];
    error_log($LOG_TAG . "Name: " . $name);
    error_log($LOG_TAG . "Content: " . $content);
    ControllerUtils::sendFeedback($name, $content);
    echo 'true';
    exit();
}
