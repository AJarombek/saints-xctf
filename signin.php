<?php

// Author: Andrew Jarombek
// Date: 6/11/2016 - 2/20/2017
// Controller for Authenticating a sign in attempt
// Version 0.4 (BETA) - 12/24/2016
// Version 0.6 (GROUPS UPDATE) - 2/20/2017

require_once('models/userclient.php');

if (isset($_GET['cred'])) {

    session_start();

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
    if ($userobject != null && $userobject['username'] === $username) {

        // Verify that the passwords match
        $salt = $userobject['salt'];
        $hash = $userobject['password'];

        if (password_verify($password, $hash)) {
            // Verified
            session_unset();
            error_log($LOG_TAG . 'Sign In Successful!');
            $_SESSION['user'] = $userobject;
            $_SESSION['username'] = $username;
            $_SESSION['first'] = $userobject['first'];
            $_SESSION['last'] = $userobject['last'];
            $_SESSION['groups'] = $userobject['groups'];
            $_SESSION['last_signin'] = $userobject['last_signin'];

            // We want to update the users last_signin to now
            $userobject['update_signin'] = 'true';
            $userJSON = json_encode($userobject);
            $userclient->put($username, $userJSON);

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

} else if (isset($_GET['localUser'])) {
    session_start();
 
    $username = $_GET['localUser'];

    $userclient = new UserClient();

    $userJSON = $userclient->get($username);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Matching User object received: " . print_r($userobject, true));
    
    // Check to see if the response is valid and if the usernames match
    if ($userobject != null && $userobject['username'] === $username) {

        session_unset();
        error_log($LOG_TAG . 'Local User Restore Successful!');
        $_SESSION['user'] = $userobject;
        $_SESSION['username'] = $username;
        $_SESSION['first'] = $userobject['first'];
        $_SESSION['last'] = $userobject['last'];
        $_SESSION['groups'] = $userobject['groups'];
        $_SESSION['last_signin'] = $userobject['last_signin'];

        // We want to update the users last_signin to now
        $userobject['update_signin'] = 'true';
        $userJSON = json_encode($userobject);
        $userclient->put($username, $userJSON);

        echo 'true';
        exit();

    } else {
        error_log($LOG_TAG . 'Local User Restore FAILED!');
        echo 'false';
        exit();
    }
}