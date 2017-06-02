<?php

// Author: Andrew Jarombek
// Date: 5/28/2016 - 6/2/2017
// Controller for Authenticating a unique Username
// Version 0.4 (BETA) - 12/24/2016
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

if (isset($_GET['un'])) {

    $LOG_TAG = "[WEB](authenticate_username.php): ";

    $username = $_GET['un'];
        
    require_once('models/userclient.php');
    $userclient = new UserClient();
    $userJSON = $userclient->get($username);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Potential Matching User Is: " . print_r($userJSON, true));

    // Reply to the AJAX request with either the username exists or not
    // First check to see if the response is valid
    if ($userobject != null) {
        // Finally check if the usernames match
        if ($userobject['username'] === $username) {
            error_log($LOG_TAG . "There is a Matching Username: " . $username);
            echo 'match';
        } else {
            error_log($LOG_TAG . "There is NO Matching Username, Valid Entry");
            echo 'false';
        }
    } else {
        error_log($LOG_TAG . "There is NO Matching Username, Valid Entry");
        echo 'false';
    }

    exit();
}