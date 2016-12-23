<?php

// Author: Andrew Jarombek
// Date: 5/31/2016 - 
// Controller for Adding a Singed Up User

session_start();

if (isset($_POST['userDetails'])) {

    require_once('models/userclient.php');
    require_once('controller_utils.php');

    $LOG_TAG = "[WEB](adduser.php): ";
    
    // Get all the user details from the post data
    $details = $_POST['userDetails'];
    $username = $details[0];
    $first = $details[1];
    $last = $details[2];
    $password = $details[3];
    $code = $details[4];

    // Create the salt and hash
    $salt = ControllerUtils::getSalt();
    $hash = crypt($password, '$2y$12$' . $salt);

    $userclient = new UserClient();

    $user = "{\"" . $username . "\":{" .
            "\"username\":\"" . $username . "\"" . 
            ",\"first\":\"" . $first . "\"" . 
            ",\"last\":\"" . $last . "\"" . 
            ",\"salt\":\"" . $salt . "\"" . 
            ",\"password\":\"" . $hash . "\"" . 
            ",\"activation_code\":\"" . $code . "\"" . "}}";

    $userJSON = $userclient->post($user);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Added User object received: " . print_r($userobject, true));
    
    // Return true if insert into database is successful
    // First check to see if the response is valid and if the usernames match
    if ($userobject != null && $userobject[$username]['username'] === $username) {
        session_unset();
        error_log($LOG_TAG . 'Sign Up Successful!');
        $_SESSION['user'] = $userobject;
        $_SESSION['username'] = $username;
        $_SESSION['first'] = $first;
        $_SESSION['last'] = $last;
        echo 'true';
        exit();
    } else {
        error_log($LOG_TAG . 'Sign Up FAILED!');
        echo 'false';
        exit();
    }
}