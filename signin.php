<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 
// Controller for Authenticating a sign in attempt

session_start();

if (isset($_GET['cred'])) {

    require_once('models/userclient.php');
    require_once('controller_utils.php');

    $LOG_TAG = "[WEB](signin.php): ";

    // Get credentials from the GET data
    $credentials = $_GET['cred'];
    $username = $credentials[0];
    $password = $credentials[1];

    error_log($LOG_TAG . "The User Trying To Sign In: " . $username);
    
    $userclient = new UserClient();

    $userJSON = $userclient->get($username);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Matching User object received: " . print_r($userobject, true));
    
    // Return true if insert into database is successful
    // First check to see if the response is valid and if the usernames match
    if ($userobject != null && $userobject[$username]['username'] === $username) {

        // Verify that the passwords match
        $salt = $userobject[$username]['salt'];
        $hash = $userobject[$username]['password'];

        if (crypt($password, $hash) == $hash) {
            // Verified
            session_unset();
            error_log($LOG_TAG . 'Sign In Successful!');
            $_SESSION['user'] = $userobject;
            $_SESSION['username'] = $username;
            $_SESSION['first'] = $userobject[$username]['first'];
            $_SESSION['last'] = $userobject[$username]['last'];
            $_SESSION['groups'] = $userobject[$username]['groups'];
            echo 'true';
            exit();
        } else {
            error_log($LOG_TAG . 'Sign In FAILED!');
            echo 'false';
            exit();
        }

    } else {
        error_log($LOG_TAG . 'Sign In FAILED!');
        echo 'false';
        exit();
    }
}