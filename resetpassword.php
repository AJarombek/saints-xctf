<?php

// Author: Andrew Jarombek
// Date: 1/13/2017
// Controller for the forgot password feature

$LOG_TAG = "[WEB](resetpassword.php): ";

// If we are requesting a search for a username associated with an email in the database
if (isset($_GET['email_request'])) {

    require_once('models/userclient.php');
    require_once('controller_utils.php');

    $email = $_GET['email_request'];
    
    $userclient = new UserClient();

    $userJSON = $userclient->get($email);
    $userobject = json_decode($userJSON, true);

    error_log($LOG_TAG . "The Matching User object received: " . print_r($userobject, true));

    if ($userobject != null) {
        // If there is a user associated with this email, we want to send them an email with
        // their confirmation code.  This will be used at step 2 of reset password
        $code = ControllerUtils::sendForgotPasswordEmail($email);

        $keys = array_keys($userobject);
        $user = $userobject[$keys[0]];
        $username = $user['username'];

        // Add the forgot password code to the user object
        $userobject[$username]['fpw_code'] = $code;
        $userJSON = json_encode($userobject);

        error_log($LOG_TAG . "Forgot Password User: " . $username);
        $userJSON = $userclient->put($username, $userJSON);
        $userobject = json_decode($userJSON, true);
        error_log($LOG_TAG . "The Edited User Forgot Password Received: " . print_r($userobject, true));

        if ($userobject != null) {
            error_log($LOG_TAG . "The User Forgot Password was Successfully Edited.");
            echo 'true';
            exit();
        } else {
            error_log($LOG_TAG . "The User Forgot Password was UNSUCCESSFULLY Edited.");
            echo 'false';
            exit();
        }
    } else {
        echo 'false';
        exit();
    }
}