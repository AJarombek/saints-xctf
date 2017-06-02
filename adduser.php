<?php

// Author: Andrew Jarombek
// Date: 5/31/2016 - 6/2/2017
// Controller for Adding a Singed Up User
// Version 0.4 (BETA) - 12/24/2016
// Version 0.5 (FEEDBACK UPDATE) - 1/18/2017
// Version 0.6 (GROUPS UPDATE) - 2/20/2017
// Version 1.0 (OFFICIAL RELEASE) - 6/2/2017

session_start();

// Manual Session Timeout Handling
require_once('session_utils.php');
SessionUtils::lastActivityTime();
SessionUtils::createdTime();

if (isset($_POST['userDetails'])) {

    require_once('models/userclient.php');
    require_once('controller_utils.php');

    $LOG_TAG = "[WEB](adduser.php): ";
    
    // Get all the user details from the post data
    $details = $_POST['userDetails'];
    $username = $details[0];
    $first = $details[1];
    $last = $details[2];
    $email = $details[3];
    $password = $details[4];
    $code = $details[5];

    // Create the salt and hash
    $salt = ControllerUtils::getSalt();
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $userclient = new UserClient();

    $user = "{" .
            "\"username\":\"" . $username . "\"" . 
            ",\"first\":\"" . $first . "\"" . 
            ",\"last\":\"" . $last . "\"" . 
            ",\"email\":\"" . $email . "\"" . 
            ",\"salt\":\"" . $salt . "\"" . 
            ",\"password\":\"" . $hash . "\"" . 
            ",\"activation_code\":\"" . $code . "\"" . "}";

    $userJSON = $userclient->post($user);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Added User object received: " . print_r($userobject, true));
    
    // Return true if insert into database is successful
    // First check to see if the response is valid and if the usernames match
    if ($userobject != null && $userobject['username'] === $username) {
        session_unset();
        error_log($LOG_TAG . 'Sign Up Successful!');
        $_SESSION['user'] = $userobject;
        $_SESSION['username'] = $username;
        $_SESSION['first'] = $first;
        $_SESSION['last'] = $last;
        $_SESSION['last_signin'] = $userobject['last_signin'];
        echo 'true';
        exit();
    } else {
        error_log($LOG_TAG . 'Sign Up FAILED!');
        echo 'false';
        exit();
    }
}