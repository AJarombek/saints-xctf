<?php

// Author: Andrew Jarombek
// Date: 5/28/2016 - 
// Controller for Authenticating a unique Username

session_start();

if (isset($_GET['un'])) {

    $LOG_TAG = "[WEB](authenticate_username.php): ";

    $username = $_GET['un'];
        
    require_once('models/userclient.php');
    $userclient = new UserClient();
    $userJSON = $userclient->get($username);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Potential Matching User Is: " . print_r($userobject, true));

    // Reply to the AJAX request with either the username exists or not
    // First check to see if the response is valid
    if ($userobject != null) {
        // Finally check if the usernames match
        if ($userobject[$username]['username'] === $username) {
            echo "true";
        } else {
            echo "false";
        }
    } else {
        echo "false";
    }

    exit();
}