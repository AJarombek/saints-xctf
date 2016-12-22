<?php

// Author: Andrew Jarombek
// Date: 12/21/2016 - 
// Controller for Sending a feedback via email

$LOG_TAG = "[WEB](sendfeedback.php): ";

require_once('controller_utils.php');

if (isset($_GET['submitfeedback'])) {

    session_start();

    // Reply to the AJAX call with the user object
    error_log($LOG_TAG . "AJAX request to send feedback.");
    $name = $_SESSION['first'] + ' ' + $_SESSION['last'];
    $feedbackobject = json_decode($_GET['submitfeedback'], true);
    $content = $feedbackobject['title'] + "\n\n" + $feedbackobject['content'];
    ControllerUtils::sendFeedback($name, $content);
    echo 'true';
    exit();
}
